<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  include_once '../../config/Database.php';
  include_once '../../models/Chosencategories.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog User object
  $chosencategories = new Chosencategories($db);
  // Blog User query
  $result = $chosencategories->read();
  // Get row count
  $num = $result->rowCount();
  // Check if any Users
  if($num > 0) {
    // User array
    $category_arr = array();
    // $category_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $chosencategory_item = array(
        'username' => $username,
        'category' => $category,
      );
      // Push to "data"
      array_push($category_arr, $chosencategory_item);
      // array_push($users_arr['data'], $User_item);
    }
    // Turn to JSON & output
    echo json_encode($category_arr);
  } else {
    // No Users
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }

?>