<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			27th сентября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		productcard.php
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


/***[JCBGUI.layout.php_view.6.$$$$]***/
/***[/JCBGUI$$$$]***/
?>
 <?php
    # Layout Add PHP (custom view script) *
	$app      = JFactory::getApplication();
	$user     = JFactory::getUser();
	$isRoot   = $user->authorise( 'core.admin' );
 
	extract ($displayData);
	
	$image = $product->images[ 0 ];
	$image->file_url_thumb = false ;
	$file_url_thumb = $image->displayMediaThumb(
	        $imageArgs='',
            $lightbox=false,
            $effect="",
            $return=true,
            $withDescr=false,
            $absUrl=false ,
            90 , 90
    );
	$file_url_thumb = $image->createThumbFileUrl(90 , 90 ); ?>
<div class="c-section-g-i clearfix">
    <form method="post" name="comparisons" class="comparisons-form">
        <a href="#" class="c-section-g-i-delete" data-product_id="<?= $product->virtuemart_product_id?>" title="Удалить" name="fromcomparison"
           onclick="Comparisons._DEL(event)">
            <img class="c-section-g-i-delete-icon sprite" src="https://i.rozetka.ua/design/_.gif" alt="X">
        </a>
        <div class="c-section-g-i-image">
            <a onclick="" href="<?= $product->link ?>">
                <img src="<?= $file_url_thumb ?>" width="90" height="90"
                     alt="<?= $product->product_name ?>" title="<?= $product->product_name ?>" style="border:none">
                <div class="g-id" style="display:none"><?=$product->product_sku?></div>
            </a>
        </div>
        <div class="c-section-g-i-info available">
            <div class="c-section-g-i-info-title">
                <a onclick="" href="<?= $product->link ?>"
                   class="block title-limit title-limit-two"><?= $product->product_name ?></a>
            </div>
            <div class="g-i-status-wrap">
				<?php
					$status = true;
					if( ( $product->product_in_stock - $product->product_ordered ) < 1 )
					{
						$status = false;
					}#END IF
				?>
                <div class="g-i-status  <?= ( !$status ? '' : 'available' ) ?>">
					<?= ( !$status ? 'Нет в наличии' : 'Есть в наличии' ) ?>
                </div>
            </div>
            <div class="g-price" name="price">

                <div class="rprodprice"><?= shopFunctionsF::renderVmSubLayout( 'prices' , [ 'product' => $product , 'currency' => $currency ] ); ?></div>

            </div>
        </div>
        <a class="g-compare g-compare-added"></a>
        <input type="hidden" name="virtuemart_category_id" value="<?= $virtuemart_category_id ?>"/>
        <input type="hidden" name="virtuemart_product_id" value="<?= $product->virtuemart_product_id ?>"/>
        <input type="hidden" name="option" value="com_virtuemart"/>
        <input type="hidden" name="view" value="comparisons"/>
        <input type="hidden" name="task" value="add_comparisons"/>
        
    </form>
</div>






