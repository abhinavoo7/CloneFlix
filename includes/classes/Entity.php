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

        public function getSeasons(){
            $query = $this->con->prepare("Select * from videos where entityId=:id 
                                            and isMovie=0 Order By season, episode ASC");
            $query->bindValue(":id", $this->getId());
            $query->execute();

            $seasons = array();
            $videos = array();
            $currentSeason = null;
            while($row = $query->fetch(PDO::FETCH_ASSOC)){

                if($currentSeason != null && $currentSeason != $row["season"]){
                    $seasons[] = new Season($currentSeason, $videos);
                    $videos = array();
                }

                $currentSeason = $row["season"];
                $videos[] = new Video($this->con, $row); 
            }

            if(sizeof($videos) != 0){
                $seasons[] = new Season($currentSeason, $videos);
            }

            return $seasons;
        }
    }

?>