from flask import Flask, render_template, request, jsonify, send_from_directory
from flask_cors import CORS
import os
import pandas as pd
from werkzeug.utils import secure_filename
import requests
from sentence_transformers import SentenceTransformer
import numpy as np
from sklearn.metrics.pairwise import cosine_similarity

# ------------------ Flask Setup ------------------
app = Flask(__name__)
CORS(app)

ASSISTANT_NAME = "AgroBot 🌿"

# ------------------ Upload Settings ------------------
UPLOAD_FOLDER = "static/uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

ALLOWED_EXTENSIONS = {"png", "jpg", "jpeg", "gif"}
app.config["UPLOAD_FOLDER"] = UPLOAD_FOLDER

# ------------------ Load Plant Data ------------------
DATA_FILE = "plant_data.csv"

if os.path.exists(DATA_FILE):
    plant_df = pd.read_csv(DATA_FILE).fillna("")
else:
    plant_df = pd.DataFrame()

def allowed_file(filename):
    return "." in filename and filename.rsplit(".", 1)[1].lower() in ALLOWED_EXTENSIONS

# ------------------ Build Embeddings ------------------
if not plant_df.empty:
    embed_model = SentenceTransformer("all-MiniLM-L6-v2")

    indexed_texts = []
    for _, row in plant_df.iterrows():
        parts = []
        if row.get("plant_name"): parts.append(f"Name: {row['plant_name']}")
        if row.get("type"): parts.append(f"Type: {row['type']}")
        if row.get("care_tips"): parts.append(f"Care: {row['care_tips']}")
        if row.get("best_fertilizer"): parts.append(f"Fertilizer: {row['best_fertilizer']}")
        if row.get("ph_rate"): parts.append(f"pH: {row['ph_rate']}")
        if row.get("weather_forecast"): parts.append(f"Season: {row['weather_forecast']}")
        indexed_texts.append(" | ".join(parts))

    embeddings = embed_model.encode(indexed_texts, convert_to_numpy=True)
else:
    embed_model = None
    indexed_texts = []
    embeddings = []

def retrieve_similar_rows(query, top_k=3):
    if embed_model is None or not indexed_texts:
        return []

    q_emb = embed_model.encode([query], convert_to_numpy=True)
    sims = cosine_similarity(q_emb, embeddings)[0]
    idxs = np.argsort(sims)[::-1][:top_k]

    results = []
    for i in idxs:
        row = plant_df.iloc[i].to_dict()
        row["_snippet"] = indexed_texts[i]
        results.append(row)

    return results

# ------------------ OLLAMA AI FUNCTION ------------------
def ask_ollama(prompt):
    try:
        response = requests.post(
            "http://localhost:11434/api/generate",
            json={
                "model": "gpt-oss:120b-cloud",
                "prompt": prompt,
                "stream": False
            },
            timeout=120
        )

        if response.status_code != 200:
            return "⚠️ AI server error."

        data = response.json()

        return data.get("response", "⚠️ No response from AI.")

    except Exception as e:
        return f"⚠️ Ollama connection error: {e}"

# ------------------ Routes ------------------
@app.route("/")
def aiindex():
    return render_template("aiindex.html", assistant_name=ASSISTANT_NAME)

@app.route("/uploads/<path:filename>")
def uploaded_file(filename):
    return send_from_directory(app.config["UPLOAD_FOLDER"], filename)

# ------------------ CHAT ------------------
@app.route("/chat", methods=["POST"])
def chat():
    user_message = request.json.get("message", "").strip()

    if not user_message:
        return jsonify({"error": "No message provided"}), 400

    # Retrieve related plant data
    top_rows = retrieve_similar_rows(user_message, top_k=2)

    context_text = "\n".join(
        [f"- {r['plant_name']}: {r['_snippet']}" for r in top_rows]
    )

    # 🔥 UPDATED PROMPT FOR CLEAN HTML TABLE OUTPUT
    prompt = f"""
You are AgroBot 🌿, an expert agriculture assistant.

RULES:
- Only answer agriculture-related questions.
- Format structured data using CLEAN HTML.
- Use <h3> for section titles.
- Use <table>, <tr>, <th>, <td> for tabular data.
- Do NOT use markdown tables.
- Keep output clean and professional.

Context:
{context_text}

Question:
{user_message}
"""

    reply_text = ask_ollama(prompt)

    return jsonify({
        "reply": reply_text
    })

# ------------------ IMAGE CHAT ------------------
@app.route("/chat-image", methods=["POST"])
def chat_image():
    message = request.form.get("message", "").strip()
    image = request.files.get("image")

    file_url = None

    if image and allowed_file(image.filename):
        filename = secure_filename(image.filename)
        filepath = os.path.join(app.config["UPLOAD_FOLDER"], filename)
        image.save(filepath)
        file_url = f"/uploads/{filename}"

    prompt = f"""
You are AgroBot 🌿.

User uploaded image path: {file_url or "No image provided"}
User question: {message}

If crop disease or plant issue is visible,
provide agriculture advice.

Format output using clean HTML when needed.
"""

    reply_text = ask_ollama(prompt)

    return jsonify({
        "reply": reply_text,
        "image_path": file_url
    })

# ------------------ RUN ------------------
if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=5000)