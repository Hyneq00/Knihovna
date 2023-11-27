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

if ($_SERVER["REQUEST_METHOD"] === "POST") {

                $image_name = Books::creatBook($connection, $_POST["title"], $_POST["author"], $_POST["year_of_publication"], $_POST["genre"]);
                $last_id = $image_name[0];
                $title = $image_name[1];
                $text = Books::addImage($connection, $last_id, $title, $_FILES["image"] );
                if ($text === "extension") {
                    $succesfull = "Špatný typ souboru";
                } elseif ($text === "size") {
                    $succesfull = "Obrázek je moc veliký";
                } elseif ($text === "error") {
                    $succesfull = "Při nahrávání obrázku nastala chyba";
                } else {
                    $succesfull = "Kniha byla úspěšně nahrána";
                }
}
?>



<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inputs.css">
    <?php require "../assetss/link_admin.php" ?>
    <title>Document</title>
</head>
<body>
    <?php require "../assetss/admin_header.php" ?>
    <main>
        <section class="logind down_add">
            <form class="login-form" action="add_book.php" method="POST" enctype="multipart/form-data">
                <h1>Přidat knihu</h1>

                <input type="text"
                       name="title"
                       placeholder="Title"
                       required>
                <input type="text"
                       name="author"
                       placeholder="Author"
                       required>
                <input type="text"
                       name="year_of_publication"
                       placeholder="Year of publication"
                       required>
                <input type="text"
                       name="genre"
                       placeholder="Genre"
                       required>

                <input type="file" name="image">

                <h3> <?= $succesfull ?> </h3><br>
                <button type="submit"
                        class="button log log_reg_btn"
                        value="Přidat">Přidat</button>
            </form>

        </section>
    </main>
</body>
</html>