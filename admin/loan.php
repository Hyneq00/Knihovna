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
if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id_user = $_POST["id_user"];
            $id_book = $_POST["id_book"];
            switch($_POST["loanOrReturn"]){
               case "loan":
                   Loan::loan($connection, $id_user, $id_book);
                   Books::loanBook($connection, $id_book);
                   break;
               case "return":
                   $id_return = Loan::checkloan($connection, $id_user, $id_book);
                    $result  = Loan::return_($connection, $id_return);
                    Books::returnBook($connection, $id_book);
                  if($id_return === NULL){
                      $text = "Knihu nelze vrátit";
                  } else {
                      $text = "Kniha úspěšně vrácena";
                  }
                   break;
           }}


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
        <section>
            <form action="loan.php" method="POST">
                <input type="text"
                       name="id_user"
                       placeholder="Id user"
                       value="<?=$id_user?>"
                       required>
                <br>
                <input type="radio"   name ="loanOrReturn" value= "loan" checked >Loan
                <input type="radio"  name ="loanOrReturn"    value= "return">Return
                <br>
                <input type="text"
                       name="id_book"
                       placeholder="Book"
                       required>
                <br>
                <br>
                <button type="submit"
                        class="button log log_reg_btn"
                        value="add_id_user"> O </button>
            </form>
            <h1><?=$text?></h1>
        </section>

    </main>
</body>
</html>
