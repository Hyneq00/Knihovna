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

/**
 * @param $connection - napojední na databázi
 * @param $title - název knihy
 * @param $author - název knihy autora
 * @param $year_of_publication - ro vydání knihy
 * @param $genre - žánr knihy
 * @param $id - id knihy
 * @return string|void - vrací text s oznámením úspěšné změny
 */
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

        if (mysqli_stmt_execute($stmt)){
            return;
        }
    }

}

