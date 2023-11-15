<?php
require "../assetss/database.php";
require "../assetss/authorization.php";
require "../assetss/funkce_kniha.php";


$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedIn() ) {
    die("Nepovolený přístup");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $add = Books::creatBook($connection, $_POST["title"], $_POST["author"], $_POST["year_of_publication"], $_POST["genre"]);
    if ($add) {
        $succesfull = "Kniha byla úspěšně přidána";
    }
}


?>



<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
    <?php require "../assetss/admin_header.php" ?>
    <main>
        <section class="logind" >
            <form action="add_book.php" method="POST">
                <h1>Přidat knihu</h1>

                <input type="text"
                       name="title"
                       placeholder="Název"
                       required>
                <br>
                <input type="text"
                       name="author"
                       placeholder="Autor"
                       required>
                <br>
                <input type="text"
                       name="year_of_publication"
                       placeholder="Rok vydání"
                       required>
                <br>
                <input type="text"
                       name="genre"
                       placeholder="Žánr"
                       required><br>

                <h3> <?= $succesfull ?> </h3><br>
                <button type="submit"
                        class="button log log_reg_btn"
                        value="Přidat">Přidat</button>
            </form>

            <div class="added">
                <h3><?= $_POST["title"] ?></h3>
                <h3><?= $_POST["author"] ?></h3>
                <h3><?= $_POST["year_of_publication"] ?></h3>
                <h3><?= $_POST["genre"] ?></h3>
            </div>

        </section>
    </main>
</body>
</html>