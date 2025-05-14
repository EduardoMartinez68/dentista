<?php
    include('../../layaout/headerUser.php');
?>
<?php
// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $patient_id = $_POST['patient_id'];
    $date = $_POST['appointment_date'];
    $notes = $_POST['notes'] ?? '';
    $user_id = $_SESSION['user_id'];

    // Insertar cita en la base de datos
    $sql = "INSERT INTO appointments (dentist_id, patient_id, appointment_date, status, notes) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $status = 'active';
    $stmt->bind_param("iisss", $user_id, $patient_id, $date, $status, $notes);

    if ($stmt->execute()) {
        $message = "Cita agregada con éxito";
        header("Location: add_appointment.php?success=" . urlencode($message));
        exit();
    } else {
        $error = "Error al agregar la cita";
        header("Location: add_appointment.php?error=" . urlencode($error));
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
