<?php
session_start();


if (!isset($_SESSION["usuario_id"])) {

    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    </head>
<body>
    <p>Bem-vindo, <?php echo $_SESSION["usuario_nome"]; ?>!</p>
    </body>
</html>