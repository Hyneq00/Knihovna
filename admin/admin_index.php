<?php
require "../assetss/database.php";
$connection = connectiondb();
require "../assetss/funkce_kniha.php";

if (isset($_POST["hledat"])) {
    $vyber = $_POST['searching'];
    $book = getBook_one($connection, $vyber, $_POST["hledat"]);
    if (empty($book)) {
        if ($vyber === "title") {
            $text = "Hledaná kniha nebyla nalezena";
        } elseif ($vyber === "author") {
            $text = "Hledaný autor nebyl nalezen";
        } elseif ($vyber === "genre") {
            $text = "Hledaný žánr nebyl nalezen";
        }
    }
}


?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/script.js"></script>
    <link rel="stylesheet" type = "text/css" href="../css/header.css">
    <link rel="stylesheet" type = "text/css" href="../css/style.css">
    <title>Document</title>
</head>
<body>
<?php require "../assetss/admin_header.php" ?>
<main>
    <div class="search" >
        <form action="admin_index.php" method="post">
            <input type="radio"   name ="searching" value= "title" checked >Název
            <input type="radio"  name ="searching"    value= "author">Autor
            <input type="radio" name= "searching" value= "genre">Téma <br>
            <input type="text" name="hledat" placeholder="Hledat...">
            <button type="submit" name="vyhledat" value="vyhledat">Vyhledat</button>
            <br>
            <h1 class="no_search"><?= $text ?></h1>
            <br>
            <br>
        </form>
    </div>
    <div class="conteiner">
        <?php foreach($book as $one_book): ?>
            <div class="vysledky">
                <h3>Název:  <?=htmlspecialchars($one_book["title"])?></h3>
                <h3>Autor:  <?=htmlspecialchars($one_book["author"])?></h3>
                <h3>Rok vydání:  <?=htmlspecialchars($one_book["year_of_publication"])?></h3>
                <h3>Žánr:  <?=htmlspecialchars($one_book["genre"])?></h3>
                <br>
                <a href="admin_kniha.php?id=<?=$one_book["id"]?>">Info</a>
                <br>
            </div>
        <?php endforeach; ?>
    </div>


</main>

</body>
</html>