<?php 
session_start();
include_once 'connection.php';
$str = file_get_contents('flipkart_category_product.json');
$json = json_decode($str, true);
//echo '<pre>' . print_r($json['productInfoList'], true) . '</pre>';
foreach($json['productInfoList'] as $productlisting){
	$productListDetails = $productlisting['productBaseInfo'];
	$category_name = $productListDetails['productIdentifier']['categoryPaths']['categoryPath'][0][0]['title'];
	$product_title = mysqli_real_escape_string($conn,$productListDetails['productAttributes']['title']);
	$product_desc = mysqli_real_escape_string($conn,$productListDetails['productAttributes']['productDescription']);
	if($productListDetails['productAttributes']['imageUrls']){ 
		if(isset($productListDetails['productAttributes']['imageUrls']['400x400'])){
			$productImage = $productListDetails['productAttributes']['imageUrls']['400x400'];
		}else {
			$productImage = '600px-No_image_available.png';
		}
	}
	$product_mrp_amount =  $productListDetails['productAttributes']['maximumRetailPrice']['amount'];
	$product_sp_amount =  $productListDetails['productAttributes']['sellingPrice']['amount'];
	$product_brand =  $productListDetails['productAttributes']['productBrand'];
	$product_stock =  $productListDetails['productAttributes']['inStock'];
	$product_size =  $productListDetails['productAttributes']['size'];
	$product_color =  $productListDetails['productAttributes']['color'];
	$productId =  $productListDetails['productIdentifier']['productId'];
	$sql = "INSERT INTO productlisting( productId, categoryname, title, productDescription, imageUrls, sellingPrice, maximumRetailPrice, productBrand, inStock, size, color) VALUES ( '".$productId."', '".$category_name."', '".$product_title."', '".$product_desc."', '".$productImage."', '".$product_sp_amount."', '".$product_mrp_amount."', '".$product_brand."', '".$product_stock."', '".$product_size."', '".$product_color."');";	
	//echo $sql;
	if (mysqli_query($conn, $sql)) {
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}		
?>