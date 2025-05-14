<?php
    session_start();
    include('../../db.php');

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar usuario por correo electrónico / Find user by email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Establecer la sesión del usuario / Set user session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'dentist') {
            header("Location: ../dentist/dashboard.php");
            exit();
        } else {
            header("Location: ../patient/dashboard.php");
            exit();
        }
    } else {
        header("Location: ../../login.php?error=Datos del usuario inválidos"); // Invalid user data
        exit();
    }

    $stmt->close();
    $conn->close();
?>
