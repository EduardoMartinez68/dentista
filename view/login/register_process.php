<?php
include('../../db.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];

if ($password !== $confirm_password) {
    header("Location: ../../register.php?error=Las contraseñas no coinciden"); // Passwords do not match
    exit();
}

// Encriptar contraseña / Encrypt password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Iniciar transacción / Start transaction
$conn->begin_transaction();

try {
    // Insertar usuario en la tabla users / Insert user into users table
    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'dentist')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();

    // Obtener el ID del usuario insertado / Get the inserted user ID
    $user_id = $stmt->insert_id;

    // Insertar datos en la tabla dentists / Insert data into dentists table
    $sql = "INSERT INTO dentists (user_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Confirmar transacción / Commit transaction
    $conn->commit();

    header("Location: ../../index.php?success=Usuario guardado con éxito"); // User saved successfully
} catch (Exception $e) {
    // Revertir transacción en caso de error / Rollback transaction in case of error
    $conn->rollback();
    header("Location: ../../register.php?error=Error al guardar el usuario"); // Error saving user
}

$stmt->close();
$conn->close();
?>
