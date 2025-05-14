<?php
    include('../../layaout/headerUser.php');
?>
<?php
    // Obtener el ID del dentista
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM dentists WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dentist = $result->fetch_assoc();
    $dentist_id = $dentist['dentist_id'];

    // Obtener pacientes del dentista
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $sql = "SELECT p.patient_id, p.name, p.email , p.phone
            FROM patients p
            JOIN users u ON p.user_id = u.user_id
            WHERE u.email LIKE ?";

    $searchTerm = "%{$search}%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $patients = $stmt->get_result();

    $stmt->close();
    $conn->close();
?>

<body>
<center>
    <div class="container">
        <h1>Lista de Pacientes</h1>
        <div class="search-group">
            <input type="text" id="searchInput" placeholder="Buscar por email" onkeyup="filterTable()">
            <a href="../patients/add_client.php" class="add-button">Agregar Nuevo Cliente <i class="fi fi-sr-user-add"></i></a>
        </div>
        <div class="table-container">
            <table id="patientsTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Telefono/Celular</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($patients->num_rows > 0): ?>
                        <?php while ($patient = $patients->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($patient['name']) ?></td>
                                <td><?= htmlspecialchars($patient['email']) ?></td>
                                <td><?= htmlspecialchars($patient['phone']) ?></td>
                                <td class="action-buttons">
                                    <a href="../patients/edit_patient.php?id=<?= htmlspecialchars($patient['patient_id']) ?>" class="edit-button">Editar</a>
                                    
                                    <form action="../patients/delete_patient.php?id=<?= htmlspecialchars($patient['patient_id']) ?>" method="POST">
                                        <input type="hidden" value="<?= htmlspecialchars($patient['patient_id']) ?>" name="patient_id">
                                        <button class="delete-button" onclick="return confirm('¿Estás seguro de que deseas eliminar este paciente?');">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-results">No se encontraron resultados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>
    </center>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('patientsTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const email = cells[2].textContent || cells[2].innerText;
                if (email.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
