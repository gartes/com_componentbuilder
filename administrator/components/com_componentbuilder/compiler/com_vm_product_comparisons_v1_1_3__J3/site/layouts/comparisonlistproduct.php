<?php
	/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
					Gstes Co.
	/-------------------------------------------------------------------------------------------------------/
	
		@version		1.0.3
		@build			30th сентября, 2019
		@created		23rd сентября, 2019
		@package		vm_product_comparisons
		@subpackage		comparisonlistproduct.php
		@author			Nikolaychuk Oleg <http://nobd.ml>
		@copyright		Copyright (C) 2015. All Rights Reserved
		@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
	  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____
	 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
	.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(
	\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__)
	
	/------------------------------------------------------------------------------------------------------*/
	
	// No direct access to this file
	defined( 'JPATH_BASE' ) or die( 'Restricted access' );


?>

<!--[JCBGUI.layout.layout.10.$$$$]-->
<?php
	extract( $displayData );
	$image                 = $product->images[ 0 ];
	$image->file_url_thumb = false;
	$file_url_thumb        = $image->displayMediaThumb( $imageArgs = '' , $lightbox = false , $effect = "" , $return = true , $withDescr = false , $absUrl = false , 60 , 60 );
	$file_url_thumb        = $image->createThumbFileUrl( 60 , 60 );
?>
<div class="comparison-t-head-cell valigned-top" data-name="product-block" data-product_id="<?=$product->virtuemart_product_id?>">
    
    <div class="available" data-context="up" data-location="compare">
        
        <a href="#" class="comparison-g-delete" data-product_id="<?=$product->virtuemart_product_id?>"  name="fromcomparison" onclick="Comparisons._DEL(event)" title="Удалить">
            <img src="https://i.rozetka.com.ua/design/_.gif" class="comparison-g-delete-icon sprite" alt="X">
        </a>
        
        <div class="comparison-g-top-b clearfix">
            <a href="<?= $product->link ?>" class="comparison-g-img responsive-img" onclick="">
                <img src="<?= $file_url_thumb ?>" width="60" height="60"
                     alt="<?= $product->product_name ?>"
                     title="<?= $product->product_name ?>"
                     style="border: none; visibility: visible; zoom: 1; opacity: 1;">
            </a>
            <a href="<?= $product->link ?>"
               class="comparison-g-title g-title novisited" onclick="">
				<?= $product->product_name ?>
            </a>
        </div>
        
        <div class="g-id-wrap clearfix">
            <div class="g-id" style="display: none;">
				<?= $product->product_sku ?>
            </div>
        </div>
        
        <div class="g-price" name="price">
            <div class="g-price-uah">
				<?= shopFunctionsF::renderVmSubLayout( 'prices' , [ 'product' => $product , 'currency' => $currency ] ); ?>
            </div>
        </div>
        <ul class="g-tools inline">
            <li class="g-tools-i" >
                <div class="comparison-g-buy-small-btn" name="buy_small_comparison">
                    <div class="g-tools">
                        <a href="#" class="g-tools-i small" onclick="Comparisons.MobileAddToCart(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="svg-icon cart-icon svg-green"><use xlink:href="#cart"></use></svg></a>
                    </div>
                </div>
            </li>
            
            <li class="g-tools-i g-tools-delimiter">
                <div name="wishlists_catalog_new_tile"><a href="#Wishlist"
                                                          name="towishlist"
                                                          class="g-wishlist"
                                                          id="wishlist-popup-115815277">
                        <img src="https://i.rozetka.com.ua/design/_.gif"
                             alt="В&nbsp;список желаний"
                             title="В&nbsp;список желаний" width="25" height="22"
                             class="sprite g-wishlist-icon"> </a></div>
            </li>
        </ul>
        <div class="g-rating-wrap">
            <div class="g-rating">
                <a class="novisited g-rating-reviews-link"
                   href="https://bt.rozetka.com.ua/115815277/p115815277/comments/#t_comments"
                   onclick="">
                                                    <span class="g-rating-reviews">
                                                        <span class="g-rating-none sprite-side">Оставить отзыв</span>
                                                    </span>
                </a>
            </div>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

