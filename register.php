<?php
include('layaout/header.php');

$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<body>
    <br><br>
    <center>
    <div class="container" style="max-width:400px;">
        <img src="https://cdn.pixabay.com/photo/2018/03/22/05/52/dentist-3249382_960_720.png" alt="Clínica Dental" class="logo">
        <h2>Registro</h2>
        
        <?php if ($error): ?>
            <div style="color: red;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form action="view/login/register_process.php" method="POST">
            <div class="input-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm-password">Repite tu Contraseña</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit" class="button">Registrarse</button>
        </form>
        <br>
        <a href="index.php" class="register-link">¿Ya tienes una cuenta? Inicia Sesion</a>
    </div>
    </center>
</body>
</html>
