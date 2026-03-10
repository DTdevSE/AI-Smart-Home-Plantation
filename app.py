from fastapi import FastAPI, File, UploadFile, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
import numpy as np
import io
from PIL import Image
import json
import os
import uvicorn

# ================= CONFIG =================
MODEL_PATH = "model/tomato_cnn_model.keras"
CLASS_NAMES_PATH = "model/class_names.json"

IMG_SIZE = (224, 224)
MAX_FILE_SIZE = 5 * 1024 * 1024
CONFIDENCE_THRESHOLD = 0.65

os.environ["TF_CPP_MIN_LOG_LEVEL"] = "2"

# ================= FASTAPI APP =================
app = FastAPI(
    title="Plant Disease Detection API",
    description="Deep Learning API for plant disease identification",
    version="1.0.0"
)

# ================= CORS =================
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# ================= GLOBAL VARIABLES =================
model = None
class_names = []

# ================= LOAD MODEL =================
def load_model_and_classes():
    global model, class_names

    try:
        model = load_model(MODEL_PATH, compile=False)
        print("Model loaded successfully")

        with open(CLASS_NAMES_PATH, "r") as f:
            data = json.load(f)
            class_names = data["class_names"]

        print(f"{len(class_names)} classes loaded")

    except Exception as e:
        print("Error loading model:", e)
        raise e


# ================= IMAGE PREPROCESS =================
def preprocess_image(img: Image.Image):

    img = img.resize(IMG_SIZE)

    img_array = image.img_to_array(img)

    img_array = img_array / 255.0

    img_array = np.expand_dims(img_array, axis=0)

    return img_array


# ================= STARTUP EVENT =================
@app.on_event("startup")
async def startup():
    load_model_and_classes()


# ================= ROOT =================
@app.get("/")
def root():
    return {
        "message": "Plant Disease Detection API",
        "status": "running"
    }


# ================= HEALTH CHECK =================
@app.get("/health")
def health():
    return {
        "model_loaded": model is not None,
        "total_classes": len(class_names)
    }


# ================= GET CLASSES =================
@app.get("/classes")
def classes():
    return {
        "total_classes": len(class_names),
        "classes": class_names
    }


# ================= PREDICT IMAGE =================
@app.post("/predict")
async def predict(file: UploadFile = File(...)):

    if not file.content_type.startswith("image"):
        raise HTTPException(status_code=400, detail="File must be an image")

    contents = await file.read()

    if len(contents) > MAX_FILE_SIZE:
        raise HTTPException(status_code=413, detail="File too large")

    try:

        img = Image.open(io.BytesIO(contents)).convert("RGB")

        processed = preprocess_image(img)

        predictions = model.predict(processed)

        probs = predictions[0]

        predicted_idx = int(np.argmax(probs))

        confidence = float(probs[predicted_idx])

        predicted_class = class_names[predicted_idx]

        # Reject non-leaf images
        if confidence < CONFIDENCE_THRESHOLD:
            return {
                "success": False,
                "message": "Image not recognized as a plant leaf. Please upload a clear leaf image.",
                "confidence": round(confidence * 100, 2)
            }

        # Top 3 predictions
        top_indices = np.argsort(probs)[-3:][::-1]

        results = []

        for idx in top_indices:

            conf = float(probs[idx])

            results.append({
                "class": class_names[idx].replace("_", " "),
                "confidence": conf,
                "percentage": round(conf * 100, 2)
            })

        return {
            "success": True,
            "primary_prediction": results[0],
            "top_predictions": results,
            "image_size": img.size
        }

    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))


# ================= MODEL INFO =================
@app.get("/model-info")
def model_info():

    if model is None:
        raise HTTPException(status_code=500, detail="Model not loaded")

    return {
        "input_shape": model.input_shape,
        "output_shape": model.output_shape,
        "total_classes": len(class_names),
        "classes": class_names
    }


# ================= RUN SERVER =================
if __name__ == "__main__":
    uvicorn.run(
        "app:app",
        host="0.0.0.0",
        port=8000,
        reload=True
    )