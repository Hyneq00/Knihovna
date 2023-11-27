<?php

class Books
{
    public static function allBooks($connection){
        $sql = "SELECT * FROM kniha";
        $stmt = $connection->prepare($sql);
        try {
            if ($stmt->execute()){
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $books;
            } else {
                throw new Exception("Chyba při připojení do datbáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }
    }
    public static function creatBook($connection, $title, $author, $year_of_publication, $genre)
    {
        $sql = "INSERT INTO kniha (title, author, year_of_publication, genre)
                            VALUES(:title,:author,:year_of_publication,:genre)";

        $stmt = $connection->prepare($sql);
        try {
            if ($stmt) {
                $stmt->bindValue(":title", $title, PDO::PARAM_STR);
                $stmt->bindValue(":author", $author, PDO::PARAM_STR);
                $stmt->bindValue(":year_of_publication", $year_of_publication, PDO::PARAM_STR);
                $stmt->bindValue(":genre", $genre, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $img_name = [$connection->lastInsertId(),$title];
                    return $img_name;
                } else {
                    throw new Exception("Chyba při provedení akce, data se nepodařilo zapsat");
                }
            } else {
                throw new Exception("Chyba při spojení do databáze, data se nepodařilo zapsat");
            }
        } catch (Exception $e) {
            echo "Typ chyby: " . $e->getMessage();
            return "Error, data se nepodařilo zapsat";
        }
    }
    // Získává jednu knihu z databaze podle ID
    public static function getBook($connection, $id)
    {
        $sql = "SELECT *
                FROM kniha
                WHERE id_book = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        try {
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Získání dat o knize selhalo");
            }
        } catch (Exception $e) {
            echo "Typ chyby: " . $e->getMessage();
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
                 WHERE id_book = :id";

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
            echo "Typ chyby: " . $e->getMessage();
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
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: " . $e->getMessage();
            return "error";
        }
    }

    public static function sortBooks($connection, $sql_plus){
        $sql = "SELECT * 
        FROM kniha 
        $sql_plus";
        $stmt = $connection->prepare($sql);
        try {
        if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
      }
    }
// Funkce na mazání knih
    public static function deleteBook($connection, $id)
    {
        $sql = "DELETE FROM kniha WHERE id_book = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if ($stmt->execute()) {
                return;
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: " . $e->getMessage();
        }
    }
    public static function addImage($connection,$id, $title, $image) {
        $sql = "UPDATE kniha
                SET
                image = :image
                WHERE id_book = :id";
        try {
            $image_error =  $image["error"];
            $image_size =  $image["size"];
            $image_name = $image["name"];
            $allowe_extension = ["jpeg", "jpg", "png"];
            if ($image_error === 0) {
                if ($image_size < 10000000) {
                    $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_extension_low = strtolower($image_extension);
                    if (in_array($image_extension_low, $allowe_extension)) {
                        $stmt = $connection->prepare($sql);
                        $new_image_name = Books::imageName($id, $title, $image_extension);
                        $result = Books::imagePath($image["tmp_name"],$new_image_name);
                        if ($result) {
                            $stmt->bindValue(":image", $new_image_name, PDO::PARAM_STR);
                            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                            $stmt->execute();
                            $text = $new_image_name;
                            return $text;
                        } else {
                            throw new Exception("Chyba při nahrávání obrázku");
                        }
                    } else {
                        $text = "extension";
                        return $text; }
                } else {
                    $text = "size";
                    return $text; }
            } else {
                $text = "error";
                return $text;
            }

        } catch (Exception $e) {
            echo "Typ chyby: " . $e->getMessage();
            echo "Error, data se nepodařilo zapsat";
        }
    }
    public static function imagePath($image_tmp_name, $new_image_name) {
        $image_upload_path ="../uploads/".$new_image_name;
        $result = move_uploaded_file($image_tmp_name,$image_upload_path);
        return $result;
    }
    public static function imageName( $id, $title, $image_extension){
        $new_image_name = uniqid("IMG_".$id."_".$title."_",true).".".$image_extension;
        return $new_image_name;

    }

    public static function deleteImage($connection, $id){
        $sql = "SELECT image 
                FROM kniha 
                WHERE id_book = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        try {
            if ($stmt->execute()) {
                $img = $stmt->fetch();
                $image_delete = $img[0];
                if (file_exists("../uploads/".$image_delete)) {
                    if (unlink("../uploads/".$image_delete)) {
                            return;
                    } else {
                        throw new Exception("Nastala chyba při mazání obrázku");
                    }
                } else {
                        return;
                }
                return ;
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: " . $e->getMessage();
        }
    }
    public static function loanBook($connection, $id_book) {
        $sql = "UPDATE
                kniha
                SET
                avaliable = 'false'
                WHERE
                id_book = :id_book";
        $stmt = $connection->prepare($sql);
        try {
            if ($stmt) {
                $stmt->bindValue(":id_book", $id_book, PDO::PARAM_INT);
                $stmt->execute();

            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }
    }

    public static function returnBook($connection, $id_book) {
        $sql = "UPDATE
                kniha
                SET
                avaliable = 'true'
                WHERE
                id_book = :id_book";
        $stmt = $connection->prepare($sql);
        try {
            if ($stmt) {
                $stmt->bindValue(":id_book", $id_book, PDO::PARAM_INT);
                return $stmt->execute();

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
    public static function registrationUsers($connection, $first_name, $surname, $email, $password, $role)
    {
        $sql = "INSERT INTO users(first_name, surname, email, password, role)
                VALUES(:first_name, :surname, :email, :password, :role)";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":first_name", $first_name, PDO::PARAM_STR);
        $stmt->bindValue(":surname", $surname, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":role", $role, PDO::PARAM_STR);

        try {
            if ($stmt->execute()) {
                $id = $connection->lastInsertId();
                return $id;
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: " . $e->getMessage();
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
        $sql = "SELECT id_user FROM users WHERE email = :email";

        $stmt = $connection->prepare($sql);
        try {
            if ($stmt) {
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $user_id = $result["id_user"];
                    return $user_id;
                }
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }

    }
    //Zíkání udajú uživatele
    public static function getInfoUser($connection,$id){
        $sql = "SELECT * 
                FROM users
                WHERE id_user = :id";
        $stmt = $connection->prepare($sql);
        try {
            if ($stmt) {
                $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }

    }
    //Zíkání role uživatele
    public static function getUserRole($connection, $id) {
        $sql = "SELECT role 
                FROM users 
                WHERE id_user = :id";

        $stmt = $connection->prepare($sql);
        try {
            if ($stmt) {
                $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $user_role = $result["role"];
                    return $user_role;
                }
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }

    }
    public static function isExistEmail($connection, $email) {
        $sql ="SELECT id_user 
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

    public static function userBorrows($connection, $id_user){
        $sql = "SELECT loans.date_of_loan, loans.date_of_return, loans.loan_return, kniha.title, kniha.author 
                FROM loans 
                INNER JOIN kniha 
                ON loans.id_book = kniha.id_book 
                WHERE loans.id_user = :id_user ";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
class Loan {
    public static function allLoans($connection, $sql_plus){
        $sql = "SELECT * 
                FROM loans
                JOIN kniha ON loans.id_book = kniha.id_book
                JOIN users ON loans.id_user = users.id_user 
                $sql_plus";
        $stmt = $connection->prepare($sql);
        try {
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
      		}
	}
    public function loan($connection, $id_user, $id_book) {
        $sql = "INSERT INTO loans (id_user, id_book, date_of_loan)
                VALUES (:id_user, :id_book,:date_of_loan)";
        $today = date("Y-m-d");
        $stmt = $connection->prepare($sql);
        try {
            $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindValue(":id_book", $id_book, PDO::PARAM_INT);
            $stmt->bindValue(":date_of_loan", $today, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return;
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }
    }
    public static function checkloan($connection, $id_user, $id_book) {

        $sql = "SELECT id_loan
                FROM loans
                WHERE
                loan_return = 'false' and
                id_user = :id_user and
                id_book = :id_book";

        $stmt = $connection->prepare($sql);
        try {
            $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
            $stmt->bindValue(":id_book", $id_book, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $result = $stmt->fetch();
                $user_id = $result[0];
                return $user_id;
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }

    }
    public static function return_($connection, $id_loan) {

        $sql = "UPDATE loans
                SET 
                date_of_return = :date_of_return,
                loan_return = 'true'
                WHERE 
                id_loan = :id_loan";

        $today = date("Y-m-d");

        try {
            if ($stmt = $connection->prepare($sql)) {
                $stmt->bindValue(":id_loan", $id_loan, PDO::PARAM_STR);
                $stmt->bindValue(":date_of_return", $today, PDO::PARAM_STR);
                return $stmt->execute();
            } else {
                throw new Exception("Chyba při připojení do databáze");
            }
        } catch (Exception $e) {
            echo "Typ chyby: ". $e->getMessage();
        }

    }

}