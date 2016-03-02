<?php
error_reporting(-1);
ini_set('display_errors', 'On');

require('../setting.php');

class Database
{
  protected $dbh;

  public function __construct() {
    try {
      $this->dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PASS);
    } catch(PDOException $e) {
      die("Error!: " . $e->getMessage() . "<br/>");
    }
  }

  public function validateLogin($email, $pass)
  {
    $stmt = $this->dbh->prepare('SELECT * FROM users WHERE email = :email AND password = :pass');
    $result = $stmt->execute(array(
      ':email' => $email,
      ':pass' => md5(HASH . $pass)
    ));

    return ($stmt->rowCount() > 0 ? true : false);
  }

  public function validateRegister($email, $pass)
  {
    if($this->checkForUser($email)) {
      $stmt = $this->dbh->prepare('INSERT INTO users (email, password, created_at) VALUES (:email, :pass, :dt)');
      $result = $stmt->execute(array(
        ':email' => $email,
        ':pass' => md5(HASH . $pass),
        ':dt' => date("Y-m-d H:i:s")
      ));

      return ($result ? true : false);
    } else {
      return false;
    }
  }

  public function checkForUser($email) {
    $stmt = $this->dbh->prepare('SELECT FROM users WHERE email = :email');
    $result = $stmt->execute(array(
      ':email' => $email
    ));

    return ($stmt->rowCount() > 0 ? true : false);
  }
}
