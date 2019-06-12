<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  include_once '../../config/Database.php';
  include_once '../../models/User.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog User object
  $User = new User($db);
  // Blog User query
  $result = $User->read();
  // Get row count
  $num = $result->rowCount();
  // Check if any Users
  if($num > 0) {
    // User array
    $users_arr = array();
    // $users_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $user_item = array(
        'username' => $username,
        'password' => $password,
      );
      // Push to "data"
      array_push($users_arr, $user_item);
      // array_push($users_arr['data'], $User_item);
    }
    // Turn to JSON & output
    echo json_encode($users_arr);
  } else {
    // No Users
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }

?>