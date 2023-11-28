<?php
    if (isset($_GET["error"]))
        $error = "Špatně zadané údaje!"
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inputs.css">
    <?php require "../assetss/link_main.php" ?>
    <title>Login</title>
</head>
<body>
<?php require "../assetss/header_main.php" ?>
    <div class="logind" >
        <form class="login-form" action="../admin/log_in.php" method="POST">
            <h1>Login</h1>
            <input type="email" name = "log_email" class="log" placeholder="Email">
        
            <input type="password" name = "log_password" class="log" placeholder="Heslo">
           
            <p class="hlaska"><?= $error ?> </p>
            <button type="submit" >Log in</button>
        </form>
</div>
<div class="my_text"><h2>Admin </h2>
<p>email: hynek@nesvara.cz    heslo: pepa</p><h2>Běžný uživatel </h2>
<p>email: pepino@rolbar.cz   heslo: pepa</p>
</div>
</body>
</html>