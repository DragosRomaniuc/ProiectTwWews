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
  $result = $chosencategory->delete();
  // Get row count
  
  // Get raw usered dat
  // Create user
  if($result) {
    echo json_encode(
      array('message' => 'Category Deleted')
    );
  }else{
    echo json_encode(
        array('message' => 'Category not deleted')
      );
  }


?>