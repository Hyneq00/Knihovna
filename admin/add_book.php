<?php

require "../assetss/database.php";
$connection = connectiondb();
require "authorization.php";
session_start();

if (!isLoggedIn() ) {
    die("Nepovolený přístup");
}

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $sql = "INSERT INTO kniha (title, author, year_of_publication, genre)
                VALUES(?,?,?,?)";
        $statement = mysqli_prepare($connection, $sql);
        if ($statement === false){
            echo mysqli_error($connection);
        } else {
            mysqli_stmt_bind_param($statement,"ssss", $_POST["title"],$_POST["author"], $_POST["year_of_publication"], $_POST["genre"]);
            if ( mysqli_stmt_execute($statement)){
                $succesfull = "Úspěšně vloženo";
            } else {
                echo mysqli_stmt_execute($statement);
            }
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