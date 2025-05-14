<?php
    include('../../layaout/headerUser.php');
?>

<body>
    <center>
    <div class="container">
        <div class="header">
            <img src="https://cdn.pixabay.com/photo/2018/03/22/05/52/dentist-3249382_960_720.png" alt="Clínica Dental" class="logo">
            <h1>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></h1>
        </div>
        <div class="card-container">
            <a href="../patients/add_client.php" class="card">Agregar Cliente</a>
            <a href="../appointment/add_appointment.php" class="card">Agregar Cita</a>
        </div>
        <br>
        <h2>Citas de Hoy</h2>
        <hr>
        <?php
            include('appointmentToday.php');
        ?> 
    </div>
    </center>
</body>
</html>

