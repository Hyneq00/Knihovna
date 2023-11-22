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

$bookID = $_GET["id"];

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($_POST["button"])) {
         $button = $_POST["button"];
         switch ($button) {
             case "no":
                 header("Location: editace_knihy.php?id=$bookID");
                 break;
             case "yes":
                $image= Books::deleteImage($connection,$bookID);
                $image_path = "../uploads/".$image;
                 if (file_exists($image_path)) {
                     unlink($image_path);
                 } else {
                     echo "Obrázek neexistuje";
                 }
                 Books::deleteBook($connection, $bookID);
                header("Location: admin_knihy.php");
                 break;
         }
     }
 }
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Document</title>
</head>
<body>
<?php require "../assetss/admin_header.php" ?>
<section class="logind" >
        <h1>Opravdu chcete smazet knihu?</h1><br><br><br>


    <form action="" method="POST">
        <button type="submit"
                class="button log log_reg_btn"
                name="button"
                value="yes">Ano</button>

        <button type="submit"
                class="button log log_reg_btn"
                name="button"
                value="no">Ne</button><br>
    </form>
</body>
</html>