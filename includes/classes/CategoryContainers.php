<?php

    class CategoryContainers{

        private $con, $username;

        public function __construct($con, $username) {
            $this->con = $con;
            $this->username = $username;
        }

        // Output every category that has an entity
        public function showAllCategories(){

            $query = $this->con->prepare("Select * from categories");
            $query->execute();
            $html = "<div class='previewCategories'>";

            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $html .= $row["name"];
            }

            return $html."</div>";
        }
    }
?>