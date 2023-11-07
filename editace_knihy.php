<?php
    require "assetss/database.php";
    require "assetss/funkce_kniha.php";

    $connection = connectiondb();

    if (isset($_GET["id"]) ){
        $one_book = getBook($connection,$_GET["id"]);
        if ($one_book){
            $title = $one_book["title"];
            $author = $one_book["author"];
            $year_of_publication = $one_book["year_of_publication"];
            $genre = $one_book["genre"];
            $id = $one_book["id"];
        }  else {
            die ("Kniha Nenalezena");
        }

    } else {
        die ("ID není zadáno, kniha nebyla nalezena");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $author = $_POST["author"];
        $year_of_publication = $_POST["year_of_publication"];
        $genre = $_POST["genre"];
        updateBook($connection, $title, $author, $year_of_publication, $genre, $id);
        $text = "Informace byli úspěšně změněny";
    }

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <?php require "assetss/header.php" ?>
        <section class="logind" >
            <form action="editace_knihy.php?id=<?=$one_book['id']?>" method="POST">
                <h1>Upravit knihu</h1><br>


                <input type="text"
                       name="title"
                       placeholder="Název"
                       value="<?= htmlspecialchars($title) ?>"
                       required
                        >
                        <br>
                <input type="text"
                       name="author"
                       placeholder="Autor"
                       required
                       value="<?=htmlspecialchars($author)?>"">
                <br>
                <input type="text"
                       name="year_of_publication"
                       placeholder="Rok vydání"
                       required
                       value="<?= htmlspecialchars($year_of_publication) ?>"" >
                <br>
                <input type="text"
                       name="genre"
                       placeholder="Žánr"
                       required
                       value="<?= htmlspecialchars($genre) ?>"><br>
                <button type="submit"
                        class="button log log_reg_btn"
                        name="update"
                        value="pridat">Uložit</button>
                <br><br>
                <button type="submit"
                        class="button log log_reg_btn"
                        name="delete"
                        value="pridat">Smazat knihu</button><br>
                <p id="zobrazText" ><?=$text?></p>
                <script>
                    //Nastavení času zobrazení textu, který se objevý po uložení infomací knihy
                    var zobrazTextElement = document.getElementById("zobrazText");

                    // Zobraz text po dobu 5 sekund (5000 ms)
                    setTimeout(function() {
                        zobrazTextElement.style.display = "none";
                    }, 3000);
                </script>


            </form>
    </main>

</body>
</html>