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

            $id = $entity->getId();
            $name = $entity->getName();
            $thumbnail = $entity->getThumbnail();
            $preview = $entity->getPreview();
            
            return "<div class='previewContainer'>
                        <img src='$thumbnail' class='previewImage' hidden>

                        <video autoplay muted class='previewVideo'>
                            <source src='$preview' type='video/mp4'>
                        </video>

                    </div>";
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