<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.5
	@build			4th октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		comparisonlistproductmobile.php
	@author			Nikolaychuk Oleg <http://nobd.ml>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('JPATH_BASE') or die('Restricted access');


/***[JCBGUI.layout.php_view.12.$$$$]***/
# Layout -> Comparison_List-Product Mobile -> Custom Script
# Карточка товара в таблице сравнения для мобилок
extract( $displayData );
	$image                 = $product->images[ 0 ];
	$image->file_url_thumb = false;
	$file_url_thumb  = $image->displayMediaThumb( $imageArgs = '' , $lightbox = false , $effect = "" , $return = true , $withDescr = false , $absUrl = false , 100 , 100 );
	$file_url_thumb  = $image->createThumbFileUrl( 100 , 100 );



/***[/JCBGUI$$$$]***/


?>

<!--[JCBGUI.layout.layout.12.$$$$]-->
<?php
# Layout -> Comparison_List-Product Mobile -> Layout	
?>
<div class="comparison-b-i">
    <div class="comparison-offer-img clearfix">
        <a class="pos-fix responsive-img g-picture" id="39023648" href="<?=$product->link ?>">
            <div class="g-tags">
                <div class="g-tags-i"></div>
                <div class="g-tags-i"></div>
            </div>
            <img src="<?= $file_url_thumb ?>"
                 alt="<?= $product->product_name ?>"
                 title="<?= $product->product_name ?>" class=""></a></div>
    <div class="comparison-offer-title">
        <a class="g-title" id="<?=$product->virtuemart_product_id?>" href="<?=$product->link ?>">
            <?= $product->product_name ?>
        </a>
    </div>
    <div class="comparison-offer-price">
        <div class="g-price-wrap available">
            <div class="g-price g-price-cheaper">
                <div class="g-price-uah">
		            <?= shopFunctionsF::renderVmSubLayout( 'prices' , [ 'product' => $product , 'currency' => $currency ] ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--[/JCBGUI$$$$]-->

