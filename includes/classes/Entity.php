<?php

    class Entity{

        private $con, $sqlData;
        
        // input var can be data from the database or an entity id

        public function __construct($con, $input) {
            $this->con = $con;

            if(is_array($input)){
                $this->sqlData = $input;
            } else{
                $query = $this->con->prepare("Select * from entities where id=:id");
                $query->bindValue(":id", $input);
                $query->execute();

                // Get the data and store it into an associativa array
                $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            }
            
        }

        public function getId(){
            return $this->sqlData["id"];
        }
        
        public function getName(){
            return $this->sqlData["name"];
        }
        
        public function getThumbnail(){
            return $this->sqlData["thumbnail"];
        }
        
        public function getPreview(){
            return $this->sqlData["preview"];
        }
    }

?>