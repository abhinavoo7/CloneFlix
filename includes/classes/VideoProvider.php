<?php

    class VideoProvider{

        public static function getUptNext($con, $currentVideo){
            $query = $con->prepare("Select * from videos where entityId = :entityId
                                     videoId!=:videoId And (
                                         (season = :season And episode > :episode) OR season > :season
                                     ) Order By season, episode Asc Limit 1");
            $query->bindData(":entityId", $currentVideo->getEntityId());
            $query->bindData(":videoId", $currentVideo->getId());
            $query->bindData(":season", $currentVideo->getSeasonNumber());
            $query->bindData(":episode", $currentVideo->getEpisodeNumber());
            $query->execute();
            if($query->rowCount() == 0){
                $query = $con->prepare("Select * from video where season<=1 and episode<=1
                                        And id!=:videoId Order By views Desc Limit 1");
                $query->bindData(":videoId", $currentVideo->getId());
                $query->execute();
            }

            $row = $query->fetch(PDO::FETCH_ASSOC);
            return new Video($con, $row);
        }
    }

?>