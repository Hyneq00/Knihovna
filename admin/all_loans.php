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
            $sql_plus = "ORDER BY id_loan DESC";
            break;
        case "id_asc":
            $sql_plus = "ORDER BY id_loan ASC";
            break;
        case "ret_notret":
            $sql_plus = "ORDER BY loan_return DESC";
            break;
        case "notret_ret":
            $sql_plus = "ORDER BY loan_return ASC";
            break;
        case "":
            $sql_plus = "ORDER BY id_loan DESC";
            break;
        default:
            $sql_plus = "ORDER BY id_loan DESC";
    }
    $loan = Loan::allLoans($connection, $sql_plus);

    
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
                <option value="ret_notret" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'ret_notret') echo 'selected="selected"'; ?>>Returned/Not returned</option>
                <option value="notret_ret" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'notret_ret') echo 'selected="selected"'; ?>>Not returned/returned</option>
            </select>
            <button type="submit" >Sort</button>
        </form>
    </div>
    <table>
        <thead>
        <tr>
            <th>Id loan</th>
            <th>Title</th>
            <th>Author</th>
            <th>Date of loan</th>
            <th>Date of return</th>
            <th>Id user</th>
            <th>Name of user</th>
            <th>Email</th>
            <th>Returned</th>

        </tr>
        </thead>
        <tbody>
            <?php foreach($loan as $one_loan): ?>
                <tr>
                    <td><?=$one_loan["id_loan"]?></td>
                    <td><?=$one_loan["title"]?></td>
                    <td><?=$one_loan["author"]?></td>
                    <td><?=$one_loan["date_of_loan"]?></td>
                    <td><?=$one_loan["date_of_return"]?></td>
                    <td><?=$one_loan["id_user"]?></td>
                    <td><?=$one_loan["first_name"]?> <?=$one_loan["surname"]?></td>
                    <td><?=$one_loan["email"]?></td>
                    <td><?php if($one_loan["loan_return"] === "true"): ?>
                            <div id="colorSquare" style="width: 50px; height: 50px;background-color: green;"></div>
                        <?php elseif ($one_loan["loan_return"] === "false"): ?>
                            <div id="colorSquare" style="width: 50px; height: 50px;background-color: red;"></div>
                        <?php endif ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    

</main>
</body>
</html>

