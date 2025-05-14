<?php
    include('../../layaout/headerUser.php');

    // Obtener la fecha actual o la fecha del mes seleccionado
    $currentMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
    $currentYear = date('Y', strtotime($currentMonth . '-01'));
    $currentMonth = date('m', strtotime($currentMonth . '-01'));

    // Obtener el primer y último día del mes
    $firstDayOfMonth = date('Y-m-01', strtotime($currentYear . '-' . $currentMonth));
    $lastDayOfMonth = date('Y-m-t', strtotime($currentYear . '-' . $currentMonth));

    // Obtener citas del mes
    $sql = "SELECT appointment_date FROM appointments 
            WHERE dentist_id = ? 
            AND appointment_date BETWEEN ? AND ?
            ORDER BY appointment_date";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $_SESSION['user_id'], $firstDayOfMonth, $lastDayOfMonth);
    $stmt->execute();
    $appointments = $stmt->get_result();

    // Agrupar citas por semana
    $appointmentsByWeek = [];
    while ($row = $appointments->fetch_assoc()) {
        $date = new DateTime($row['appointment_date']);
        $week = $date->format('W'); // Semana del año
        $dayOfWeek = $date->format('l'); // Día de la semana
        $appointmentsByWeek[$week][$dayOfWeek][] = $date;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas del Mes</title>
    <link rel="stylesheet" href="../../css/styles.css"> <!-- Ajustar ruta al CSS -->
    <style>
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .navigation-buttons {
            text-align: center;
            margin-bottom: 20px;
        }

        .button {
            text-decoration: none;
        }
        .week-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .week-card {
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }
        .week-card:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }
        .week-title {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
        }
        .day-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .day-list-item {
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .day-list-item:last-child {
            margin-bottom: 0;
        }
        .day-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .appointment-time {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <center>
    <div class="container">
        <h1>Citas de <?= date('F Y', strtotime($firstDayOfMonth)) ?></h1>

        <!-- Botones de navegación -->
        <div class="navigation-buttons">
            <a href="?month=<?= date('Y-m', strtotime('-1 month', strtotime($firstDayOfMonth))) ?>" class="button">Mes Anterior</a>
            <a href="?month=<?= date('Y-m', strtotime('+1 month', strtotime($firstDayOfMonth))) ?>" class="button">Mes Siguiente</a>
        </div>

        <!-- Mostrar citas por semana -->
        <div class="week-container">
            <?php 
                $weeks = range(1, date('W', strtotime($lastDayOfMonth))); // Semanas del mes
                foreach ($weeks as $week): 
                    if (isset($appointmentsByWeek[$week])): 
            ?>
            <a href="appointments.php?week=<?= $week ?>&month=<?= $currentMonth ?>&year=<?= $currentYear ?>" class="week-card">
                <div class="week-title">Semana <?= $week ?></div>
                <?php foreach ($appointmentsByWeek[$week] as $dayOfWeek => $appointments): ?>
                    <ul class="day-list">
                        <li class="day-list-item">
                            <div class="day-title"><?= $dayOfWeek ?></div>
                            <div class="appointment-time">
                                <?php foreach ($appointments as $appointment): ?>
                                    <?= $appointment->format('H:i') ?><br>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    </ul>
                <?php endforeach; ?>
            </a>
            <?php 
                    endif; 
                endforeach; 
            ?>
        </div>
    </div>
    </center>
</body>
</html>
