<?php
    include('../../layaout/headerUser.php');
?>

<?php
// Verificar si el usuario está logueado y es un dentista
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dentist') {
    header("Location: ../../index.php");
    exit();
}

// Obtener el ID del paciente desde el parámetro de URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view_patients.php");
    exit();
}

$patient_id = (int)$_GET['id'];

// Obtener la información del paciente
$sql = "SELECT p.patient_id, p.name, p.email, p.phone
        FROM patients p
        JOIN users u ON p.user_id = u.user_id
        WHERE p.patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: view_patients.php");
    exit();
}

$patient = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<body>
    <center>
    <div class="container">
        <h1>Editar Paciente</h1>
        <form action="update_patient.php" method="POST">
            <input type="hidden" name="patient_id" value="<?= htmlspecialchars($patient['patient_id']) ?>">
            <div class="input-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($patient['name']) ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($patient['email']) ?>" required>
            </div>
            <div class="input-group">
                <label for="phone">Teléfono</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($patient['phone']) ?>" required>
            </div>
            <div class="input-group">
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Guardar Cambios" class="button">
                    </div>
                    <br>
                    <div class="col">
                        <input type="button" value="Cancelar" onclick="window.location.href='patients.php'" class="delete-button">
                    </div>
                </div>
            </div>
        </form>
    </div>
    </center>
</body>
</html>
