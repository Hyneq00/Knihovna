<?php
 require "assetss/database.php";
 require "assetss/funkce_kniha.php";
$database = new Database();
$connection = $database->connectiondb();

$book = Books::creatBook($connection, "pepa", "marie a josef", "@#$", "jajxs");
var_dump($book);
var_dump($connection);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

</body>
</html>
