<?php
include('../../layaout/headerUser.php');
?>

<style>
    .dashboard-container {
        max-width: 960px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        padding: 2rem;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 1rem;
    }

    .logo {
        display: flex;
        align-items: center;
        font-size: 1.4rem;
        font-weight: 600;
        color: #0066cc;
    }

    .logo-img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .user-info {
        font-size: 1rem;
        color: #333;
    }

    .dashboard-actions {
        margin: 2rem 0;
        display: flex;
        gap: 1rem;
    }

    .btn {
        background-color: var(--company-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn:hover {
        background-color: var(--hover-color);
    }

    .dashboard-calendar h2 {
        font-size: 1.2rem;
        color: rgba(0, 0, 0, 0.8);
        margin-bottom: 0.8rem;
    }

    .appointment-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        transition: 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .appointment .time {
        font-weight: 600;
        font-size: 1.1rem;
        flex: 1;
    }

    .appointment .patient {
        flex: 2;
        font-size: 1rem;
    }

    .appointment .status {
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Estado: Reservado */
    .appointment.reservado {
        background-color: #e3f2fd;
        border-left: 5px solid #2196f3;
    }

    .appointment.reservado .status {
        background-color: #2196f3;
        color: white;
    }

    /* Estado: Cancelado */
    .appointment.cancelado {
        background-color: #ffebee;
        border-left: 5px solid #f44336;
    }

    .appointment.cancelado .status {
        background-color: #f44336;
        color: white;
    }

    /* Estado: Finalizado */
    .appointment.finalizado {
        background-color: #e8f5e9;
        border-left: 5px solid #4caf50;
    }

    .appointment.finalizado .status {
        background-color: #4caf50;
        color: white;
    }

    .time {
        font-weight: bold;
        color: #00796b;
        font-size: 1.1rem;
    }

    .patient {
        color: #333;
        font-size: 1rem;
    }


    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            text-align: left;
        }

        .logo {
            font-size: 1.2rem;
        }

        .logo-img {
            width: 35px;
            height: 35px;
        }

        .dashboard-actions {
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            width: 100%;
            text-align: center;
            font-size: 1rem;
            padding: 0.75rem;
        }

        .appointment-list li {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .appointment .time,
        .appointment .patient,
        .appointment .status {
            flex: none;
            font-size: 1rem;
        }

        .dashboard-calendar h2 {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .logo {
            font-size: 1rem;
        }

        .logo-img {
            width: 30px;
            height: 30px;
        }

        .dashboard-header {
            padding-bottom: 0.75rem;
        }

        .btn {
            font-size: 0.95rem;
            padding: 0.65rem 1rem;
        }

        .appointment .status {
            font-size: 0.85rem;
            padding: 0.25rem 0.6rem;
        }
    }
</style>
<br><br>
<div class="dashboard-container">
    <header class="dashboard-header">
        <div class="logo">
            <img src="https://cdn.pixabay.com/photo/2018/03/22/05/52/dentist-3249382_960_720.png" alt="Logo"
                class="logo-img" />
            <span>DentalSys</span>
        </div>
        <div class="user-info">
            Bienvenido, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        </div>
    </header>

    <div class="dashboard-actions">
        <button class="btn add-client" onclick="location.href='../patients/add_client.php'">Agregar Cliente</button>
        <button class="btn add-appointment" onclick="location.href='../appointment/add_appointment.php'">Agendar Cita</button>
    </div>

    <section class="dashboard-calendar">
        <h2>Citas para hoy - <span id="currentDate"></span></h2>
        <ul class="appointment-list">
            <li class="appointment reservado">
                <span class="time">09:00</span>
                <span class="patient">María López</span>
                <span class="status">Reservado</span>
            </li>
            <li class="appointment cancelado">
                <span class="time">10:30</span>
                <span class="patient">Carlos Gómez</span>
                <span class="status">Cancelado</span>
            </li>
            <li class="appointment finalizado">
                <span class="time">13:00</span>
                <span class="patient">Ana Torres</span>
                <span class="status">Finalizado</span>
            </li>
        </ul>
    </section>

</div>

<br>
<?php
include('appointmentToday.php');
?>