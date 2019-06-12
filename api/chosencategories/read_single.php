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
  $chosencategory = new Chosencategories($db);

  $data = json_decode(file_get_contents("php://input"));
 
  $chosencategory->username = $data->username;
 
  //----------CHECK IF USER EXISTS-------------
  $result = $chosencategory->read_single();
  // Get row count
  $num = $result->rowCount();
  // Check if any Users
  if($num > 0) {
    // User array
    $usercategories = array();
    // $users_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      // if(!in_array($category,$usercategories)){
      //  $found = true;
         array_push($usercategories, $category);
      // }
      // Push to "data
      // array_push($usercategories, $category);
    }
    // Turn to JSON & output
    echo json_encode(
        array('message' => $usercategories)
      );
  }else{
    echo json_encode(
        array('message' => "Error OR 0 items")
      );
  }

?>