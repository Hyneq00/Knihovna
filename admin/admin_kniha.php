<?php
require "../assetss/database.php";
require "../assetss/funkce_kniha.php";
require "../assetss/authorization.php";

$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedInAdmin() ) {
    die("Nepovolený přístup");
}

if ( is_numeric($_GET["id"]) and isset($_GET["id"]) ){
    $book = Books::getBook($connection,$_GET["id"]);
} else {
    $book = null;
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/one_book.css">
    <?php require "../assetss/link_admin.php" ?>
    <title>Document</title>
</head>
<body>
<?php require "../assetss/admin_header.php";?>
<section>
    <?php if ($book === null ): ?>
        <p> Book was not founded. </p>
    <?php  else: ?>
        <div class="book">
        <?php
            $imagePath = "../uploads/".$book["image"];
            // Kontrola, zda je soubor k dispozici
            if (file_exists($imagePath) && $imagePath !== "../uploads/" ) {
                echo '<img src="'.$imagePath.'" alt="Muj Obrazek">';
            } else {
                // Pokud chybi fotka, zobraz jinou
                echo '<img src="../uploads/001.png" alt="Alternativni Obrazek">';
            }
            ?>
        <?php endif ?>
        <table>
            <tbody>
                <tr>
                    <th><h2>Author:</h2></th>
                    <td><h3><?=htmlspecialchars($book["title"])?></h3></td>
                </tr>
                <tr>
                    <th><h2>Title:</h2></th>
                    <td><h3><?=htmlspecialchars($book["author"])?></h3></td>
                </tr>
                <tr>
                    <th><h2>Year of publication:</h2></th>
                    <td><h3><?=htmlspecialchars($book["year_of_publication"])?></h3></td>
                </tr>
                <tr>
                    <th><h2>Genre:</h2></th>
                    <td><h3><?=htmlspecialchars($book["genre"])?></h3></td>
                </tr>
                <tr>
                    <th><h2>Dostupnost:</h2></th>
                    <td><?php if($book["avaliable"] === "true"): ?>
                    <div class="colorSquare" style="background-color: green;"></div>
                    <?php elseif ($book["avaliable"] === "false"): ?>
                    <div class="colorSquare" style="background-color: red;"></div>
                    <?php endif ?>
                    </td>
                </tr>
                
    
            </tbody>
        </table>
        </div>
        <div class="info">
                    <h3><a href="editace_knihy.php?id=<?= htmlspecialchars($book["id_book"]) ?>">Edit</a></h3>
                    </div>
</section>



</body>
</html>
