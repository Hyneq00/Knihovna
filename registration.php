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
        <form action="admin/registration_after.php" method="POST">
            <input type="text"
                   name="first_name"
                   class="log"
                   required
                   placeholder="Jméno"><br>
            <input type="text"
                   name="surname"
                   class="log"
                   required
                   placeholder="Přijmení"><br>
            <input type="email"
                   name="email"
                   class="log"
                   required
                   placeholder="E-mail"><br>
            <input type="password"
                   class="log password"
                   name="password"
                   required
                   placeholder="Heslo"><br>
            <input type="password"
                   class="log passwordControl"
                   required
                   placeholder="Heslo znovu">
            <br>
            <p class="error_password_text"></p>
            <br>

            <button type="submit"
                    class="button log log_reg_btn">Zaregistrovat</button>
        </form>
</div>
    <script src="js/script.js" ></script>
</body>
</html>