<?php
$host = "mysql-9xqe.railway.internal";
$user = "root";
$pass = "JjuZBPoQxFdovAkfngmsosZNugvMHOwg";
$dbname = "railway";

$conn = new mysqli($host, $user, $pass, $dbname, 3306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example of inserting data
$active = $_POST['active_output'];
$reference = $_POST['reference_output'];
$pressure = $_POST['pressure'];
$temperature = $_POST['temperature'];
$humidity = $_POST['humidity'];

$sql = "INSERT INTO sensor_data (active_output, reference_output, pressure, temperature, humidity) 
        VALUES ('$active', '$reference', '$pressure', '$temperature', '$humidity')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
