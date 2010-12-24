<center>
<h1> 
  <?php echo $product['Product']['short_description'];?>
</h1>

<h1>
  &#3647 <?php echo $product['Product']['selling_price'];?> <?php echo " / "?>
  <?php echo $product['Product']['quantity'];?>
</h1>

<?php 
  e($html->image('/attachments/photos/small/' . 
                 $product['Product']['image']));
 ?>
</center>



			