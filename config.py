import os

class Settings:
    API_TITLE = "Plant Disease Detection API"
    API_VERSION = "1.0.0"
    API_DESCRIPTION = "A deep learning API for plant disease identification. Developed by Navindu."
    
    HOST = "0.0.0.0"
    PORT = 8000
    RELOAD = True
    
    BASE_DIR = os.path.dirname(os.path.abspath(__file__)) #gets the current location of the file

    MODEL_PATH = os.path.join(BASE_DIR, "model", "tomato_cnn_model.keras")
    CLASS_NAMES_PATH = os.path.join(BASE_DIR, "class_names.json")
    IMG_SIZE = (224, 224)
    
    MAX_FILE_SIZE = 10 * 1024 * 1024  # max file size 10mb
    ALLOWED_EXTENSIONS = ['.jpg', '.jpeg', '.png', '.bmp']
    
    @property
    def model_loaded(self):
        return os.path.exists(self.MODEL_PATH)
    
    @property
    def classes_loaded(self):
        return os.path.exists(self.CLASS_NAMES_PATH)

settings = Settings()