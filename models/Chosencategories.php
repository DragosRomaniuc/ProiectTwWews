<?php
    class Chosencategories{
        //DB stuff
         // DB stuff
         public $conn;
         private $table = 'chosencategories';
         public $category;
         public $username;
         // User Properties
        

        //Constructor with DB;
        public function __construct($db){
            $this->conn = $db;
        }

        public function read() {
            // Create query
            $query = 'SELECT * from chosencategories';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Execute query
            $stmt->execute();
            return $stmt;
          }

        
      public function read_single(){
        $query = 'SELECT category from chosencategories where username = :username';

          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':username', $this->username);
          // $stmt->bindParam(1, $this->id);
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          return $stmt;
      }


      public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET category = :category, username = :username';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->category = htmlspecialchars(strip_tags($this->category));
        // Bind data
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':category', $this->category);
        // Execute query
        if($stmt->execute()) {
          return true;
    }

    
    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);
    return false;
  }


  public function delete() {
    // Create query
    $query = 'DELETE FROM chosencategories WHERE username = :username AND category = :category';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Clean data
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->category = htmlspecialchars(strip_tags($this->category));
    // Bind data
    $stmt->bindParam(':username', $this->username);
    $stmt->bindParam(':category', $this->category);
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