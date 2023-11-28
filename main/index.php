<?php
require "../assetss/database.php";
require "../assetss/funkce_kniha.php";

$database = new Database();
$connection = $database->connectiondb();
$books = [];
$role = $_SESSION["role"];

if (isset($_POST["hledat"])) {
    $vyber = $_POST['searching'];
    $books = Books::getBook_one($connection, $vyber, $_POST["hledat"]);
    if (empty($books)) {
        if ($vyber === "title") {
            $text = "The wanted book was not founded";
        } elseif ($vyber === "author") {
            $text = "The wanted author was not founded";
        } elseif ($vyber === "genre") {
            $text = "The wanted genre was not founded";
        }
    } elseif ($books === "error") {
        $text = "Error: Chyba při připojení k  databázi";
    }
}

?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "../assetss/link_main.php" ?>
    <link rel="stylesheet" text=""href="../css/style_search.css">
    <link rel="stylesheet" href="../css/books.css">
    <title>Main page</title>
</head>
<body>
    <?php require "../assetss/header_main.php" ?>
    <main>
    <div class="search" >
        <form action="index.php" method="post">
            <input type="radio"   name ="searching" value= "title" checked >Title
            <input type="radio"  name ="searching"    value= "author">Author
            <input type="radio" name= "searching" value= "genre">Genre
            <br>
            <input type="text" name="hledat" placeholder="Search...">
            <button type="submit" name="vyhledat" value="vyhledat">Search</button>
            <br>
            <h1 class="no_search"><?= $text ?></h1>
            <br>
            <br>
        </form>
    </div>
        <div class="container">
            <?php foreach($books as $one_book): ?>
                <div class="result">
                    <?php
                    $imagePath = "../uploads/".$one_book["image"];
                    $imageSource = file_exists($imagePath) && $imagePath !== "../uploads/" ? $imagePath : "../uploads/001.png";
                    ?>
                    <img src="<?= $imageSource ?>" alt="Book Image">

                    <div class="info-container">
                        <div class="name-container">
                            <span class="left-name"><h3>Title:</h3></span>
                            <span class="right-name"><h2><?= htmlspecialchars($one_book["title"]) ?></h2></span>
                        </div>
                        <div class="name-container">
                            <span class="left-name"><h3>Author:</h3></span>
                            <span class="right-name"><h2><?= htmlspecialchars($one_book["author"]) ?></h2></span>
                        </div>

                        <div class="name-container">
                            <span class="left-name"><h3>Year of publication:</h3></span>
                            <span class="right-name"><h2><?= htmlspecialchars($one_book["year_of_publication"]) ?></h2></span>
                        </div>
                        <div class="name-container">
                            <span class="left-name"><h3>Dostupnost:</h3></span>
                            <span class="right-name"><div class="colorSquare" style="background-color: <?= $one_book["avaliable"] === "true" ? "green" : "red" ?>"></div></span>
                        </div>
                        <div class="info"><h3><a href="kniha.php?id=<?= htmlspecialchars($one_book["id_book"]) ?>">Info</a></h3>
                    </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>