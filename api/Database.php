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

  public function validateRegister($name, $email, $pass)
  {
    if($this->checkForUser($email)) {
      $stmt = $this->dbh->prepare('INSERT INTO users (fullname, email, password, created_at) VALUES (:name, :email, :pass, :dt)');
      $result = $stmt->execute(array(
        ':name' => $name,
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
    $stmt = $this->dbh->prepare('SELECT * FROM users WHERE email = :email');
    $result = $stmt->execute(array(
      ':email' => $email
    ));

    return ($stmt->rowCount() > 0 ? false : true);
  }

  public function getTodoItems() {
    $stmt = $this->dbh->prepare('SELECT * FROM todolist ORDER BY created_at DESC');
    $result = $stmt->execute();

    return $stmt->fetchAll();
  }

  public function addNewToDo($todo) {
    $stmt = $this->dbh->prepare('INSERT INTO todolist (todo, created_at) VALUES (:todo, :dt)');
    $result = $stmt->execute(array(
      ':todo' => $todo,
      ':dt' => date("Y-m-d H:i:s")
    ));

    return ($result ? true : false);
  }

  public function deleteToDo($id) {
    $stmt = $this->dbh->prepare('DELETE FROM todolist WHERE id = :id');
    $result = $stmt->execute(array(
      ':id' => $id
    ));

    return ($result ? true : false);
  }
}
