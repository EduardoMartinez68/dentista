<?php
include('layaout/header.php');

$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<body>
    <br><br>
    <center>
    <div class="container" style="max-width:400px;">
        <img src="https://cdn.pixabay.com/photo/2018/03/22/05/52/dentist-3249382_960_720.png" alt="Clínica Dental" class="logo">
        <h2>Iniciar Sesión</h2>
        
        <?php if ($success): ?>
            <div style="color: green;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <form action="view/login/login_process.php" method="POST">
            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="button">Iniciar Sesión</button>
        </form>
        <a href="register.php" class="register-link">¿No tienes una cuenta? Regístrate aquí</a>
    </div>
    </center>
</body>
</html>
