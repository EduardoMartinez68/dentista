<?php
    include('../../layaout/headerUser.php');
?>



<?php
// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del paciente a eliminar
    $patient_id = $_POST['patient_id'];

    // Preparar la consulta SQL para eliminar el paciente
    $sql = "DELETE FROM patients WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);

    // Ejecutar la consulta y redirigir con el mensaje correspondiente
    if ($stmt->execute()) {
        header("Location: patients.php?success=Usuario eliminado exitosamente");
        exit();
    } else {
        header("Location: patients.php?error=Usuario no eliminado");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>