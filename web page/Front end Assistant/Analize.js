const fileInput = document.getElementById("fileInput");
const uploadBtn = document.getElementById("uploadBtn");
const analyzeBtn = document.getElementById("analyzeBtn");

const previewContainer = document.getElementById("previewContainer");
const imagePreview = document.getElementById("imagePreview");

const resultsSection = document.getElementById("resultsSection");
const loadingIndicator = document.getElementById("loadingIndicator");

let selectedFile = null;

uploadBtn.onclick = () => fileInput.click();

fileInput.onchange = () => {

selectedFile = fileInput.files[0];

const reader = new FileReader();

reader.onload = e => {

imagePreview.src = e.target.result;

previewContainer.classList.remove("hidden");
analyzeBtn.classList.remove("hidden");

};

reader.readAsDataURL(selectedFile);

};

analyzeBtn.onclick = async () => {

loadingIndicator.classList.remove("hidden");

const formData = new FormData();
formData.append("file", selectedFile);

try{

const response = await fetch(
"http://127.0.0.1:8000/predict",
{
method:"POST",
body:formData
});

const data = await response.json();

loadingIndicator.classList.add("hidden");
resultsSection.classList.remove("hidden");

const prediction = data.primary_prediction;

const disease = prediction.class.replace(/_/g," ");
const confidence = prediction.percentage;

document.getElementById("diseasePrediction").innerText = disease;
document.getElementById("diseaseConfidence").innerText =
"Confidence: "+confidence+"%";

if(disease.toLowerCase().includes("healthy"))
{

document.getElementById("healthStatus").innerText="Healthy Plant";

}
else
{

document.getElementById("healthStatus").innerText="Disease Detected";

}

document.getElementById("healthConfidence").innerText =
"Confidence: "+confidence+"%";

const recList = document.getElementById("recommendationList");

recList.innerHTML="";

let recs=[];

if(disease.includes("Early blight"))
{

recs=[
"Remove infected leaves",
"Use fungicide spray",
"Avoid overhead watering"
];

}
else if(disease.includes("Late blight"))
{

recs=[
"Use copper fungicide",
"Improve air circulation",
"Remove infected plants"
];

}
else if(disease.includes("healthy"))
{

recs=[
"Plant is healthy",
"Maintain watering",
"Monitor plant regularly"
];

}
else
{

recs=[
"Monitor plant condition",
"Remove infected leaves",
"Consult agriculture expert"
];

}

recs.forEach(r=>{

const li=document.createElement("li");

li.innerText=r;

recList.appendChild(li);

});

document.getElementById("detailedAnalysis").innerHTML=
"<b>Disease:</b> "+disease+"<br>"+
"<b>Confidence:</b> "+confidence+"%<br>"+
"The AI model analyzed the plant leaf image.";

}
catch(err)
{

loadingIndicator.classList.add("hidden");

alert("AI server connection error");

console.error(err);

}

};