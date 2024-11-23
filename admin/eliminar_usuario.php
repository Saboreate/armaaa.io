<?php
session_start();
include '../db.php';

// Verificación si el usuario es administrador
if ($_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Obtener todos los usuarios registrados
$query = $conn->query("SELECT * FROM usuarios");
$usuarios = $query->fetch_all(MYSQLI_ASSOC);

// Obtener todas las asistencias
$query_asistencias = $conn->query("SELECT u.nombre, a.fecha, a.hora 
                                   FROM asistencias a 
                                   JOIN usuarios u ON a.usuario_id = u.id
                                   ORDER BY a.fecha DESC, a.hora DESC");
$asistencias = $query_asistencias->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Lista de Usuarios</title>
</head>
<body>
    <h1>Usuarios Registrados</h1>
    <a href="agregar_usuario.php">Agregar Nuevo Usuario</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= $usuario['cedula'] ?></td>
                    <td><?= $usuario['nombre'] ?></td>
                    <td><?= $usuario['rol'] ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?= $usuario['id'] ?>">Editar</a>
                        <a href="eliminar_usuario.php?id=<?= $usuario['id'] ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Asistencias Registradas</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asistencias as $asistencia): ?>
                <tr>
                    <td><?= $asistencia['nombre'] ?></td>
                    <td><?= $asistencia['fecha'] ?></td>
                    <td><?= $asistencia['hora'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
