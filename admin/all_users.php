<?php
require "../assetss/database.php";
require "../assetss/authorization.php";
require "../assetss/funkce_kniha.php";

$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedInAdmin()) {
    die("Nepovolený přístup");
}
$sort = $_POST["sort"];
    switch ($sort) {
        case "id_desc":
            $sql_plus = "ORDER BY id_user DESC";
            break;
        case "id_asc":
            $sql_plus = "ORDER BY id_user ASC";
            break;
        case "email_desc":
            $sql_plus = "ORDER BY email DESC";
            break;
        case "email_asc":
            $sql_plus = "ORDER BY email ASC";
            break;

        default:
            $sql_plus = "ORDER BY id_user DESC";
    }
    $users = Users::allUsers($connection, $sql_plus);

    
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "../assetss/link_admin.php" ?>
    <link rel="stylesheet" href="../css/loans.css">
    <link rel="stylesheet" href="../css/sort.css">
    <title>All loans</title>
</head>
<body>
<?php require "../assetss/admin_header.php" ?>
<main>
    <div class="main_title"><h1>All loans</h1></div>
    <div class="sort">
        <form method="post" action="all_loans.php">
            <select id="sort" name="sort">
                <option value="">--Select--</option>
                <option value="id_desc" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'id_desc') echo 'selected="selected"'; ?>>ID desc</option>
                <option value="id_asc" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'id_asc') echo 'selected="selected"'; ?>>ID asc</option>
                <option value="ret_notret" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'email_desc') echo 'selected="selected"'; ?>>Email desc</option>
                <option value="notret_ret" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'email_asc') echo 'selected="selected"'; ?>>Email asc</option>
            </select>
            <button type="submit" >Sort</button>
        </form>
    </div>
    <table>
        <thead>
        <tr>
            <th>Id user</th>
            <th>First name</th>
            <th>Surname</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($users as $one_user): ?>
                <tr>
                    <td><?=$one_user["id_user"]?></td>
                    <td><?=$one_user["first_name"]?></td>
                    <td><?=$one_user["surname"]?></td>
                    <td><?=$one_user["email"]?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    

</main>
</body>
</html>