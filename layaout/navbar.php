<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css">
<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
  }

  .navbar {
    background-color: #6AC6E8;
    padding: 0.5rem 1rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
  }

  .nav-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: auto;
  }

  .logo {
    height: 40px;
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .nav-links a {
    text-decoration: none;
    color: white;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 10px;
    border-radius: 5px;
    transition: background 0.3s;
  }

  .nav-links a:hover {
    background-color: rgba(255, 255, 255, 0.2);
  }

  .menu-toggle {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: white;
    cursor: pointer;
    display: none;
  }

  @media (max-width: 768px) {
    .menu-toggle {
      display: block;
    }

    .nav-links {
      width: 100%;
      flex-direction: column;
      display: none;
      margin-top: 10px;
    }

    .nav-links.active {
      display: flex;
    }

    .nav-links a {
      padding: 10px;
      justify-content: flex-start;
    }
  }
</style>


<nav class="navbar">
  <div class="nav-container">
    <img src="https://cdn.pixabay.com/photo/2018/03/22/05/52/dentist-3249382_960_720.png" alt="Clínica Dental" class="logo">
    <button class="menu-toggle" id="mobile-menu">
      <i class="fi fi-sr-menu-burger"></i>
    </button>
    <div class="nav-links" id="nav-links">
      <a href="../../view/dentist/dashboard.php"><i class="fi fi-sr-home"></i> Dashboard 2</a>
      <a href="../../view/tablets/patients.php"><i class="fi fi-sr-users"></i> Pacientes</a>
      <a href="appointments.php"><i class="fi fi-sr-calendar"></i> Citas</a>
      <a href="prescriptions.php"><i class="fi fi-sr-file-medical"></i> Recetas</a>
      <a href="profile.php"><i class="fi fi-sr-user"></i> <?= htmlspecialchars($_SESSION['username']) ?></a>
      <a href="../../logout.php"><i class="fi fi-sr-exit"></i> Cerrar Sesión</a>
    </div>
  </div>
</nav>

<script>
  document.getElementById('mobile-menu').addEventListener('click', function () {
    document.getElementById('nav-links').classList.toggle('active');
  });
</script>
