<?php
require "assetss/database.php";
$connection = connectiondb();

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/script.js"></script>
    <link rel="stylesheet" type = "text/css" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <?php require "assetss/header.php" ?>
    <main>
    <div class="search" >
        <form action="index.php" method="post">
            <input type="radio"   name ="searching" value= "name" checked >Název
            <input type="radio"  name ="searching"    value= "author">Autor
            <input type="radio" name= "searching" value= "genre">Téma <br>
            <input type="text" name="hledat" placeholder="Hledat...">
            <button type="submit" name="vyhledat" value="vyhledat">Vyhledat</button>
        </form>
    </div>
    

    </main>

</body>
</html>