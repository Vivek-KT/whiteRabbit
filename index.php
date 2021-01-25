<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="mainstyle.css" rel="stylesheet">

</head>

<body>
<?php //include 'mainController.php';
include_once 'connection.php';
?>
<div class="container">
<?php 
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}
if (isset($_GET['filter']) && $_GET['filter']!="") {
    $filters = $_GET['filter'];
} else {
	$filters = 'ASC';
}
$total_records_per_page = 10;
$offset = ($page_no-1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
if ($result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM productlisting")) {
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;
}
if ($result = mysqli_query($conn, "SELECT * FROM productlisting LIMIT $offset, $total_records_per_page")) {
  if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	//echo '<pre>' . print_r($row, true) . '</pre>';
	$product_listing[] = array(
		'productId' => $row['productId'],
		'categoryname' => $row['categoryname'],
		'title' => $row['title'],
		'productDescription' => $row['productDescription'],
		'sellingPrice' => $row['sellingPrice'],
		'imageUrls' => $row['imageUrls'],
		'maximumRetailPrice' => $row['maximumRetailPrice'],
		'productBrand' => $row['productBrand'],
		'inStock' => $row['inStock'],
		'size' => $row['size'],
		'color' => $row['color'],
	);	
	}
  }
}

//echo '<pre>' . print_r($product_listing, true) . '</pre>';
foreach($product_listing as $productlisting){ 

?>
<div class="col-xs-12 col-md-6">
	<!-- First product box start here-->
	<div class="prod-info-main prod-wrap clearfix">
		<div class="row">
		<?php if($productlisting['imageUrls']){ 
			$productImage = $productlisting['imageUrls'];		
		?>
				<div class="col-md-5 col-sm-12 col-xs-12">
					<div class="product-image"> 
					
						<img src="<?php echo $productImage; ?>" alt="400x400" class="img-responsive"> 
						<?php if($productlisting['inStock']){ ?>
						<span class="tag2 sale">
							<?php echo $productlisting['inStock']; ?>
						</span> 
						<?php } ?>
					</div>
				</div>
		<?php  } ?>
				<div class="col-md-7 col-sm-12 col-xs-12">
				<div class="product-deatil">
						<h5 class="name">
							<a href="javascript:void(0);">
								<?php echo $productlisting['title']; ?>
							</a>
						</h5>
						<?php if($productlisting['maximumRetailPrice']) { ?>
						<p class="price-container">
							<span><span style='font-family:Arial;'>&#8377;</span><?php echo $productlisting['maximumRetailPrice']; ?></span>
						</p>
						<?php  } ?>
						<?php /*if($productlisting['maximumRetailPrice']) {
							$amount = $productlisting['maximumRetailPrice'];
							$from_Currency = 'USD';
							$to_Currency = 'INR';
							$amount = urlencode($amount);
							$from_Currency = urlencode($from_Currency);
							$to_Currency = urlencode($to_Currency);
							$get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
							$get = explode("<span class=bld>",$get);
							$get = explode("</span>",$get[1]);
							echo $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
							?>
						<p class="price-container">
							<span><span style='font-family:Arial;'>&#8377;</span><?php echo $productlisting['maximumRetailPrice']; ?></span>
						</p>
						<?php  }*/ ?>
				</div>
				<?php if($productlisting['productDescription']){  
				if (strlen($productlisting['productDescription']) > 160) {
       $stringCut = substr($productlisting['productDescription'], 0, 160);// change 15 top what ever text length you want to show.
       $endPoint = strrpos($stringCut, ' ');
       $productlisting['productDescription'] = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
       $productlisting['productDescription'] .= '... <a style="cursor: pointer;" href="javascript:void(0);" >Read More</a>';
   }?>
				<div class="description">
					<p><?php  echo $productlisting['productDescription']; ?> </p>
				</div>
				<?php  } ?>
				<div class="product-info smart-form">
					<div class="row">
						<div class="col-md-12"> 
							<?php  if($productlisting['productBrand']) {?> <a href="javascript:void(0);" class="btn btn-info"><?php  echo $productlisting['productBrand']; ?> </a><?php  } ?>
                            <?php  if($productlisting['color']) {?><a href="javascript:void(0);" class="btn btn-default"><?php  echo $productlisting['color']; ?></a><?php  } ?>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product -->


        
</div>
<?php  } ?>

<div class="pagebottom">
<div class ='pagecount'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>
<ul class="pagination">
<?php if($page_no > 1){
echo "<li><a href='?page_no=1'>First Page</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href='?page_no=$previous_page'";
} ?>>Previous</a>
</li>
    
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href='?page_no=$next_page'";
} ?>>Next</a>
</li>
 
<?php if($page_no < $total_no_of_pages){
echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
} ?>
</ul>
</div>

</div>
</body>
</html>

