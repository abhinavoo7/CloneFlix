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
            
            $videoId = VideoProvider::getEntityVideoForUser($this->con, $id, $this->username);
            
            return "<div class='previewContainer'>
                        <img src='$thumbnail' class='previewImage' hidden>

                        <video poster='thumbnail' autoplay muted class='previewVideo' onended='previewEnded()'>
                            <source src='$preview' type='video/mp4'>
                        </video>

                        <div class='previewOverlay'>
                            
                            <div class='mainDetails'>
                                <h3 style='color:white;'>$name</h3>   
                                <div class='buttons'>
                                    <button onClick='watchVideo($videoId);' class='btn btn-outline-light btn-sm'>
                                        <i class='fas fa-play'></i> Play
                                    </button>
                                    <button id='hideButton' onClick='volumeToggle(this)' class='btn btn-outline-light btn-sm'>
                                        <i class='fas fa-volume-mute px-3'></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>";
        }

        public function createEntityPreviewSquare($entity){
            $id = $entity->getId();
            $name = $entity->getName();
            $thumbnail = $entity->getThumbnail();
        // $preview = $entity->getPreview(); 
        return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>";
        }

        private function getRandomEntity(){

            // $query = $this->con->prepare("Select * from entities order by RAND() Limit 1");
            // $query->execute();

            // // Get the data and store it into an associativa array
            // $row = $query->fetch(PDO::FETCH_ASSOC); 

            // return new Entity($this->con, $row);

            $entity = EntityProvider::getEntities($this->con, null, 1, 0);
            return $entity[0];
        }

    }

?>