<?php
    include('../../layaout/headerUser.php');

    // Configurar la localización a español
    setlocale(LC_TIME, 'es_ES.UTF-8');

    // Obtener el ID del dentista
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT dentist_id FROM dentists WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dentist = $result->fetch_assoc();
    $dentist_id = $dentist['dentist_id'];

    // Obtener la semana actual desde el parámetro GET, o la semana actual si no está definido
    $week = isset($_GET['week']) ? intval($_GET['week']) : date('W');
    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y'); // Año actual

    // Calcular las fechas del inicio y fin de la semana seleccionada
    $start_of_week = new DateTime();
    $start_of_week->setISODate($year, $week);
    $end_of_week = clone $start_of_week;
    $end_of_week->modify('next Sunday');

    $start_of_week_str = $start_of_week->format('Y-m-d');
    $end_of_week_str = $end_of_week->format('Y-m-d');

    // Obtener citas del dentista para la semana actual
    $sql = "SELECT a.appointment_id, a.appointment_date, a.status, a.notes, p.name AS patient_name
            FROM appointments a
            JOIN patients p ON a.patient_id = p.patient_id
            WHERE a.dentist_id = ? AND DATE(a.appointment_date) BETWEEN ? AND ?
            ORDER BY a.appointment_date ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $dentist_id, $start_of_week_str, $end_of_week_str);
    $stmt->execute();
    $appointments = $stmt->get_result();

    $stmt->close();
    $conn->close();

    // Crear un array para almacenar las citas por día de la semana
    $appointments_by_day = [
        'Monday' => [],
        'Tuesday' => [],
        'Wednesday' => [],
        'Thursday' => [],
        'Friday' => [],
        'Saturday' => [],
        'Sunday' => []
    ];

    // Clasificar las citas por día de la semana
    while ($appointment = $appointments->fetch_assoc()) {
        $day_of_week = date('l', strtotime($appointment['appointment_date']));
        $appointments_by_day[$day_of_week][] = $appointment;
    }

    // Calcular la semana anterior y la siguiente
    $prev_week = $week - 1;
    $next_week = $week + 1;
    $prev_year = $year;
    $next_year = $year;

    // Ajustar el año si es necesario
    if ($prev_week < 1) {
        $prev_week = 52;
        $prev_year--;
    }
    if ($next_week > 52) {
        $next_week = 1;
        $next_year++;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Citas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        .week-range {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            color: #666;
        }
        .week-range a {
            text-decoration: none;
            color: #007bff;
            font-size: 20px;
            margin: 0 10px;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .card {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 45%;
            margin: 10px 0;
            padding: 20px;
        }
        .card-header {
            font-size: 20px;
            margin-bottom: 10px;
            color: #007bff;
        }
        .appointment {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #f4f4f4;
        }
        .appointment:last-child {
            border-bottom: none;
        }
        .appointment-info {
            display: flex;
            flex-direction: column;
        }
        .appointment-info span {
            font-size: 16px;
            color: #555;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .view-button, .edit-button, .delete-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
        }
        .view-button {
            background-color: #007bff;
        }
        .edit-button {
            background-color: #28a745;
        }
        .delete-button {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Citas de la Semana</h1>
        <div class="week-range">
            <a href="?week=<?= $prev_week ?>&year=<?= $prev_year ?>" class="nav-button"><i class="fa fa-chevron-left"></i></a>
            <?= strftime('%d de %B', strtotime($start_of_week_str)) ?> al <?= strftime('%d de %B', strtotime($end_of_week_str)) ?>
            <a href="?week=<?= $next_week ?>&year=<?= $next_year ?>" class="nav-button"><i class="fa fa-chevron-right"></i></a>
        </div>
        <div class="card-container">
            <?php
                $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                foreach ($days_of_week as $day): 
                    $date = new DateTime();
                    $date->setISODate($year, $week);
                    $date->modify("next $day");
                    $date_str = $date->format('Y-m-d');
                    $day_in_spanish = strftime('%A %d', strtotime($date_str));
            ?>
                <div class="card">
                    <div class="card-header"><?= ucfirst($day_in_spanish) ?></div>
                    <?php if (isset($appointments_by_day[$day]) && !empty($appointments_by_day[$day])): ?>
                        <?php foreach ($appointments_by_day[$day] as $appointment): ?>
                            <div class="appointment">
                                <div class="appointment-info">
                                    <span><?= strftime('%d de %B %Y', strtotime($appointment['appointment_date'])) ?></span>
                                    <span><?= htmlspecialchars($appointment['patient_name']) ?></span>
                                    <span><?= htmlspecialchars($appointment['status']) ?></span>
                                    <span><?= htmlspecialchars($appointment['notes']) ?></span>
                                </div>
                                <div class="action-buttons">
                                    <a href="../appointments/edit_appointment.php?id=<?= htmlspecialchars($appointment['appointment_id']) ?>" class="edit-button">Editar</a>
                                    <form action="../appointments/delete_appointment.php?id=<?= htmlspecialchars($appointment['appointment_id']) ?>" method="POST">
                                        <input type="hidden" value="<?= htmlspecialchars($appointment['appointment_id']) ?>" name="appointment_id">
                                        <button class="delete-button" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="appointment">
                            <div class="appointment-info">
                                <span>No se encontraron citas para <?= $day_in_spanish ?>.</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html
