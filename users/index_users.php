<?php
require "../assetss/database.php";
require "../assetss/funkce_kniha.php";
require  "../assetss/authorization.php";

$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedInUser() ) {
    die("Nepovolený přístup");
}
if (isset($_POST["hledat"])) {
    $vyber = $_POST['searching'];
    $book = Books::getBook_one($connection, $vyber, $_POST["hledat"]);
    if (empty($book)) {
        if ($vyber === "title") {
            $text = "The wanted book was not found";
        } elseif ($vyber === "author") {
            $text = "The wanted author was not found";
        } elseif ($vyber === "genre") {
            $text = "The wanted genre was not found";
        }
    } elseif ($book === "error") {
        $text = "Error: Chyba při připojení k  databázi";
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
<?php require "../assetss/users_header.php" ?>
<main>
    <div class="search" >
        <form action="index_users.php" method="post">
            <input type="radio"   name ="searching" value= "title" checked >Title
            <input type="radio"  name ="searching"    value= "author">Author
            <input type="radio" name= "searching" value= "genre">Genre <br>
            <input type="text" name="hledat" placeholder="Search...">
            <button type="submit" name="vyhledat" value="vyhledat">Search</button>
            <br>
            <h1 class="no_search"><?= $text ?></h1>
            <br>
            <br>
        </form>
    </div>
    <div class="conteiner">
        <?php foreach($book as $one_book): ?>
            <div class="vysledky">
                <?php
                $imagePath = "../uploads/".$one_book["image"];
                // Kontrola, zda je soubor k dispozici
                if (file_exists($imagePath) && $imagePath !== "../uploads/" ) {
                    echo '<img src="'.$imagePath.'" alt="Muj Obrazek">';
                } else {
                    // Pokud chybi fotka, zobraz jinou
                    echo '<img src="../uploads/001.png" alt="Alternativni Obrazek">';
                }
                ?>
                <br>
                <h3>Title:  <?=htmlspecialchars($one_book["title"])?></h3>
                <h3>Author:  <?=htmlspecialchars($one_book["author"])?></h3>
                <h3>Year of publication:  <?=htmlspecialchars($one_book["year_of_publication"])?></h3>
                <h3>Genre:  <?=htmlspecialchars($one_book["genre"])?></h3>
                <br>
                <?php if($one_book["avaliable"] === "true"): ?>
                    <h3>Dostupnost:</h3>  <div id="colorSquare" style="width: 50px; height: 50px;background-color: green;"></div>
                <?php elseif ($one_book["avaliable"] === "false"): ?>
                    <h3>Dostupnost:</h3> <div id="colorSquare" style="width: 50px; height: 50px;background-color: red;"></div>
                <?php endif ?>
                <br>
                <a href="kniha_users.php?id=<?=$one_book["id_book"]?>">Info</a>
                <br>
            </div>
        <?php endforeach; ?>
    </div>


</main>

</body>
</html>