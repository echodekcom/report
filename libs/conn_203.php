<?php
class Db {

  public $database;

  public function __construct(){
   $this->connect();
  }

  public function __destruct(){
   $this->disconnect();
  }

  private function connect(){
    $db_host = "119.59.110.203";
    $db_name = "JC_WALLET";
    $db_user = "zs_faiz";
    $db_pass = "Faiz5605";

    try {
      $this->database = new PDO("sqlsrv:server=$db_host ; Database = $db_name", $db_user, $db_pass);
      $this->database->exec("SET CHARACTER SET utf8");
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  private function disconnect(){
    $this->database = null;
  }
}
error_reporting( error_reporting() & ~E_NOTICE );
?>
