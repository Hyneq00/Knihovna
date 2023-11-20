<?php
class Authorization
{
    // Autorizace zda návštěvník má přístup
    public static function isLoggedIn()
    {
        return isset($_SESSION["is_logged_in"]) and $_SESSION["is_logged_in"];
    }
}