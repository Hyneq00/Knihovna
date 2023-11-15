<?php



class Books
{
    // Získává jednu knihu z databaze podle ID
    public static function getBook($connection, $id, $columns = "*")
    {
        $sql = "SELECT $columns
                FROM kniha
                WHERE id=:id";
        $stmt = $connection->prepare($sql);


        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }


// Funkce na upravování knihy
    public static function updateBook($connection, $title, $author, $year_of_publication, $genre, $id)
    {
        $sql = "UPDATE kniha
                SET 
                 title = :title,
                 author = :author,
                 year_of_publication = :year_of_publication,
                 genre = :genre
                 WHERE id = :id";

        $stmt = $connection->prepare($sql);

        if (!$stmt) {
            echo mysqli_error($connection);
        } else {
            $stmt->bindValue(":title", $title, PDO::PARAM_STR);
            $stmt->bindValue(":author", $author, PDO::PARAM_STR);
            $stmt->bindValue(":year_of_publication", $year_of_publication, PDO::PARAM_STR);
            $stmt->bindValue(":genre", $genre, PDO::PARAM_STR);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        }
        $stmt->execute();
    }

//Funkce na vyhledávání kníh podle autora, názvu nebo žánru
    public static function getBook_one($connection, $anything, $what)
    {
        $sql = "SELECT *
                FROM kniha
                WHERE $anything = :what";
        $stmt = $connection->prepare($sql);

        if (!$stmt) {
            echo mysqli_error($connection);
        } else {
            $stmt->bindValue(":what", $what, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return $stmt->fetch();
            }
        }
    }

// Funkce na mazání knih
    public static function deleteBook($connection, $id)
    {
        $sql = "DELETE FROM kniha WHERE id = $id";
        if (mysqli_query($connection, $sql)) {
            return;
        } else {
            echo mysqli_error($connection);
        }

    }

    public static function creatBook($connection, $title, $author, $year_of_publication, $genre)
    {
        $sql = "INSERT INTO kniha (title, author, year_of_publication, genre)
                            VALUES(:title,:author,:year_of_publication,:genre)";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":author", $author, PDO::PARAM_STR);
        $stmt->bindValue(":year_of_publication", $year_of_publication, PDO::PARAM_STR);
        $stmt->bindValue(":genre", $genre, PDO::PARAM_STR);
// Execute the statement
        try {
            // Execute the statement
            if ($stmt->execute()) {
                // Optionally, you can return the last inserted ID or any other relevant information.
                return $connection->lastInsertId();
            } else {
                // Handle errors if the execution fails
                // You might want to log the error or throw an exception
                throw new RuntimeException("Error executing the SQL statement.");
            }
        } catch (PDOException $e) {
            // Handle PDO exceptions
            // You might want to log the error or throw an exception with a more detailed message
            throw new RuntimeException("Database error: " . $e->getMessage());
        }

    }
}
class Users {
    //Funkce na zaregistrování nového uživatele
     public static function registrationUsers($connection, $first_name, $surname, $email, $password)
     {
         $sql = "INSERT INTO users(first_name, surname, email, password)
                VALUES(:first_name, :surname, :email, :password)";

         $stmt = $connection->prepare($sql);

         $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
         $stmt->bindValue(":surname", $surname, PDO::PARAM_STR);
         $stmt->bindValue(":email", $email, PDO::PARAM_STR);
         $stmt->bindValue(":password", $password, PDO::PARAM_STR);

         $stmt->execute();;
         $id = $connection->lastInsertId();
         return $id;
     }



    public static function authorizationUsers($connection, $log_email, $log_password)
    {
        $sql = "SELECT password
                FROM users
                WHERE email = :email";

        $stmt = $connection->prepare($sql);

        if ($stmt) {
            $stmt->bindValue(":email", $log_email, PDO::PARAM_STR);
            $stmt->execute();
            if ($user = $stmt->fetch()) {
                return password_verify($log_password, $user[0]);
            }
        }
    }
// Získání ID uživatele
    public static function getUserId($connection, $email) {
        $sql = "SELECT id FROM users WHERE email = :email";

        $stmt = $connection->prepare($sql);

        if ($stmt) {
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetch();
                $user_id = $result[0];
                echo $user_id;
            }

        } else {
            echo mysqli_error($connection);
        }
    }
}
