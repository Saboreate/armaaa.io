<?php
$host = 'localhost';
$user = 'root';  // Cambia si tu base de datos tiene otra configuración
$password = '';  // Cambia si es necesario
$database = 'armapack';

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar si hay errores de conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
