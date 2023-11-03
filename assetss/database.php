<?php
/**
 * Připojení databáze
 * @return object - pro připojení dodatabáze
 * */
    function connectiondb(){
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "knihovna";

        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
        if (mysqli_connect_error()){
            echo mysqli_connect_error();
            exit();
        }
        return $connection;
    }



?>