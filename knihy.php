<?php

    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "test";

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (mysqli_connect_error()){
            echo mysqli_connect_errno();
            exit();
    }
    echo "uspěšné přihlášení do databáze";



