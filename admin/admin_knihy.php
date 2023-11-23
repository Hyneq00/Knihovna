<?php
require "../assetss/database.php";
require "../assetss/authorization.php";
require "../assetss/funkce_kniha.php";
$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedInAdmin() ) {
    die("Nepovolený přístup");
}

$books = Books::allBooks($connection)


?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "../assetss/link_admin.php" ?>
    <link rel="stylesheet" href="../css/books.css">
    <title>Document</title>
</head>
<body>
<?php require "../assetss/admin_header.php" ?>
<h1>Seznam všech knih</h1><br>
<?php if (empty($books)):?>
    <p>Nenalezeno</p>
<?php else: ?>
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
                    <div class="info">
                    <h3><a href="kniha.php?id=<?= htmlspecialchars($one_book["id_book"]) ?>">Info</a></h3>
                    </div>
                    
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;?>

</body>
</html>