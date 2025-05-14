<?php
    include('../../layaout/headerUser.php');
?>
<style>
    .select-patient {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
        font-family: 'Arial', sans-serif;
        background-color: #f8f8f8;
        appearance: none; /* Remove default arrow in most browsers */
        background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4.09 6.8"><path d="M.15 5.55l.35.35 1.5 1.5.35.35.35-.35 1.5-1.5.35-.35-.35-.35L2.35 3.7l-1.5-1.5-.35-.35-.35.35-1.5 1.5-.35.35z" fill="%23777"/></svg>');
        background-repeat: no-repeat;
        background-position: right 10px top 50%;
        background-size: 12px 12px;
    }

    .select-patient:focus {
        border-color: var(--company-color);
        outline: none;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
    }

    .select-patient option {
        padding: 10px;
    }
    .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            resize: vertical;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.12), inset 0 -1px 0 rgba(0,0,0,0.07);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-group textarea:focus {
            border-color: #6AC6E8;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.12), inset 0 -1px 0 rgba(0,0,0,0.07), 0 0 5px rgba(106,198,232,0.5);
            outline: none;
        }

        .input-group textarea::placeholder {
            color: #bbb;
        }
</style>
<?php
    // Obtener el ID del dentista
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM dentists WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dentist = $result->fetch_assoc();

    // Obtener pacientes para el formulario
    $sql = "SELECT * FROM patients";
    $patients = $conn->query($sql);

    $stmt->close();
    $conn->close();
?>

<body>
    <center>
    <div class="container">
        <h1>Agregar Cita</h1>
        <form action="add_appointment_process.php" method="POST">
            <div class="input-group">
                <label for="patient_id">Paciente</label>
                <select id="patient_id" name="patient_id" required class="select-patient">
                    <option value="">Selecciona un paciente</option>
                    <?php while ($patient = $patients->fetch_assoc()): ?>
                        <option value="<?= $patient['patient_id'] ?>"><?= htmlspecialchars($patient['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="input-group">
                <label for="appointment_date">Fecha y Hora de la Cita</label>
                <input type="datetime-local" id="appointment_date" name="appointment_date" required>
            </div>
            <div class="input-group">
                <label for="notes">Notas</label>
                <textarea type="text" id="notes" name="notes"></textarea>
            </div>
            <button type="submit" class="button">Agendar Cita</button>
        </form>
    </div>
    </center>
</body>
</html>
