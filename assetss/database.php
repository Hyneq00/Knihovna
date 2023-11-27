<?php
class Database {
    public function connectiondb() {
        $db_host = "127.0.0.1";
        $db_name = "Knihovna";
        $db_user = "root";
        $db_password = "";


        $connection = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8";

        try {
            $db = new PDO($connection, $db_user, $db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "  Chyba";
            exit();
        }
    }

}

