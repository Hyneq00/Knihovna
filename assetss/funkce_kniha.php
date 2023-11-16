<?php



class Books
{
    // Získává jednu knihu z databaze podle ID
    public static function getBook($connection, $id)
    {
        $sql = "SELECT *
                FROM kniha
                WHERE id=:id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        try {
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Získání dat o knize selhalo");
            }
        } catch (Exception $e) {
                echo "Typ chyby: ".$e->getMessage();
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
        try {
            if ($stmt) {
                $stmt->bindValue(":title", $title, PDO::PARAM_STR);
                $stmt->bindValue(":author", $author, PDO::PARAM_STR);
                $stmt->bindValue(":year_of_publication", $year_of_publication, PDO::PARAM_STR);
                $stmt->bindValue(":genre", $genre, PDO::PARAM_STR);
                $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                throw new Exception("Chyba při spojení do databáze, data se nepodařilo zapsat");
            }

        } catch (Exception $e) {
            echo "Typ chyby: ".$e->getMessage();
            return "Error, data se nepodařilo zapsat";
        }


    }

//Funkce na vyhledávání kníh podle autora, názvu nebo žánru
    public static function getBook_one($connection, $anything, $what)
    {
        $sql = "SELECT *
                FROM kniha
                WHERE $anything = :what";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":what", $what, PDO::PARAM_STR);
        try {
            if ($stmt->execute()) {
                return $stmt->fetch();
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ".$e->getMessage();
            return "error";
        }
    }

// Funkce na mazání knih
    public static function deleteBook($connection, $id)
    {
        $sql = "DELETE FROM kniha WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {
                return;
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ".$e->getMessage();
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

        try {
            if ($stmt->execute()) {
                return $connection->lastInsertId();
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
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

         try {
             if ($stmt->execute()) {
                 $id = $connection->lastInsertId();
                 return $id;
             } else {
                 throw new Exception("Chyba při připojení do databáze");
             }
         } catch (Exception $e) {
             echo "Typ chyby: ". $e->getMessage();
         }
     }



    public static function authorizationUsers($connection, $log_email, $log_password)
    {
        $sql = "SELECT password
                FROM users
                WHERE email = :email";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":email", $log_email, PDO::PARAM_STR);
        try {
            if ($stmt->execute()) {
                $user = $stmt->fetch();
                return password_verify($log_password, $user[0]);
                } else {
                    throw new Exception("Chyba při připojení do databáze");
                }
        } catch (Exception $e) {
                echo "Typ chyby: ". $e->getMessage();
        }
    }
// Získání ID uživatele
    public static function getUserId($connection, $email) {
        $sql = "SELECT id FROM users WHERE email = :email";

        $stmt = $connection->prepare($sql);
        try {
            if ($stmt) {
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $result = $stmt->fetch();
                    $user_id = $result[0];
                    echo $user_id;
                }
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }

    }
    public static function isExistEmail($connection, $email) {
         $sql ="SELECT id 
                FROM users 
                WHERE email = :email";
        $stmt = $connection->prepare($sql);
        try {
            if ($stmt) {
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $result = $stmt->fetch();
                    $user_id = $result[0];
                    if (empty($user_id)){
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }
    }
}
