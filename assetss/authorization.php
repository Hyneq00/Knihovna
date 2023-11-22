<?php
class Authorization
{
    // Autorizace zda návštěvník má přístup jako admin
    public static function isLoggedInAdmin()
    {
        if ($_SESSION["role"] === "admin") {
            return isset($_SESSION["is_logged_in"]) and $_SESSION["is_logged_in"];
        } else {
            return false;
        }
    }

    public static function isLoggedInUser()
    {
        if ($_SESSION["role"] === "user") {
            return isset($_SESSION["is_logged_in"]) and $_SESSION["is_logged_in"];
        } else {
            return false;
        }

    }
}