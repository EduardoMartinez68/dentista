<?php
    include('../../layaout/headerUser.php');
?>
<body>
    <center>
    <div class="container">
        <img src="https://cdn.pixabay.com/photo/2018/03/22/05/52/dentist-3249382_960_720.png" alt="Clínica Dental" class="logo" width="150">
        <h2>Agregar Cliente</h2>
        <form action="add_client_process.php" method="POST">
            <div class="input-group">
                <label for="name">Nombre del Cliente</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="phone">Teléfono</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <button type="submit" class="button">Agregar Cliente</button>
        </form>
    </div>
    </center>
</body>
</html>
