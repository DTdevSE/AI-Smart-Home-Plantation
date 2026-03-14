<!-- PROJECT BANNER -->

<p align="center">

<img src="docs/system-setup.png" width="800">

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

<img src="docs/system-setup.png" width="700">

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

# 🧬 AI Model Workflow

```mermaid
graph TD

A[Leaf Image Upload]
B[Image Preprocessing]
C[Deep Learning Model]
D[Disease Prediction]
E[Display Result]

A --> B
B --> C
C --> D
D --> E
