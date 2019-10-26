<?php extract($displayData);
	$product->virtuemart_product_id ;
	$product->virtuemart_category_id ;
	
	$session = JFactory::getSession();
//	session_id="9b640fffefd62d375215c4ab5d6371df"
//  data-session_name="8b8888489ae3e40ded0d8722ddce8140"

//	session_id="953eeb15852d63e5c6e8f8c49d9cbe1c"
//  data-session_name="8b8888489ae3e40ded0d8722ddce8140"
	

    
?>
<div class="comparisons product-blc"
     data-product_id="<?=$product->virtuemart_product_id?>"
     data-session_Id="<?=$session->getId()?>"
     data-session_Name="<?=$sessionId?>"
     data-category_id="<?=$product->virtuemart_category_id?>"></div>
