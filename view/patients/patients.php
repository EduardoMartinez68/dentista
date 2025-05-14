<?php
    include('../../layaout/headerUser.php');
?>


<?php
    //get the id of the dentist
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM dentists WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dentist = $result->fetch_assoc();
    $dentist_id = $dentist['dentist_id'];

    //get all the patients of the dentist
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



<style>
/* Fuente base moderna */
body {
  font-family: 'Inter', sans-serif;
  background-color: #f4f6f8;
  color: #333;
}

/* Contenedor principal */
.container {
  max-width: 80%;
  margin: 3rem auto;
  padding: 2rem;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
}

/* Título */
.container h1 {
  font-size: 2rem;
  text-align: center;
  color:var(--company-color);
  margin-bottom: 2rem;
}

/* Barra de búsqueda + botón */
.search-group {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 2rem;
}

.search-group input[type="text"] {
  flex: 1;
  padding: 12px 16px;
  border: 1px solid #d0d7de;
  border-radius: 10px;
  font-size: 16px;
  transition: border-color 0.3s ease;
}

.search-group input:focus {
  outline: none;
  border-color: #1976d2;
  box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.add-button {
  padding: 12px 18px;
  background: linear-gradient(135deg, #1976d2, #42a5f5);
  color: white;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 600;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.add-button:hover {
  box-shadow: 0 6px 20px rgba(25, 118, 210, 0.3);
}

/* Tabla moderna */
.table-container {
  overflow-x: auto;
  border-radius: 12px;
}

#patientsTable {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 10px;
}

#patientsTable thead {
  background: #e3f2fd;
}

#patientsTable th {
  text-align: left;
  padding: 14px 20px;
  font-size: 15px;
  color: black;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

#patientsTable td {
  background: #ffffff;
  padding: 14px 20px;
  border-bottom: 1px solid #f0f0f0;
  border-radius: 8px;
  font-size: 15px;
}

/* Fila al pasar el mouse */
#patientsTable tbody tr:hover td {
  background-color: #f4faff;
  transition: background-color 0.3s ease;
}

/* Acciones */
.action-buttons {
  display: flex;
  gap: 10px;
}

.edit-button,
.delete-button {
  padding: 8px 14px;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.edit-button {
  background-color: #42a5f5;
  color: white;

}

.edit-button:hover {
  background-color: #1e88e5;
}

.delete-button {
  background-color: #ef5350;
  color: white;
}

.delete-button:hover {
  background-color: #e53935;
}

/* Sin resultados */
.no-results {
  text-align: center;
  font-style: italic;
  color: #999;
  padding: 20px;
}

/* Responsive */
@media screen and (max-width: 768px) {
  .search-group {
    flex-direction: column;
  }

  .action-buttons {
    flex-direction: column;
  }

  #patientsTable th,
  #patientsTable td {
    padding: 10px;
  }

  .add-button {
    width: 100%;
    text-align: center;
  }
}

</style>


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
                                    <a href="../patients/edit_patient.php?id=<?= htmlspecialchars($patient['patient_id']) ?>" class="edit-button"><i class="fi fi-sr-pencil"></i></a>
                                    
                                    <form action="../patients/delete_patient.php?id=<?= htmlspecialchars($patient['patient_id']) ?>" method="POST">
                                        <input type="hidden" value="<?= htmlspecialchars($patient['patient_id']) ?>" name="patient_id">
                                        <button class="delete-button" onclick="return confirm('¿Estás seguro de que deseas eliminar este paciente?');"><i class="fi fi-ss-trash"></i></button>
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
