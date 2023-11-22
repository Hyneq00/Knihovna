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
    $loan = Loan::allLoans($connection);



?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
<?php require "../assetss/admin_header.php" ?>
<main>
    <table>
        <thead>
        <tr>
            <th>Id loan</th>
            <th>Title</th>
            <th>Author</th>
            <th>Date of loan</th>
            <th>Date of return</th>
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

