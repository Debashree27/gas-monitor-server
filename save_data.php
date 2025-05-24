<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$active_output = $_POST['active_output'] ?? null;
$reference_output = $_POST['reference_output'] ?? null;
$pressure = $_POST['pressure'] ?? null;
$temperature = $_POST['temperature'] ?? null;
$humidity = $_POST['humidity'] ?? null;

if ($active_output !== null && $reference_output !== null && $pressure !== null && $temperature !== null && $humidity !== null) {
    $stmt = $conn->prepare("INSERT INTO readings (active_output, reference_output, pressure, temperature, humidity) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdddd", $active_output, $reference_output, $pressure, $temperature, $humidity);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Missing POST data";
}

$conn->close();
?>
