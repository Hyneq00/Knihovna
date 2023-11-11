<?php
    if (isset($_GET["error"]))
        $error = $_GET["error"]
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js"></script>
    <link rel="stylesheet" type = "text/css" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <?php require "assetss/header.php" ?>
    <div class="logind" >
    <h1>Přihlášení</h1>
        <form action="admin/log_in.php" method="POST">
            <input type="email" name = "log_email" class="log" placeholder="Email">
            <br>
            <input type="password" name = "log_password" class="log" placeholder="Heslo">
            <br>
            <p class="hlaska"><?= $error ?> </p>
            <br>
            <button type="submit" class="log log_reg_btn">Přihlasit</button>


        </form>
</div>
</body>
</html>