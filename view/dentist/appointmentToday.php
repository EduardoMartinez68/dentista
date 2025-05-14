<?php
    // Obtener el ID del dentista
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT dentist_id FROM dentists WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dentist = $result->fetch_assoc();
    $dentist_id = $dentist['dentist_id'];

    // Obtener citas del dentista para el día actual
    $current_date = date('Y-m-d');
    $sql = "SELECT a.appointment_id, a.appointment_date, a.status, a.notes, p.name AS patient_name
            FROM appointments a
            JOIN patients p ON a.patient_id = p.patient_id
            WHERE a.dentist_id = ? AND DATE(a.appointment_date) = ?
            ORDER BY a.appointment_date ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $dentist_id, $current_date);
    $stmt->execute();
    $appointments = $stmt->get_result();

    $stmt->close();
    $conn->close();
?>

<body>
<center>
        <div class="table-container">
            <table id="appointmentsTable">
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Paciente</th>
                        <th>Estado</th>
                        <th>Notas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($appointments->num_rows > 0): ?>
                        <?php while ($appointment = $appointments->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                                <td><?= htmlspecialchars($appointment['patient_name']) ?></td>
                                <td><?= htmlspecialchars($appointment['status']) ?></td>
                                <td><?= htmlspecialchars($appointment['notes']) ?></td>
                                <td class="action-buttons">
                                    <a href="../appointments/edit_appointment.php?id=<?= htmlspecialchars($appointment['appointment_id']) ?>" class="edit-button">Editar</a>
                                    
                                    <form action="../appointments/delete_appointment.php?id=<?= htmlspecialchars($appointment['appointment_id']) ?>" method="POST">
                                        <input type="hidden" value="<?= htmlspecialchars($appointment['appointment_id']) ?>" name="appointment_id">
                                        <button class="delete-button" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-results">No se encontraron citas para hoy.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </center>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('appointmentsTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const patientName = cells[1].textContent || cells[1].innerText;
                if (patientName.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
