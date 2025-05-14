<?php
ob_start();
    include('../../layaout/headerUser.php');
?>


<?php
//we will see if the user send the data to form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    //update the data of the customer
    $sql = "UPDATE users u
            JOIN patients p ON u.user_id = p.user_id
            SET p.email = ?, p.name = ?, p.phone = ?
            WHERE p.patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $email, $name, $phone, $patient_id);
    

    //we will see if can update the customer with success
    if ($stmt->execute()) {
        header("Location: patients.php?success=Paciente actualizado con éxito");
    } else {
        echo "Error al actualizar el paciente.";
    }

    //close the database
    $stmt->close();
    $conn->close();
} else {
    header("Location: patients.php");
}
ob_end_flush();
?>