<?php

    class PreviewProvider{

        private $con, $username;

        public function __construct($con, $username) {
            $this->con = $con;
            $this->username = $username;
        }

        public function createCategoryPreviewVideo($categoryId){
            $entitiesArray = EntityProvider::getEntities($this->con, $categoryId, 1, 0);

            if(sizeof($entitiesArray) == 0){
                ErrorMessage::show("No categories to display");
            }

            return $this->createVideoPreview($entitiesArray[0]);
        }
        
        public function createTVShowPreviewVideo(){
            $entitiesArray = EntityProvider::getTVShowEntities($this->con, null, 1);

            if(sizeof($entitiesArray) == 0){
                ErrorMessage::show("No TV shows to display");
            }

            return $this->createVideoPreview($entitiesArray[0]);
        }
        
        public function createMoviesPreviewVideo(){
            $entitiesArray = EntityProvider::getMoviesEntities($this->con, null, 1);

            if(sizeof($entitiesArray) == 0){
                ErrorMessage::show("No Movies to display");
            }

            return $this->createVideoPreview($entitiesArray[0]);
        }

        public function createVideoPreview($entity){
            
            if($entity == null){
                $entity = $this->getRandomEntity();
            }

            $id = $entity->getId();
            $name = $entity->getName();
            $thumbnail = $entity->getThumbnail();
            $preview = $entity->getPreview();
                                   
            $videoId = VideoProvider::getEntityVideoForUser($this->con, $id, $this->username);
            $video = new Video($this->con, $videoId);
            $seasonEpisode = $video->getSeasonAndEpisode();
            $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";
            
            return "<div class='previewContainer'>
                        <img src='$thumbnail' class='previewImage' hidden>

                        <video poster='thumbnail' autoplay muted class='previewVideo' onended='previewEnded()'>
                            <source src='$preview' type='video/mp4'>
                        </video>

                        <div class='previewOverlay'>
                            
                            <div class='mainDetails'>
                                <h3 style='color:white;'>$name</h3>
                                <div class='subHeading'>
                                    $subHeading 
                                </div>  
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