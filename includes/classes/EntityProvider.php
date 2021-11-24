<?php
class EntityProvider {

    public static function getEntities($con, $categoryId, $limit, $mightLike) {
        $sql = "SELECT * FROM entities ";
        if($categoryId != null) {
            $sql .= "WHERE categoryId=:categoryId ";
        }
        if($mightLike !=0 ){
            $sql .= "And id!=:mightLike ";
        }
        $sql .= "ORDER BY RAND() LIMIT :limit";
        $query = $con->prepare($sql);
        if($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }
        if($mightLike != 0){
            $query->bindValue(":mightLike", $mightLike);
        }
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();
        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row);
        }
        return $result;
    }
    
    public static function getTVShowEntities($con, $categoryId, $limit) {
        $sql = "SELECT Distinct(entities.id) FROM entities Inner Join videos on entities.id = videos.entityId 
                            Where videos.isMovie=0 ";
        if($categoryId != null) {
            $sql .= "And categoryId=:categoryId ";
        }
        $sql .= "ORDER BY RAND() LIMIT :limit";
        $query = $con->prepare($sql);
        if($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();
        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row["id"]);
        }
        return $result;
    }
    
    public static function getMoviesEntities($con, $categoryId, $limit) {
        $sql = "SELECT Distinct(entities.id) FROM entities Inner Join videos on entities.id = videos.entityId 
                            Where videos.isMovie=1 ";
        if($categoryId != null) {
            $sql .= "And categoryId=:categoryId ";
        }
        $sql .= "ORDER BY RAND() LIMIT :limit";
        $query = $con->prepare($sql);
        if($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();
        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row["id"]);
        }
        return $result;
    }

}