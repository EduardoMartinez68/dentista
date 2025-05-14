<?php
//her we will see if the user is login
    session_start();
    include('../../db.php'); //get the database

    // we will see if the user is login and the user is a dentist 
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dentist') {
        header("Location: ../../index.php");
        exit();
    }

    $success = isset($_GET['success']) ? $_GET['success'] : '';
    $error = isset($_GET['error']) ? $_GET['error'] : '';
?>



<!--styles-->
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css">
<link rel="stylesheet" href="../../css/dashboard.css">
<link rel="stylesheet" href="../../css/styles.css">
<link rel="stylesheet" href="../../css/navbar.css">
<link rel="stylesheet" href="../../css/tablets.css">
<link rel='stylesheet'
    href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css">


<!--navabar-->
<style>
:root {
    --company-color: #008AC9;
    --company-button: #008AC9;
    --company-button-hover: #008AC9;
    --text-color: white;
    --body-color:#f8f9fa;
    --card-color: #008AC9;
    --button-success:#2e8b57;
    --button-cancel:#dc3545;
    --button-cancel-hover:#c82333;

    
    --color-text-navbar: #008AC9;
    --color-navbar: #EBEAEF;
    --fondo-oscuro: rgba(0, 0, 0, 0.5);
}


  .navbar {
    background-color: var(--company-color);
    padding: 0.7rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    
  }

  .menu-btn {
    background: none;
    border: none;
    font-size: 1.8rem;
    color: white;
    cursor: pointer;
  }

  .logo {
    height: 35px;
  }

  .sidebar {
    position: fixed;
    top: 0;
    left: -260px;
    width: 250px;
    height: 100%;
    background-color: var(--color-navbar);
    padding-top: 60px;
    transition: left 0.3s ease;
    z-index: 1002;
    display: flex;
    flex-direction: column;
  }

  .sidebar a {
    padding: 14px 20px;
    color: white;
    text-decoration: none;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: background 0.2s;
    color: var(--color-text-navbar);
  }

  .sidebar a:hover {
    background-color: rgba(255, 255, 255, 0.15);
  }

  .sidebar .close-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 1.2rem;
    color: var(--color-text-navbar);
  }

  hr {
    border: none;
    height: 1px;
    background: var(--color-text-navbar);
    margin: 15px 0;
  }

  .overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(3px);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 1000;
  }

  .overlay.active {
    opacity: 1;
    pointer-events: all;
  }
</style>

<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-solid-rounded/css/uicons-solid-rounded.css">
<div class="navbar">
  <button class="menu-btn" id="menu-btn">
    <i class="fi fi-sr-menu-burger"></i>
  </button>
  <img src="https://cdn.pixabay.com/photo/2018/03/22/05/52/dentist-3249382_960_720.png" class="logo" alt="Logo">
</div>

<div class="sidebar" id="sidebar">
  <a href="javascript:void(0)" class="close-btn" id="close-btn"><i class="fi fi-sr-cross"></i></a>
  <a href="../../view/dentist/dashboard.php"><i class="fi fi-sr-home"></i> Dashboard</a>
  <a href="../../view/patients/patients.php"><i class="fi fi-sr-users"></i> Pacientes</a>
  <a href="../../view/appointment/appointments.php"><i class="fi fi-sr-calendar"></i> Citas</a>
  <a href="../../view/prescriptions.php"><i class="fi fi-sr-file-medical"></i> Recetas</a>
  <hr>
  <a href="../../view/dentist/profile.php"><i class="fi fi-sr-user"></i> <?= htmlspecialchars($_SESSION['username']) ?></a>
  <a href="../../logout.php"><i class="fi fi-sr-exit"></i> Cerrar Sesión</a>
</div>

<div class="overlay" id="overlay"></div>

<script>
  const menuBtn = document.getElementById('menu-btn');
  const closeBtn = document.getElementById('close-btn');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');

  menuBtn.addEventListener('click', () => {
    sidebar.style.left = '0';
    overlay.classList.add('active');
  });

  closeBtn.addEventListener('click', closeMenu);
  overlay.addEventListener('click', closeMenu);

  function closeMenu() {
    sidebar.style.left = '-260px';
    overlay.classList.remove('active');
  }
</script>


<br><br>


<!-----message----->
<?php
    include('messageFlask.php'); //get the database
?>