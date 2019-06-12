<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  include_once '../../config/Database.php';
  include_once '../../models/Chosencategories.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog post object
  $chosencategory = new Chosencategories($db);

  $data = json_decode(file_get_contents("php://input"));
 
  $chosencategory->username = $data->username;
  $chosencategory->category = $data->category;
 
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
   
  }

  if(!in_array($data->category,$usercategories)){
  // Get raw usered dat
  // Create user
  if($chosencategory->create()) {
    echo json_encode(
      array('message' => 'Category Added')
    );
  } else {
    echo json_encode(
      array('message' => 'Category Not Added !Error')
    );
  }
}
else{
  echo json_encode(
    array('message' => 'Category already exists')
  );
}


?>