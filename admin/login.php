<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = $_POST["user"] ?? "";
    $pass = $_POST["pass"] ?? "";

    if ($user === "admin" && $pass === "1234") {

        $_SESSION["admin"] = true;

        header("Location: index.php");
        exit;

    } else {

        $error = "Identifiants incorrects";

    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Login Admin</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-5" style="max-width:400px">

<h2>Connexion Admin</h2>

<?php if ($error): ?>

<div class="alert alert-danger">
<?= $error ?>
</div>

<?php endif; ?>

<form method="post">

<input
type="text"
name="user"
class="form-control mb-3"
placeholder="Login"
required>

<input
type="password"
name="pass"
class="form-control mb-3"
placeholder="Mot de passe"
required>

<button class="btn btn-primary w-100">
Connexion
</button>

</form>

</div>

</body>
</html>