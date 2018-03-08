<?php

/*
*   Classe de gestion de la base de donnée
*/

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/config/db-config.php";

class Database
{
    /** Instance de PDO */
    private $_PDOInstance;

    /** Instance de Database */
    private static $_instance = null;

/*----------------------------------------------------------------------------*/

    private function __construct() {
        try {
            $options =
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => falses
            ];
            $this->_PDOInstance = new PDO('mysql:host=' .DB_HOST. ';dbname=' .DB_DATABASE, DB_USER, DB_PASSWORD, $options);
        } catch (PDOException $e) {
            try {
                $this->_PDOInstance = new PDO('mysql:host=localhost', "root", "br200991");
            } catch (PDOException $e) {
                $message = "Database unaviable, please try again later";
                exit($e->getMessage());
            }
        }
    }
/*----------------------------------------------------------------------------*/

    /*
    * Retourne une Instance de Database (existante ou nouvelle)
    * @return Une instance pour la base de donnée
    */
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Database();
        } return (self::$_instance);
    }

/*----------------------------------------------------------------------------*/

    /*
    * Permet de faire une requete preparé en sql
    * @param $sql La requete SQLite3
    * @param $fileds Y- a-t'il est champs a traiter ?
    * @param $multiple La requete doit-elle retourner plusieurs resultats ?
    */
    public function request($sql, $fields = false, $multiple = false) {
        try {
            $statement = $this->_PDOInstance->prepare($sql);
            if($fields) {
                foreach ($fields as $key => $value) {
                    var_dump($key);
                    var_dump($value);
                    if(is_int($value)) {
                        $dataType = PDO::PARAM_INT;
                    } else if(is_bool($value)) {
                        $dataType = PDO::PARAM_BOOL;
                    } else if (is_null($value)) {
                        $dataType = PDO::PARAM_NULL;
                    } else {
                        $dataType = PDO::PARAM_STR;
                    }
                    $statement->bindValue(':' .$key, $value, $dataType);
                }
            }
            $statement->execute();
            if($multiple) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $result = $statement->fetch(PDO::FETCH_ASSOC);
            }
        $statement->closeCursor();
        return($result);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

/*----------------------------------------------------------------------------*/

    /*
    * Si retourne 1, la valeur a été trouvé dans le tableau
    * @param $array_given le tableau a checker
    * @param $Value_to_check valeur a rechercher
    */
    public function verify_duplicates($array_given, $value_to_check)
    {
        $i = 0;
        if ($array_given == NULL) {
            return(FALSE);
        }
        foreach ($array_given as $key => $value) {
            if (in_array($value_to_check, $array_given)) {
                return(TRUE);
            } else {
                return (FALSE);
            }
            $i++;
        }
        return (FALSE);
    }
}
