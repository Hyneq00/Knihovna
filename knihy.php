<?php require "assetss/database.php";
$connection = connectiondb();

$sql = "SELECT * FROM kniha";
$result = mysqli_query($connection, $sql);
if($result === false){
    echo mysqli_error($connection);
} else{
    $book = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type = "text/css" href="css/header.css">
    <title>Document</title>
</head>
<body>
<?php require "assetss/header.php" ?>
    <h1>Seznam všech knih</h1>
    <?php if (empty($book)):?>
            <p>Nenalezeno</p>
    <?php else: ?><ul>
                    <?php foreach($book as $one_book): ?>
                            <h1>Název:  <?=htmlspecialchars($one_book["title"])?></h1>
                             <a href="kniha.php?id=<?= $one_book["id"]?>">Info</a>
                    <?php endforeach; ?>
                </ul>

    <?php endif;?>

</body>
</html>