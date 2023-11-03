<?php

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
        <h1>Registrace</h1>
        <form action="">
            <input type="text" class="log" placeholder="Jméno"><br>
            <input type="email" class="log" placeholder="E-mail"><br>
            <input type="password" class="log" placeholder="Heslo"><br>
            <input type="password" class="log" placeholder="Heslo znovu"><br>
            <button type="submit" class="button log log_reg_btn">Zaregistrovat</button>
        </form>
</div>
</body>
</html>