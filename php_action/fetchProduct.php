<?php 	

require_once 'core.php';
$USER = (int)$_SESSION['userId'];

$sql = "SELECT product.product_id, product.product_name,
        product.categories_id, product.quantity, product.rate,product.originalPrice, product.createDate,product.updateDate, product.active, product.status, 
 	    categories.categories_name FROM product 
		INNER JOIN categories ON product.categories_id = categories.categories_id  
		WHERE product.status = 1  ORDER BY product.product_id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row[0];
 	// active
     if($row[3] <= 0 )
     {
         $active = "<label class='label label-danger'>Not Available</label>";
     }

 	elseif($row[9] == 1) {
 		// activate member
 		$active = "<label class='label label-success'>Available</label>";
 	} else {
 		// deactivate member
 		$active = "<label class='label label-danger'>Not Available</label>";
 	} // /else

     if ($USER !== 1) {
         $button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle"  disabled="true" data-toggle ="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct(' . $productId . ')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct(' . $productId . ')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';
     }
     else{

         $button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct(' . $productId . ')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct(' . $productId . ')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';

     }

	// $brandId = $row[3];
	// $brandSql = "SELECT * FROM brands WHERE brand_id = $brandId";
	// $brandData = $connect->query($sql);
	// $brand = "";
	// while($row = $brandData->fetch_assoc()) {
	// 	$brand = $row['brand_name'];
	// }

	$category = $row[10];

 	$output['data'][] = array( 		
 		// image
 		//$productImage,
 		// product name

        $category,
 		$row[1], 
		$row[5],
 		$row[4],
 		// quantity 
 		$row[3],
		$row[6],
		$row[7],
 		// brand
 		//$brand,
 		// category 		

 		// active
 		$active,
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);