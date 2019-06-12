<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  include_once '../../config/Database.php';
  include_once '../../models/User.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog post object
  $user = new User($db);

  $data = json_decode(file_get_contents("php://input"));

  //----------CHECK IF USER EXISTS-------------
  $result = $user->read();
  // Get row count
  $num = $result->rowCount();



  // Check if any Users
  if($num > 0) {
    // User array
    $users_arr = array();
    // $users_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      if($username == $data->username){
       $found = true;
        
      }
      // Push to "data
      // array_push($users_arr['data'], $User_item);
    }
    // Turn to JSON & output
   
  }



  if($found!=true){
  // Get raw usered data
 
  $user->username = $data->username;
  $user->password = $data->password;
  // Create user
  if($user->create()) {
    echo json_encode(
      array('message' => 'User Created')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Created !Error')
    );
  }
}else{
  echo json_encode(
    array('message' => 'UserExists')
  );
}


?>