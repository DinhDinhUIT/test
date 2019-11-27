<?php include "business/productB.php"; ?>
<?php include "business/inventoryB.php"; ?>
<?php include "business/productAnalysisB.php"; ?>
<?php 
class ProductP{
    private $from = "2019-08-01";
    private $to = "2019-10-05";
    public function GetIdProductCurrent(){
        $product_id = 0;
        if (isset($_GET['id'])){
            $product_id = $_GET['id'];
        }
        return $product_id;
    }
    public function ShowProductsByUser(){
        $cp = new CategoryP();
        $category_id = $cp->GetCategory();
        $product_group = $cp->GetGroup();
        if($category_id == 0)
        {
            $this->ShowFeaturedProduct();
        }
        else{
            $this->ShowProductInGroup($category_id, $product_group);
        }
    }
    public function ShowSingleProduct($product)
    {
        $item = <<<DELIMITER
                    <div class="col-lg-12 col-md-12 mb-12">
                    <div class="card h-100">
                    <a href="item.php?id={$product['id']}"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                    <div class="card-body">
                        <h4 class="card-title">
                        <a href="item.php?id={$product['id']}">{$product['name']}</a>
                        </h4>
                        <h5>\${$product['price']}</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                        <button type="button" class="btn btn-success">Add to Cart!!</button>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                    </div>
                    </div>
                </div>
            DELIMITER;
            echo $item;
    }
    public function ShowProduct($product)
    {
        $item = <<<DELIMITER
                    <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                    <a href="item.php?id={$product['id']}"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                    <div class="card-body">
                        <h4 class="card-title">
                        <a href="item.php?id={$product['id']}">{$product['name']}</a>
                        </h4>
                        <h5>\${$product['price']}</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                        <button type="button" class="btn btn-success">Add to Cart!!</button>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                    </div>
                    </div>
                </div>
            DELIMITER;
            echo $item;
    }
    public function ShowFeaturedProduct(){
        $from = "2019-08-01";
        $to = "2019-10-05";
        //1. Get product list sorted by performance
        $ib = new InventoryB();
        $featuredList = $ib->GetPoorPerformanceList($from, $to);
        foreach($featuredList as $x => $x_value)
        {
            $pb = new ProductB();
            $result = $pb->GetProduct($x);
            $row = mysqli_fetch_array($result);
            $this->ShowProduct($row);
        }
    }
    public function ShowProductInCategory(){
        $pb = new ProductB();
        $cp = new CategoryP();
        $category_id = $cp->GetCategory();
        $result = $pb->GetProductInCategory($category_id);
        // $result = $pb->GetProductInCategory2($category_id);
        if ($result == null) {
            echo "<div style='text-align: center; width: 100%;'>No Product Here!</div>";
            return;
        }
        while($row = mysqli_fetch_array($result))
        {
            $this->ShowProduct($row);
        }
    }
    public function ShowProductItem(){
        $pb = new ProductB();
        $pab = new ProductAnalysisB();
        $product_id = $this->GetIdProductCurrent();

        $result = $pb->GetProduct($product_id);
        if ($result == null) {
            echo "<div style='text-align: center; width: 100%;'>No Product Here!</div>";
            return;
        }
        $row = mysqli_fetch_array($result);
        $this->ShowSingleProduct($row);

        $pab->UpdateViewOfProduct($product_id);
    }
    
    public function ShowProductInGroup($category_id, $product_group){
        $cb = new CategoryB();
        $result = $cb->GetProductsInGroup($category_id, $product_group);
        while($row = mysqli_fetch_array($result))
        {
            $this->ShowProduct($row);
        }
    }
}
?>