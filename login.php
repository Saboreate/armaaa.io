<?php
session_start();
include 'db.php';

// Verificación del inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE cedula = ?");
    $query->bind_param('s', $cedula);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            // Registrar la asistencia con fecha y hora actual
            $usuario_id = $usuario['id'];
            $fecha = date('Y-m-d'); // Fecha actual
            $hora = date('H:i:s'); // Hora actual

            // Insertar la asistencia en la tabla
            $insert_asistencia = $conn->prepare("INSERT INTO asistencias (usuario_id, fecha, hora) VALUES (?, ?, ?)");
            $insert_asistencia->bind_param('iss', $usuario_id, $fecha, $hora);
            $insert_asistencia->execute();

            // Guardar los datos en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!-- El resto del código del formulario de login sigue igual -->
