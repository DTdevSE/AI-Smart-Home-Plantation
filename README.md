<!-- PROJECT BANNER -->

<p align="center">

<img src="arduino.jpg" width="800">

</p>

<h1 align="center">
🌱 AI Smart Home Plantation System
</h1>

<p align="center">

AI + IoT Based Smart Plant Monitoring and Disease Detection System

</p>

<p align="center">

<img src="https://img.shields.io/badge/IoT-NodeMCU-green">
<img src="https://img.shields.io/badge/AI-TensorFlow-orange">
<img src="https://img.shields.io/badge/Python-FastAPI-blue">
<img src="https://img.shields.io/badge/Database-MySQL-red">

</p>

---

# 🌿 Project Overview

The **AI Smart Home Plantation System** is an intelligent plant monitoring solution that integrates **IoT sensors, artificial intelligence, and web technology** to help monitor plant health and detect plant diseases automatically.

The system uses **environmental sensors** and **AI-based leaf disease detection** to assist home gardeners in maintaining healthy plants.

---

# 🖥 System Prototype

<p align="center">

<img src="arduino diagrme.png" width="700">

</p>

### Hardware Components

- NodeMCU ESP8266
- Soil Moisture Sensor
- DHT11 Temperature Sensor
- Water Pump
- Smart Light System
- Plant Pot Monitoring

---

# 🧠 AI Plant Disease Detection

The AI model detects **plant leaf diseases using deep learning**.

Main focus diseases:

🍃 Potato Early Blight  
🍃 Potato Late Blight  
🍃 Healthy Leaf Detection

The model analyzes leaf images and predicts plant health conditions.

---

# 🧬 AI Potato Leaf Disease Detection System Workflow

```mermaid
graph TD

A[User Uploads Plant Image] --> B[Image Preprocessing]

B --> C[Leaf Classification Model]

C --> D{Is Potato Leaf?}

D -->|No| E[Display Message: Not a Potato Leaf]

D -->|Yes| F[Disease Detection CNN Model]

F --> G[Disease Prediction]

G --> H[Confidence Score Calculation]

H --> I[AI Recommendation Engine]

I --> J[Suggested Treatment / Fertilizer Advice]

J --> K[Display Final Result to User]
```
# 🌿 AgroBot – AI Agriculture Assistant

AgroBot is an AI-powered agriculture assistant built with **Flask, Ollama AI, and Sentence Transformers**.  
It helps farmers and users get **plant care advice, fertilizer recommendations, and crop information** using natural language questions.

The system also supports **image uploads** to assist with plant disease or crop-related questions.

---

# 🚀 Features

- 🤖 AI agriculture assistant powered by **Ollama LLM**
- 🌱 Plant knowledge retrieval using **semantic search**
- 🧠 Embedding-based similarity search with **Sentence Transformers**
- 🖼 Image upload support for plant-related queries
- 📊 Structured responses formatted in **clean HTML**
- ⚡ Fast API built with **Flask**
- 🌍 CORS enabled for frontend integration

---

# 🧬 System Workflow

```mermaid
graph TD

A[User Message or Image Upload] --> B[Flask API]

B --> C[Retrieve Plant Data From CSV]

C --> D[Semantic Search Using SentenceTransformer]

D --> E[Build Context]

E --> F[Send Prompt to Ollama AI]

F --> G[AI Generates Response]

G --> H[Return HTML Response to Frontend]
```

---


# 🧠 Technologies Used

- Python
- Flask
- Ollama AI
- Sentence Transformers
- Scikit-learn
- Pandas
- HTML / CSS

---

# 🌱 Future Improvements

- Plant disease detection using CNN models
- Weather API integration
- Fertilizer recommendation system
- Mobile-friendly interface
- Multi-language support

---

# 👨‍💻 Author

Developed by Dinitha Thewmika  
AI & Software Development Project
