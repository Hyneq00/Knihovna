<?php
require "../assetss/database.php";
require  "../assetss/funkce_kniha.php";

session_start();

$database = new Database();
$connection = $database->connectiondb();



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
        //Nastavení role uživateli
        $role = Users::getUserRole($connection, $id);
        $_SESSION["role"] = $role;
        switch ($role) {
            case "user":
                header("Location:../users/index_users.php");
                break;
            case "admin":
                header("Location:admin_index.php");
                break;
        }




    } else {
        $error = "error";
        header("Location:../main/login.php?error=$error");

    }
}

?>