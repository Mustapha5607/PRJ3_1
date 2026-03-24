<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Déconnexion</title>

<style>

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    text-align: center;
    margin-top: 100px;
}

.box {
    background: white;
    width: 400px;
    margin: auto;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
}

h2 {
    color: #333;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

.btn-home {
    background-color: #2E86C1;
    color: white;
}

.btn-home:hover {
    background-color: #1B4F72;
}

.btn-login {
    background-color: #28a745;
    color: white;
}

.btn-login:hover {
    background-color: #1e7e34;
}

</style>

</head>
<body>

<div class="box">

<h2>Déconnexion réussie</h2>

<p>Vous avez quitté l'espace administrateur.</p>

<a href="../index.html">
    <button class="btn-home">Retour à l'accueil</button>
</a>

<br>

<a href="login.php">
    <button class="btn-login">Retour à la page de connextion</button>
</a>

</div>

</body>
</html>