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
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../css/loans.css">
    <?php require "../assetss/link_users.php" ?>
    <title>My account</title>
</head>
<body>
    <main>
        <?php require "../assetss/users_header.php" ?>
       
            <?php if ($info === null ): ?>
                <h3> The user has no borrowd books yet. </h3>
            <?php  else: ?>
                <div class="account">
                    <h3>Name: <?=htmlspecialchars($info["first_name"]) ?> </h3>
                    <h3>Surname: <?=htmlspecialchars($info["surname"])?></h3>
                     <h3>Email: <?=htmlspecialchars($info["email"])?></h3>
                </div>
            <?php endif ?>
            <div style="account_loans">
   <div class="main-title"><h3>My borrow books:</h3></div>
        <?php if (empty($borrows)):?>
            <p>Nenalezeno</p>
        <?php else: ?>
            
            
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date of borrow</th>
                        <th>Date of return</th>
                        <th>Returned</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($borrows as $one_borrow): ?>
                    <tr>
                        <td><?=htmlspecialchars($one_borrow["title"])?></td>
                        <td><?=htmlspecialchars($one_borrow["author"])?></td>
                        <td><?=htmlspecialchars($one_borrow["date_of_loan"])?></td>
                        <td><?=htmlspecialchars($one_borrow["date_of_return"])?></td>
                        <td><?php if($one_borrow["loan_return"] === "true"): ?>
                                <div id="colorSquare" style="width: 50px; height: 50px;background-color: green;"></div>
                            <?php elseif ($one_loan["loan_return"] === "false"): ?>
                                <div id="colorSquare" style="width: 50px; height: 50px;background-color: red;"></div>
                            <?php endif ?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            
        <?php endif;?>
        </div>
        
       
            
    </main>


</body>
</html>
