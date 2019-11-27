<?php include "business/categoryB.php"; ?>
<?php 
// $test = new CategoryP;
// $test->ShowAllCategories();
class CategoryP{
    public function GetCategory(){
        $category_id;
        if (!isset($_GET['category'])){
            $category_id = 0;
        }
        else {
            $category_id = $_GET['category'];
        }
        return $category_id;
    }
    
    public function GetGroup(){
        $product_group;
        if (!isset($_GET['product_group'])){
            $product_group = 1;
        }
        else {
            $product_group = $_GET['product_group'];
        }
        return $product_group;
    }
    public function SetStyleForCurrentCategory($cat_id){
        $style = "";
        $current_cat = $this->GetCategory();
        if ($current_cat == $cat_id)
        {
            $style = "style='color: red'";
        }
        return $style;
    }
    public function ShowAllCategories(){
        $cb = new categoryB();
        $result = $cb->GetAllCategories();
        while($row = mysqli_fetch_array($result))
        {
            $category = <<<DELIMITER
             <a href="index.php?category={$row['id']}&product_group=1" {$this->SetStyleForCurrentCategory($row['id'])} class="list-group-item">{$row['name']}</a> 
            DELIMITER;
            echo $category;
        }
    }
    public function ShowLinkPagination(){
        $cb = new categoryB();
        $current_cat = $this->GetCategory();
        $num = $cb->CalculateNumberOfLinks($current_cat);
        for ($x = 1; $x <= $num; $x++) {
            $link = <<<DELIMITER
                <li class="page-item"><a class="page-link" href="index.php?category={$current_cat}&product_group={$x}">{$x}</a></li>
                DELIMITER;
            echo $link;
        }
    }
}
?>