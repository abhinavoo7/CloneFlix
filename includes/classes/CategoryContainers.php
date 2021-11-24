<?php
class CategoryContainers {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function showAllCategories() {
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, true, 0);
        }

        return $html . "</div>";
    }
    public function showTVShowCategories() {
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>
                    <h1>TV Shows</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, false, 0);
        }

        return $html . "</div>";
    }
    
    public function showMovieCategories() {
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>
                    <h1>Movies</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, false, true, 0);
        }

        return $html . "</div>";
    }

    // You might also like
    public function showCategory($categoryId, $title=null, $mightLike){
        $query = $this->con->prepare("SELECT * FROM categories where id=:id");
        $query->bindValue(":id", $categoryId);
        $query->execute();

        $html = "<div class='previewCategories'>";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, $title, true, true, $mightLike);
        }

        return $html . "</div>";
    }

    private function getCategoryHtml($sqlData, $title, $tvShows, $movies, $mightLike) {
        $categoryId = $sqlData["id"];
        $title = $title == null ? $sqlData["name"] : $title;
        if($tvShows && $movies) {
            $entities = EntityProvider::getEntities($this->con, $categoryId, 30, $mightLike);
        }
        else if($tvShows) {
            // Get tv show entities
            $entities = EntityProvider::getTVShowEntities($this->con, $categoryId, 30);
        }
        else {
            // Get movie entities
            $entities = EntityProvider::getMoviesEntities($this->con, $categoryId, 30);
        }
        if(sizeof($entities) == 0) {
            return;
        }
        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach($entities as $entity) {
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }
        return "<div class='category'>
                    <a href='category.php?id=$categoryId'>
                        <h3>$title</h3>
                    </a>

                    <div class='entities scrollbars_none'>
                        $entitiesHtml
                    </div>
                </div>";
    }

} 