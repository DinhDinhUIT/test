<?php 
class ProductB{
    public function IncreaseView($product_id){
        $sql = "UPDATE product SET view = view + 1 WHERE id = {$product_id}";
        $db = new database;
        $result = $db->update($sql);
    }
    public function GetProduct($product_id){
        $sql = "SELECT * FROM product WHERE id = {$product_id}";
        $db = new database;
        $result = $db->select($sql);
        return $result;
    }
    public function GetProductInCategory($category_id){
    $sql = "SELECT * FROM product WHERE category_id = {$category_id}";
        $db = new database;
        $result = $db->select($sql);
        return $result;
    }
    public function GetProductInCategory2($category_id){
        $sql = "SELECT t4.*, t3.performance
        FROM product as t4
        INNER JOIN
        (SELECT t1.*
        FROM inventory_performance as t1
        INNER JOIN
        (
            SELECT product_id, MAX(id) AS latest_id
            FROM inventory_performance
            GROUP BY product_id
        )as t2
            ON t1.product_id = t2.product_id AND t1.id = t2.latest_id) as t3 ON t3.product_id = t4.id
        WHERE t4.category_id = {$category_id}";
            $db = new database;
            $result = $db->select($sql);
            return $result;
        }
}
?>