<?php

// Získává jednu knihu z databaze podle ID

function getBook($connection,$id) {
    $sql = "SELECT *
            FROM kniha
            WHERE id=?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt === false) {
        echo mysqli_error($connection);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
}

// Funkce na upravování knihy
function updateBook($connection,$title, $author, $year_of_publication, $genre,$id){
    $sql = "UPDATE kniha
                SET 
                 title = ?,
                 author = ?,
                 year_of_publication = ?,
                 genre = ?
                 WHERE id = ?";

    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt == false){
        echo mysqli_error($connection);
    } else {
        mysqli_stmt_bind_param($stmt, "ssssi",$title, $author, $year_of_publication, $genre,$id );
        mysqli_stmt_execute($stmt);
    }

}

//Funkce na vyhledávání kníh podle autora, názvu a nebo žánru
function getBook_one($connection,$anything,$what) {
    $sql = "SELECT *
            FROM kniha
            WHERE $anything=?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt === false) {
        echo mysqli_error($connection);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $what);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
}
// Funkce na mazání knih
function deleteBook($connection, $id){
    $sql = "DELETE FROM kniha WHERE id = $id";
    if (mysqli_query($connection, $sql)) {
        return;
    } else {
        echo mysqli_error($connection);
    }

}

//Funkce na zaregistrování nového uživatele

function registrationUsers($connection,$first_name, $surname, $email, $password){
    $sql = "INSERT INTO users(first_name, surname, email, password)
    VALUES(?,?,?,?)";

    $statement = mysqli_prepare($connection, $sql);

    if ($statement === false) {
        echo mysqli_error($connection);
    } else {
        mysqli_stmt_bind_param($statement, "ssss", $first_name, $surname, $email, $password);

        if(mysqli_stmt_execute($statement)) {

            $id = mysqli_insert_id($connection);
            return $id;
        } else {
            echo mysqli_stmt_error($statement);
        }
    }
}

function authorizationUsers($connection, $log_email, $log_password) {
        $sql = "SELECT password
                FROM users
                WHERE email = ?";

        $stmt = mysqli_prepare($connection, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $log_email);

            if (mysqli_stmt_execute($stmt)){
                $result_password = mysqli_stmt_get_result($stmt);
                $password_database = mysqli_fetch_row($result_password); // zde je proměnná v poli
                $user_password_database = $password_database[0];
                if ($user_password_database){
                    return password_verify($log_password, $user_password_database);
                }
        } else {
                echo mysqli_error($connection);
            };
        }
}
// Získání ID uživatele
function getUserId($connection, $email) {
    $sql = "SELECT id FROM users WHERE email = ?";

    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $id_database = mysqli_fetch_row($result); //pole
            $user_id =  $id_database[0];

            echo $user_id;
        }

    } else {
        echo mysqli_error($connection);
    }
}