<?php
require "../assetss/funkce_kniha.php";
require "../assetss/database.php";
$connection = connectiondb();
session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["first_name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
    $password_confirm = $_POST["password_confirm"];

    $id = registrationUsers($connection, $first_name, $surname, $email, $password);


}
if (empty($id)){
    echo "Uživatele se nepodařilo přidat";
} else {
    //Zabraňuje txv: Fixation attack
    session_regenerate_id(true);
    // Nastavení, že je uživat přihlášenej
    $_SESSION["is_logged_in"] = true;
    // Nastavení ID uživatele
    $_SESSION["logged_in_user_id"] = $id;
    header("Location: ../index.php");
}
?>