<?php
    class User{
        //DB stuff
         // DB stuff
         public $conn;
         private $table = 'users';
         // User Properties
         public $id;
         public $category_id;
         public $category_name;
          public $title;
          public $body;
         public $author;
         public $created_at;
        

        //Constructor with DB;
        public function __construct($db){
            $this->conn = $db;
        }

        public function read() {
            // Create query
            $query = 'SELECT * from users';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Execute query
            $stmt->execute();
            return $stmt;
          }
        
        
      public function read_single(){
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
        FROM ' . $this->table . ' p
        LEFT JOIN
          categories c ON p.category_id = c.id
        Where p.id = ?
          LIMIT 0,1';

          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(1, $this->id);
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $this->title = $row['title'];
          $this->body = $row['body'];
      }


      public function create() {
        
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET username = :username, password = :password';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        
        // var_dump($encoded);
        


        // $this->username = htmlspecialchars(strip_tags($this->username));
        // $this->password = htmlspecialchars(strip_tags($this->password));
        // Bind data
        
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        // $hash = substr( $hash, 0, 60 );
//         if( password_verify($this->password,$hash) ){
//         $stmt->bindParam(':password', $hash);}
// else {$stmt->bindParam(':password', $new);}

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hash);
       
        // Execute query
        if($stmt->execute()) {
          return true;
    }
    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);
    return false;
  }
    }
?>