<?php
require "../assetss/database.php";
$connection = connectiondb();
require "../assetss/funkce_kniha.php";
require "authorization.php";
session_start();

if (!isLoggedIn() ) {
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
                 deleteBook($connection, $bookID);
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