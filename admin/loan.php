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
                    $loan = new Loan();
                    $loan->loan($connection,$id_user, $id_book);
                   Books::loanBook($connection, $id_book);
                   break;
               case "return":
                   $id_return = Loan::checkloan($connection, $id_user, $id_book);
                  if($id_return === NULL){
                      $text = "Knihu nelze vrátit";
                  } else {
                        $result  = Loan::return_($connection, $id_return);
                        if ($result){
                            $resul = Books::returnBook($connection, $id_book);
                            if($resul){
                            $text = "Kniha úspěšně vrácena";
                            }
                            
                        }
                  }
                   break;
           }}


?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inputs.css">
    <link rel="stylesheet" href="../css/loan.css">
    <?php require "../assetss/link_admin.php" ?>
    <title>Document</title>
</head>
<body>
<?php require "../assetss/admin_header.php" ?>
    <main>
        <div class="logind">
            <form class="login-form" action="loan.php" method="POST">
                    <div class="radio_int">
                        <input type="radio" id="loan" name="loanOrReturn" value= "loan" checked ><label for="loan">Loan</label>
                        
                        <input type="radio" name="loanOrReturn" id="return" value="return"><label for="return">Return</label>
                    </div>
                <input type="text"
                       name="id_user"
                       placeholder="Id user"
                       value="<?=$id_user?>"
                       required>
                <input type="text"
                       name="id_book"
                       placeholder="Book"
                       required>
                <button type="submit"
                        class="button log log_reg_btn"
                        value="add_id_user"> O </button>
            </form>
            <h1><?=$text?></h1>
        </div>

    </main>
</body>
</html>
