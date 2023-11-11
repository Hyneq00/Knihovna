<?php
// Autorizace zda návštěvník má přístup
function isLoggedIn(){
    return isset($_SESSION["is_logged_in"] ) and $_SESSION["is_logged_in"];
}