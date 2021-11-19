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

}