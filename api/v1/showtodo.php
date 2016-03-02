<?php
require_once('../Database.php');
require_once('../JSON.php');

$db = new Database();
$data = file_get_contents('php://input');

if($db->getTodoItems()) {
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');
  $array = [
    'valid' => true,
    'todos' => $db->getTodoItems()
  ];
  echo json_encode(new JSON($array), JSON_PRETTY_PRINT);
}
