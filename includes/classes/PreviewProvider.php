<?php

    class PreviewProvider{

        private $con, $username;

        public function __construct($con, $username) {
            $this->con = $con;
            $this->username = $username;
        }

        public function createVideoPreview($entity){
            
            if($entity == null){
                $entity = $this->getRandomEntity();
            }

            $name = $entity->getName();
            echo $name;
        }

        private function getRandomEntity(){

            $query = $this->con->prepare("Select * from entities order by RAND() Limit 1");
            $query->execute();

            // Get the data and store it into an associativa array
            $row = $query->fetch(PDO::FETCH_ASSOC); 
            
            return new Entity($this->con, $row);
        }

    }

?>