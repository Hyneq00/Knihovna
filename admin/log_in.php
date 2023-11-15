<?php
require "../assetss/database.php";
require  "../assetss/funkce_kniha.php";

$database = new Database();
$connection = $database->connectiondb();

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $log_email = $_POST["log_email"];
    $log_password = $_POST["log_password"];
    if (Users::authorizationUsers($connection, $log_email, $log_password)) {
        //úspěšné přihlášení
        $id = Users::getUserId($connection, $log_email);
        session_regenerate_id(true);
        $_SESSION["is_logged_in"] = true;
        // Nastavení ID uživatele
        $_SESSION["logged_in_user_id"] = $id;
        header("Location:admin_index.php");

    } else {
        $error = "error";
        header("Location:../login.php?error=$error");

    }
}

?>