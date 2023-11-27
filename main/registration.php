<?php

session_start();
 if ($_SESSION["email-exist"] === "true"){
     $email_exist_text = "Email je již zaregistrovaný";
     $_SESSION["email-exist"] = "";
 }
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inputs.css">
    <link rel="stylesheet" href="../css/registration.css">
    <?php require "../assetss/link_main.php" ?>
    <title>Document</title>
</head>
<body>
<?php require "../assetss/header_main.php" ?>
 
    <div class="logind down" >
        <form action="../admin/registration_after.php" method="POST" class="login-form">
            <h1>Registrace</h1>
            <input type="text"
                   name="first_name"
                   required
                   placeholder="Jméno">
            <input type="text"
                   name="surname"
                   required
                   placeholder="Přijmení">
            <input type="email"
                   name="email"
                   required
                   placeholder="E-mail">
            <input type="password"
                   id="password"
                   class="password"
                   name="password"
                   pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$"
                   required
                   placeholder="Heslo">
            <span id="password-info">
                Heslo musí obsahovat alespoň jedno malé písmeno, jedno velké písmeno, alespoň jednu číslici a být alespoň 8 znaků dlouhé.
            </span>
            <input type="password"
                   class="passwordControl"
                   name = password_confirm
                   required
                   placeholder="Heslo znovu">
            <p class="error_password_text"></p>
            <p id="email_exist"><?= $email_exist_text ?></p>
            <button type="submit"
                    id = "submit"
                    class="">Zaregistrovat</button>
            <button type="submit"
                id = "submit_wrong"
                class="">Zaregistrovat</button>
        </form>
        
</div>
    <script src="../js/script.js" ></script>
</body>
</html>