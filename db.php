<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dental_clinic";

    // Crear conexión / Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión / Check connection
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>