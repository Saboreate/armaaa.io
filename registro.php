<?php
include 'db.php';

// Verificación si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    // Verificar si la cédula ya está registrada
    $query = $conn->prepare("SELECT * FROM usuarios WHERE cedula = ?");
    $query->bind_param('s', $cedula);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $error = "La cédula ya está registrada.";
    } else {
        // Encriptar la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario
        $query = $conn->prepare("INSERT INTO usuarios (cedula, nombre, password) VALUES (?, ?, ?)");
        $query->bind_param('sss', $cedula, $nombre, $password_hash);

        if ($query->execute()) {
            $mensaje = "Usuario registrado correctamente.";
        } else {
            $error = "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Registrar Usuario</title>
</head>
<body>
    <h1>Registrar Nuevo Usuario</h1>
    <?php if (isset($mensaje)): ?>
        <p class="mensaje"><?= $mensaje ?></p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Registrar Usuario</button>
    </form>
    <a href="login.php">Volver al Login</a>
</body>
</html>

