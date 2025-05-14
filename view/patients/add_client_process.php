<?php
    include('../../layaout/headerUser.php');
?>
<?php
    // Obtener datos del formulario / Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $user_id = $_SESSION['user_id'];

    // Insertar cliente en la base de datos / Insert client into the database
    $sql = "INSERT INTO patients (user_id, name, email, phone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $name, $email, $phone);

    if ($stmt->execute()) {
        header("Location: ../patients/add_client.php?success=Cliente agregado con éxito");
        exit();
    } else {
        header("Location: ../patients/add_client.php?error=Error al agregar el cliente");
        exit();
    }

    $stmt->close();
    $conn->close();
?>
