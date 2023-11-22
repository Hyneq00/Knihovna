<?php
require "../assetss/database.php";
require "../assetss/funkce_kniha.php";
require "../assetss/authorization.php";

$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedInUser()) {
    die("Nepovolený přístup");
}
$id_user = $_SESSION["logged_in_user_id"];
$info = Users::getInfoUser($connection,$id_user);
$borrows = Users::userBorrows($connection, $id_user);
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
    <main>
        <?php require "../assetss/users_header.php" ?>

            <?php if ($info === null ): ?>
                <p> Uživatel nenalezen </p>
            <?php  else: ?>
                <h3>Name: <?=htmlspecialchars($info["first_name"]) ?> </h3>
                <h3>Surname: <?=htmlspecialchars($info["surname"])?></h3>
                <h3>Email: <?=htmlspecialchars($info["email"])?></h3>
            <?php endif ?>
    <h3>My borrow books:</h3>
        <?php if (empty($borrows)):?>
            <p>Nenalezeno</p>
        <?php else: ?>

            <ul>
            <?php foreach($borrows as $one_borrow): ?>
                <div class="ctverec">
                    <h3>Title:<?=htmlspecialchars($one_borrow["title"])?></h3>
                    <h3>Author:<?=htmlspecialchars($one_borrow["author"])?></h3>
                    <h3>Date of borrow:<?=htmlspecialchars($one_borrow["date_of_loan"])?></h3>
                    <h3>Date of return:<?=htmlspecialchars($one_borrow["date_of_return"])?></h3>
                    <?php if($one_borrow["loan_return"] === "true"): ?>
                        <h3>Vráceno:</h3>  <div id="colorSquare" style="width: 50px; height: 50px;background-color: green;"></div>
                    <?php elseif ($one_borrow["loan_return"] === "false"): ?>
                        <h3>Vypůjčeno</h3> <div id="colorSquare" style="width: 50px; height: 50px;background-color: red;"></div>
                    <?php endif ?>
                </div>
            <?php endforeach; ?>
        </ul>
        <?php endif;?>

    </main>


</body>
</html>
