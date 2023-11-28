<?php
require "../assetss/database.php";
require "../assetss/authorization.php";
require "../assetss/funkce_kniha.php";
$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedInUser()) {
    die("Nepovolený přístup");
}

$sort = $_POST["sort"];
switch ($sort) {
    case "author_desc":
        $sql_plus = "ORDER BY author DESC";
        break;
    case "author_asc":
        $sql_plus = "ORDER BY author ASC";
        break;
    case "yofp_desc":
        $sql_plus = "ORDER BY year_of_publication DESC";
        break;
    case "yofp_asc":
        $sql_plus = "ORDER BY year_of_publication ASC";
        break;
    default:
        $sql_plus = "ORDER BY id_book DESC";
}
$books = Books::sortBooks($connection, $sql_plus);


?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "../assetss/link_users.php" ?>
    <link rel="stylesheet" href="../css/books.css">
    <link rel="stylesheet" href="../css/sort.css">
    <title>Books</title>
</head>
<body>
<?php require"../assetss/users_header.php" ?>

<?php if (empty($books)):?>
    <h2>Nenalezeno</h2>
<?php else: ?>
    <div class="main_title"><h1>All books</h1></div>
    <div class="sort">
        <form method="POST" action="knihy_users.php">
            <select id="sort" name="sort">
                <option value="">--Select--</option>
                <option value="author_desc" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'author_desc') echo 'selected="selected"'; ?>>Author desc</option>
                <option value="id_author_ascasc" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'author_asc') echo 'selected="selected"'; ?>>Author asc</option>
                <option value="yofp_desc" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'yofp_desc') echo 'selected="selected"'; ?>>Year of publication desc</option>
                <option value="yofp_asc" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'yofp_asc') echo 'selected="selected"'; ?>>Year of publication asc</option>
            </select>
            <button type="submit" >Sort</button>
        </form>
    </div>
    <div class="container">
        <?php foreach($books as $one_book): ?>
            <div class="result">
                <?php
                $imagePath = "../uploads/".$one_book["image"];
                $imageSource = file_exists($imagePath) && $imagePath !== "../uploads/" ? $imagePath : "../uploads/001.png";
                ?>
                <img src="<?= $imageSource ?>" alt="Book Image">
                
                <div class="info-container">
                    <div class="name-container">
                        <span class="left-name"><h3>Title:</h3></span>
                        <span class="right-name"><h2><?= htmlspecialchars($one_book["title"]) ?></h2></span>
                    </div>
                    <div class="name-container">
                        <span class="left-name"><h3>Author:</h3></span>
                        <span class="right-name"><h2><?= htmlspecialchars($one_book["author"]) ?></h2></span>
                    </div>
                    
                    <div class="name-container">
                        <span class="left-name"><h3>Year of publication:</h3></span>
                        <span class="right-name"><h2><?= htmlspecialchars($one_book["year_of_publication"]) ?></h2></span>
                    </div>
                    <div class="name-container">
                        <span class="left-name"><h3>Avaliable:</h3></span>
                        <span class="right-name"><div class="colorSquare" style="background-color: <?= $one_book["avaliable"] === "true" ? "green" : "red" ?>"></div></span>
                    </div>
                    <div class="info">
                    <h3><a href="kniha_users.php?id=<?= htmlspecialchars($one_book["id_book"]) ?>">Info</a></h3>
                    </div>
                    
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;?>

</body>
</html>