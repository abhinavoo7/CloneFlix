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
            
                                // add subtitle  
            
            return "<div class='previewContainer'>
                        <img src='$thumbnail' class='previewImage' hidden>

                        <video poster='thumbnail' autoplay muted class='previewVideo' onended='previewEnded()'>
                            <source src='$preview' type='video/mp4'>
                        </video>

                        <div class='previewOverlay'>
                            
                            <div class='mainDetails'>
                                <h3 style='color:white;'>$name</h3>   
                                <div class='buttons'>
                                    <button class='btn btn-outline-light btn-sm'>
                                        <i class='fas fa-play'></i> Play
                                    </button>
                                    <button onClick='volumeToggle(this)' class='btn btn-outline-light btn-sm'>
                                        <i class='fas fa-volume-mute px-3'></i>
                                    </button>
                                </div>
                            </div>

                        </div>

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