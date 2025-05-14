<?php
include('../../layaout/headerUser.php');
?>

<style>
  .container {
    max-width: 600px;
    margin: 60px auto;
    background-color: #ffffff;
    padding: 3rem;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
  }

  .container img{
    display: block;
    margin: 0 auto 1.5rem auto;
    width: 20%;
    height: auto;
  }

  h2 {
    font-size: 2rem;
    font-weight: 600;
    text-align: center;
    margin-bottom: 2.5rem;
    color: #1a1a1a;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }

  .input-group {
    position: relative;
  }

  .input-group input {
    width: 100%;
    font-size: 1rem;
    padding: 1.25rem 0.75rem 0.5rem;
    border: none;
    border-bottom: 2px solid #ccc;
    background: transparent;
    outline: none;
    transition: border-color 0.3s ease;
    font-family: 'DM Sans', sans-serif;
  }

  .input-group input:focus {
    border-color: #0077cc;
  }

  .input-group label {
    position: absolute;
    left: 1rem;
    top: 1.3rem;
    font-size: 1rem;
    font-weight: 400;
    color: #999;
    pointer-events: none;
    transition: all 0.2s ease;
  }

  .input-group input:focus + label,
  .input-group input:not(:placeholder-shown) + label {
    top: 0.3rem;
    font-size: 0.75rem;
    color: #0077cc;
  }

  .button {
    padding: 1rem;
    font-size: 1.1rem;
    background-color: #0077cc;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.25s ease;
  }

  .button:hover {
    background-color: #005fa3;
  }

  @media (max-width: 600px) {
    .container {
      margin: 30px 1rem;
      padding: 2rem;
    }

    h2 {
      font-size: 1.5rem;
    }

    .button {
      font-size: 1rem;
    }
  }
</style>

<div class="container">
  <img src="https://cdn-icons-png.flaticon.com/512/994/994888.png" alt="Clínica Dental">
  <h2>Agregar Cliente</h2>
  <form action="add_client_process.php" method="POST">
    <div class="input-group">
      <input type="text" id="name" name="name" placeholder=" " required>
      <label for="name">Nombre del Cliente</label>
    </div>
    <div class="input-group">
      <input type="email" id="email" name="email" placeholder=" " required>
      <label for="email">Correo Electrónico</label>
    </div>
    <div class="input-group">
      <input type="tel" id="phone" name="phone" placeholder=" " required>
      <label for="phone">Teléfono</label>
    </div>
    <button type="submit" class="button">Agregar Cliente</button>
  </form>

</div>
<br><br><br><br>