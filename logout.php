<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se ha iniciado sesión con una cookie, eliminar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión con un mensaje de éxito
header("Location: index.php?message=Has salido con éxito");
exit();
?>
