<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ================= DB CONNECTION =================
$conn = mysqli_connect("localhost","root","","smart_farm");

if(!$conn){
    die("DB Connection Failed");
}

// ================= GET LATEST SENSOR DATA =================
$result = mysqli_query($conn,"
    SELECT * FROM farm_data
    ORDER BY id DESC
    LIMIT 1
");

$data = mysqli_fetch_assoc($result);

$temp  = $data['temperature'] ?? 'N/A';
$hum   = $data['humidity'] ?? 'N/A';
$soil  = $data['soil_value'] ?? 'N/A';
$ldr   = $data['ldr_value'] ?? 0;
$light = $data['light_status'] ?? 'OFF';
$pump  = $data['pump_status'] ?? 'OFF';
$mode  = $data['mode'] ?? 'AUTO';

$lightText = ($ldr == 1) ? "Dark" : "Bright";

// ================= INCLUDE PHPMailer =================
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// ================= ALERT MESSAGE =================
$msg = $_POST['msg'] ?? "Plant risk detected";

date_default_timezone_set("Asia/Colombo");
$time = date("Y-m-d H:i:s");

$mail = new PHPMailer(true);

try {

    // ================= SMTP SETTINGS =================
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dinithabc2001@gmail.com';
    $mail->Password   = 'fapqskoummfkjicy'; // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // ================= SENDER & RECEIVER =================
    $mail->setFrom('dinithabc2001@gmail.com', 'HomePlant IoT');
    $mail->addAddress('dithewmika@gmail.com');

    // ================= EMAIL CONTENT =================
    $mail->isHTML(true);
    $mail->Subject = '🚨 HomePlant Smart Alert — Immediate Attention Required';

    $mail->Body = "
<div style='font-family:Segoe UI,Arial,sans-serif;
            background:#f2f6f3;
            padding:20px;
            border-radius:12px;
            max-width:600px;
            margin:auto;
            border:1px solid #dfe8e1'>

    <div style='text-align:center;padding-bottom:10px'>
        <h1 style='color:#2e7d32;margin:0'>🌿 HomePlant Smart System</h1>
        <p style='color:#777;margin:5px 0'>Real-Time Plant Monitoring Alert</p>
    </div>

    <hr style='border:none;border-top:1px solid #e0e0e0'>

    <div style='background:#fdecea;
                border-left:6px solid #d9534f;
                padding:12px;
                border-radius:8px;
                margin-top:15px'>

        <h2 style='color:#d9534f;margin:0'>⚠️ Plant Risk Detected</h2>
        <p><strong>Status:</strong> $msg</p>
        <p style='color:#555'><strong>Time:</strong> $time</p>
    </div>

    <h3 style='color:#2e7d32;margin-top:20px'>🌱 Current Sensor Readings</h3>

    <table style='width:100%;border-collapse:collapse;background:white'>
        <tr style='background:#e8f5e9;font-weight:bold'>
            <td style='padding:10px'>🌡 Temperature</td>
            <td style='padding:10px'>$temp °C</td>
        </tr>
        <tr>
            <td style='padding:10px'>💧 Humidity</td>
            <td style='padding:10px'>$hum %</td>
        </tr>
        <tr style='background:#f9f9f9'>
            <td style='padding:10px'>🌱 Soil Moisture</td>
            <td style='padding:10px'>$soil</td>
        </tr>
        <tr>
            <td style='padding:10px'>💡 Light Condition</td>
            <td style='padding:10px'>$lightText</td>
        </tr>
        <tr style='background:#f9f9f9'>
            <td style='padding:10px'>🚰 Pump Status</td>
            <td style='padding:10px'>$pump</td>
        </tr>
        <tr>
            <td style='padding:10px'>🧠 Mode</td>
            <td style='padding:10px'>$mode</td>
        </tr>
    </table>

    <div style='margin-top:18px;
                padding:12px;
                background:#e3f2fd;
                border-radius:8px'>
        ⚡ Please check your IoT dashboard immediately to prevent plant damage.
    </div>

    <p style='font-size:12px;color:#888;text-align:center;margin-top:20px'>
        — HomePlant Smart Monitoring System<br>
        Automated IoT Alert Notification
    </p>

</div>
";

    $mail->send();

    echo "Mail Sent";

} catch (Exception $e) {

    echo "Mail Error: {$mail->ErrorInfo}";
}
?>