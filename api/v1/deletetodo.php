<?php
require_once('../Database.php');
require_once('../JSON.php');

$db = new Database();
$data = file_get_contents('php://input');
$data = json_decode($data);

if($db->deleteToDo($data->id)) {
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');
  $array = [
    'valid' => true,
    'message' => 'To-Do Item Deleted!'
  ];
  echo json_encode(new JSON($array), JSON_PRETTY_PRINT);
} else {
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');
  $array = [
    'valid' => false,
    'message' => 'Something went wrong!'
  ];
  echo json_encode(new JSON($array), JSON_PRETTY_PRINT);
}
