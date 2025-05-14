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
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">


<?php
    include('navbar.php'); //get the database
    include('messageFlask.php'); //get the database
?>
