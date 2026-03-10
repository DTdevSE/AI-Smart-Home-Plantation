<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","final_project");

$user_id = $_SESSION['user_id'];

$q = mysqli_query($conn,"SELECT name, profile_pic FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HomePlant IOT Dashboard</title>
   <!-- Title -->
    <title>Home - Gardening &amp; plantation HTML Template</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --bg: linear-gradient(135deg, #dfffe0, #c7f0cf, #b1e3ba);
      --card-bg: rgba(255, 255, 255, 0.25);
      --accent: #46d26f;
      --text: #0b2d1c;
      --muted: #3c5a4b;
    }
    * { margin:0; padding:0; box-sizing:border-box;  }
    body { min-height:100vh; background:var(--bg); color:var(--text); display:flex; flex-direction:column; }
    header { display:flex; justify-content:space-between; align-items:center; padding:1rem 2rem; background:rgba(255,255,255,0.4); border-bottom:1px solid rgba(255,255,255,0.5); backdrop-filter:blur(15px); box-shadow:0 4px 20px rgba(0,0,0,0.1); }
    .user { display:flex; align-items:center; gap:.6rem; font-weight:400; color:var(--muted); }
    .user img { width:42px; height:42px; border-radius:50%; border:2px solid var(--accent); box-shadow:0 0 8px rgba(70,210,111,0.6); }

    .dashboard { padding:2rem; display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:1.5rem; }
    .card { background:var(--card-bg); border:1px solid rgba(255,255,255,0.4); border-radius:18px; text-align:center; padding:1.5rem 1rem; box-shadow:0 8px 25px rgba(0,0,0,0.1); backdrop-filter:blur(20px); transition:all 0.3s ease; }
    .card:hover { transform:translateY(-5px) scale(1.02); box-shadow:0 12px 30px rgba(0,0,0,0.15); }
    .card h3 { font-size:0.95rem; color:var(--muted); margin-bottom:0.8rem; letter-spacing:0.5px; }
    .card .value { font-size:1.9rem; font-weight:600; color:var(--accent); margin-top:0.8rem; text-shadow:0 0 6px rgba(70,210,111,0.6); }

    .control-panel { background: rgba(255,255,255,0.25); border-radius: 18px; padding: 2rem; margin: 2rem; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.4); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .control-panel h2 { color: #46d26f; margin-bottom: 1.5rem; font-weight: 600; }
    .control-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; }
    .device-card { background: rgba(255,255,255,0.35); border-radius: 15px; padding: 1.5rem; backdrop-filter: blur(18px); border: 1px solid rgba(255,255,255,0.4); box-shadow: 0 6px 15px rgba(0,0,0,0.08); transition: 0.3s ease; }
    .device-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.12); }
    .device-header { display: flex; justify-content: space-between; align-items: center; }
    .device-header h3 { font-size: 1rem; color: #256b3e; }
    .status-indicator { padding: 0.3rem 0.7rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; color: white; }
    .status-indicator.on { background: #46d26f; box-shadow: 0 0 10px rgba(70,210,111,0.7); }
    .status-indicator.off { background: #9ca3af; }
    .desc { color: #365a45; font-size: 0.85rem; margin-top: 0.4rem; margin-bottom: 0.8rem; }
    .switch { position: relative; display: inline-block; width: 60px; height: 30px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 30px; }
    .slider:before { position: absolute; content: ""; height: 22px; width: 22px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background-color: #46d26f; box-shadow: 0 0 10px rgba(70,210,111,0.7); }
    input:checked + .slider:before { transform: translateX(30px); }
    .time-control { margin-top: 1rem; font-size: 0.85rem; color: #234e33; background: rgba(255,255,255,0.4); padding: 0.6rem; border-radius: 10px; border: 1px solid rgba(255,255,255,0.5); }
    .time-control div { display: flex; justify-content: space-between; margin: 2px 0; }
    footer { text-align:center; padding:1.5rem; color:var(--muted); font-size:0.9rem; }
    .value{
  font-size:1.9rem;
  font-weight:600;
  color:#46d26f;
  margin-top:0.8rem;
  text-shadow:0 0 6px rgba(70,210,111,0.6);
  transition:all 0.4s ease;
}

/* Pulse animation when updated */
.value.updated{
  transform:scale(1.1);
  text-shadow:0 0 14px #46d26f;
}

/* Nice glow for high values */
.value.high{ color:#ff6b6b; text-shadow:0 0 12px #ff6b6b; }
.value.medium{ color:#ffc107; text-shadow:0 0 12px #ffc107; }
.value.low{ color:#46d26f; }

  </style>
</head>

<body>
   <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="img/core-img/leaf.png" alt="">
        </div>
    </div>
  <header>
   <div class="user">

  <span>
     <?php echo htmlspecialchars($user['name']); ?>
  </span>

  <?php if(!empty($user['profile_pic'])){ ?>
      <img src="uploads/<?php echo $user['profile_pic']; ?>" alt="User">
  <?php } else { ?>
      <img src="img/core-img/leaf.png" alt="User">
  <?php } ?>

  <div style="margin-top:20px;text-align:center;margin-left:150vh;">
            <a href="index.php">Home</a> |
            <a href="logout.php" style="color:red;">Logout</a>
        </div>


</div>

  </header>
<div id="alertBox" style="
  background:#46d26f;
  color:white;
  padding:12px;
  text-align:center;
  font-weight:600;
  font-size:16px;
">
✅ Monitoring Active — All conditions normal
</div>
  <!-- Sensor Cards -->
  <div class="dashboard">
    <div class="card">
      <h3>Soil Moisture</h3>
      <canvas id="moistureChart" height="100"></canvas>
      <div class="value" id="moistureVal">0%</div>
    </div>
    <div class="card">
      <h3>Humidity</h3>
      <canvas id="humidityChart" height="100"></canvas>
      <div class="value" id="humidityVal">0%</div>
    </div>
    <div class="card">
      <h3>Light Intensity</h3>
      <canvas id="lightChart" height="100"></canvas>
      <div class="value" id="lightVal">0 lx</div>
    </div>
    <div class="card">
      <h3>Temperature</h3>
      <canvas id="tempChart" height="100"></canvas>
      <div class="value" id="tempVal">0°C</div>
    </div>
  </div>

  <!-- Manual Controls -->
  <!-- Manual Controls -->
<section class="control-panel">
  <h2>🧠 Smart Control Panel</h2>

  <div class="control-grid">

    <!-- MODE -->
    <div class="device-card">
      <div class="device-header">
        <h3>🧠 Mode</h3>
        <div class="status-indicator on" id="modeStatus">AUTO</div>
      </div>

      <label class="switch">
        <input type="checkbox" id="modeSwitch">
        <span class="slider"></span>
      </label>
    </div>

    <!-- PUMP -->
    <div class="device-card">
      <div class="device-header">
        <h3>💧 Water Pump</h3>
        <div class="status-indicator off" id="pumpStatus">OFF</div>
      </div>

      <p class="desc">Automated soil watering system</p>

      <label class="switch">
        <input type="checkbox" id="pumpSwitch">
        <span class="slider"></span>
      </label>
    </div>

    <!-- LIGHT -->
    <div class="device-card">
      <div class="device-header">
        <h3>💡 Grow Lights</h3>
        <div class="status-indicator off" id="lightStatus">OFF</div>
      </div>

      <p class="desc">Maintains optimal light for plant growth</p>

      <label class="switch">
        <input type="checkbox" id="lightSwitch">
        <span class="slider"></span>
      </label>
    </div>

  </div>
</section>

  <footer>© 2025 HomePlant AI — Smart IoT Gardening Interface</footer>
  <script>


// ======================================================
// 🌱 SENSOR DATA + MONITORING
// ======================================================

async function loadSensorData() {

  const res = await fetch("get_data.php");
  const data = await res.json();

  if(data.error) return;

  const soil = parseInt(data.soil_value);
  const hum  = parseInt(data.humidity);
  const temp = parseInt(data.temperature);
  const light= parseInt(data.ldr_value);

  // ===== Update values =====
  document.getElementById("moistureVal").innerText = soil + "%";
  document.getElementById("humidityVal").innerText = hum + "%";
  document.getElementById("lightVal").innerText    = light + " lx";
  document.getElementById("tempVal").innerText     = temp + " °C";

  // ⭐ UPDATE METERS
  updateGauges(data);


  // ===============================
  // 🌱 SMART MONITORING
  // ===============================

  if(soil > 70){
    showAlert("⚠️ Soil is DRY — Water needed!");
    highlight("moistureVal","high");
  } else if(soil > 40){
    highlight("moistureVal","medium");
  } else {
    highlight("moistureVal","low");
  }

  if(temp > 35){
    showAlert("🔥 Temperature too high!");
    highlight("tempVal","high");
  } else if(temp > 25){
    highlight("tempVal","medium");
  } else {
    highlight("tempVal","low");
  }

  if(hum < 30){
    showAlert("💧 Low humidity detected!");
    highlight("humidityVal","high");
  }

  updateDeviceStatus("pumpStatus", data.pump_status);
  updateDeviceStatus("lightStatus", data.light_status);
}


// ======================================================
// 🎨 UI HELPERS
// ======================================================

function highlight(id, level){

  const el = document.getElementById(id);
  el.classList.remove("high","medium","low");
  if(level === "high") el.classList.add("high");
  if(level === "medium") el.classList.add("medium");
  if(level === "low") el.classList.add("low");
}

function showAlert(msg){
  document.getElementById("alertBox").innerText = msg;
}

function updateDeviceStatus(id, status){

  const el = document.getElementById(id);
  el.innerText = status;

  if(status === "ON"){
    el.classList.remove("off");
    el.classList.add("on");
  } else {
    el.classList.remove("on");
    el.classList.add("off");
  }
}


// ======================================================
// 🧠 AUTO / MANUAL CONTROL SYSTEM
// ======================================================

const pumpOnHour  = 6;
const pumpOffMin  = 10;
const lightOnHour  = 7;
const lightOffHour = 19;

function sendControl(){

  const modeSwitch  = document.getElementById("modeSwitch");
  const pumpSwitch  = document.getElementById("pumpSwitch");
  const lightSwitch = document.getElementById("lightSwitch");

  let mode = modeSwitch.checked ? "MANUAL" : "AUTO";
  let pump = "OFF";
  let light = "OFF";

  if(mode === "AUTO"){

    const now = new Date();
    const hour = now.getHours();
    const min  = now.getMinutes();

    if(hour === pumpOnHour && min < pumpOffMin) pump = "ON";
    if(hour >= lightOnHour && hour < lightOffHour) light = "ON";

    pumpSwitch.checked  = (pump === "ON");
    lightSwitch.checked = (light === "ON");

    pumpSwitch.disabled  = true;
    lightSwitch.disabled = true;

  } else {

    if(modeSwitch.dataset.prev !== "MANUAL"){
      pumpSwitch.checked  = false;
      lightSwitch.checked = false;
    }

    pumpSwitch.disabled  = false;
    lightSwitch.disabled = false;

    pump  = pumpSwitch.checked  ? "ON" : "OFF";
    light = lightSwitch.checked ? "ON" : "OFF";
  }

  modeSwitch.dataset.prev = mode;

  document.getElementById("modeStatus").innerText  = mode;
  document.getElementById("pumpStatus").innerText  = pump;
  document.getElementById("lightStatus").innerText = light;

  fetch("update_control.php",{
    method:"POST",
    headers:{"Content-Type":"application/x-www-form-urlencoded"},
    body:`mode=${mode}&pump=${pump}&light=${light}`
  });
}


// ======================================================
// 🔁 AUTO UPDATES
// ======================================================

document.getElementById("modeSwitch").addEventListener("change",sendControl);
document.getElementById("pumpSwitch").addEventListener("change",sendControl);
document.getElementById("lightSwitch").addEventListener("change",sendControl);

setInterval(loadSensorData, 2000);  // sensor data
setInterval(sendControl, 60000);    // timer control

loadSensorData();
sendControl();

</script>
<script>

// ======================================================
// 🌱 GLOBAL SETTINGS
// ======================================================

let alertActive = false;
let lastMailTime = 0;

const reminderInterval = 15 * 60 * 1000; // 15 minutes (ms)


// ======================================================
// 🌱 LIVE AJAX + REAL IOT MONITORING
// ======================================================

function loadSensorData(){

  const xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function(){

    if(this.readyState === 4 && this.status === 200){

      const data = JSON.parse(this.responseText);

      const soil = parseInt(data.soil_value);
      const hum  = parseInt(data.humidity);
      const temp = parseInt(data.temperature);
      const ldr  = parseInt(data.ldr_value);

      // ==========================
      // 🔄 DISPLAY VALUES
      // ==========================

      document.getElementById("moistureVal").innerText = soil + "%";
      document.getElementById("humidityVal").innerText = hum + "%";
      document.getElementById("tempVal").innerText     = temp + " °C";
      document.getElementById("lightVal").innerText    = (ldr == 1 ? "Dark" : "Bright");

      updateDeviceStatus("pumpStatus", data.pump_status);
      updateDeviceStatus("lightStatus", data.light_status);


      // ==========================
      // 🚨 PLANT SAFETY CHECK
      // ==========================

      let alerts = [];

      if(soil > 900){
        alerts.push("🔥 Soil EXTREMELY DRY — Immediate watering needed!");
      }
      else if(soil > 600){
        alerts.push("⚠️ Soil Dry");
      }
      else if(soil < 250){
        alerts.push("⚠️ Soil Too Wet — Root rot risk!");
      }

      if(temp > 40){
        alerts.push("🔥 Critical heat danger!");
      }
      else if(temp > 32){
        alerts.push("🌡️ High temperature stress");
      }
      else if(temp < 12){
        alerts.push("❄️ Too cold for plants");
      }

      if(hum < 25){
        alerts.push("💧 Air too dry");
      }
      else if(hum > 85){
        alerts.push("🦠 Excess humidity — disease risk");
      }

      if(ldr == 1){
        alerts.push("🌑 Dark environment — Light required");
      }


      // ==========================
      // 📢 ALERT + REMINDER SYSTEM
      // ==========================

      const alertBox = document.getElementById("alertBox");

      if(alerts.length > 0){

        const msg = alerts.join(" | ");

        alertBox.innerText = msg;
        alertBox.style.background = "#ff4d4d";

        const now = Date.now();

        // 🚨 First alert OR 15-min reminder
        if(!alertActive || now - lastMailTime >= reminderInterval){

          sendAlertMail(msg);
          alertActive = true;
          lastMailTime = now;

        }

      } else {

        alertBox.innerText = "✅ Plant conditions are safe";
        alertBox.style.background = "#46d26f";

        // Reset system
        alertActive = false;
      }

    }
  };

  xhr.open("GET","get_data.php",true);
  xhr.send();
}


// ======================================================
// 📧 SEND ALERT EMAIL (AJAX)
// ======================================================

function sendAlertMail(message){

  fetch("send_mail.php", {
    method: "POST",
    headers: {
      "Content-Type":"application/x-www-form-urlencoded"
    },
    body: "msg=" + encodeURIComponent(message)
  })
  .then(res => res.text())
  .then(data => console.log("Mail:", data))
  .catch(err => console.error("Mail Error:", err));

}




// ======================================================
// 🔁 LIVE UPDATE
// ======================================================

setInterval(loadSensorData, 2000);
loadSensorData();

</script>

<script>
  //////////////////////////////////////////////////////////////////////////
function sendAlertMail(){

  fetch("send_mail.php")
    .then(res => res.text())
    .then(data => console.log("Mail:", data))
    .catch(err => console.error(err));

}
</script>

   <!-- ##### All Javascript Files ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</body>
</html>
