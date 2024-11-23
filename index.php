<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';
$usuario_id = $_SESSION['usuario_id'];

// Obtener las asistencias del usuario actual
$query_asistencias = $conn->prepare("SELECT fecha, hora FROM asistencias WHERE usuario_id = ? ORDER BY fecha DESC, hora DESC");
$query_asistencias->bind_param('i', $usuario_id);
$query_asistencias->execute();
$result_asistencias = $query_asistencias->get_result();
$asistencias = $result_asistencias->fetch_all(MYSQLI_ASSOC);

echo "<h1>Bienvenido, " . $_SESSION['nombre'] . "</h1>";
echo "<p>Rol: " . $_SESSION['rol'] . "</p>";

if ($_SESSION['rol'] == 'admin') {
    echo "<a href='admin/usuarios.php'>Administrar Usuarios</a>";
} else {
    echo "<h2>Historial de Asistencias</h2>";
    echo "<table>";
    echo "<thead><tr><th>Fecha</th><th>Hora</th></tr></thead><tbody>";
    foreach ($asistencias as $asistencia) {
        echo "<tr><td>" . $asistencia['fecha'] . "</td><td>" . $asistencia['hora'] . "</td></tr>";
    }
    echo "</tbody></table>";
}
?>
