<?php require "assetss/database.php";

$database = new Database();
$connection = $database->connectiondb();

$sql = "SELECT * FROM kniha";
$stmt = $connection->prepare($sql);
try {
    if ($stmt->execute()){
        $book = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        throw new Exception("Chyba při připojení do datbáze");
    }
} catch (Exception $e) {
    echo "Typ chyby: ". $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type = "text/css" href="css/header.css">
    <link rel="stylesheet" type = "text/css" href="css/style.css">
    <title>Document</title>
</head>
<body>
<?php require "assetss/header.php" ?>
    <h1>Seznam všech knih</h1><br>
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