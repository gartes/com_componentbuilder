<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.5
	@build			4th октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		productcardmob.php
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


/***[JCBGUI.layout.php_view.7.$$$$]***/
# Layout Add PHP (custom view script) *
        if( isset( $displayData ) )
	{
		extract ($displayData);
	}
	
	 $image = $product->images[ 0 ];
	 $image->file_url_thumb = false ;
	 $file_url_thumb = $image->displayMediaThumb(
		 $imageArgs='',
		 $lightbox=false,
		 $effect="",
		 $return=true,
		 $withDescr=false,
		 $absUrl=false ,
		 60 , 60
	 );
	 $file_url_thumb = $image->createThumbFileUrl(60 , 60 );
 
        $checked = false ;
	$svg = null ;
	$spanClass = 'checkbox-label' ;
	if( isset( $dataSession[$product->virtuemart_product_id] ) )
	{
		$checked = true ;
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="svg-icon check-icon svg-white"><use xlink:href="#check"></use></svg>' ;
		$spanClass = 'checkbox-label-active' ;
	}else{
		if(count($dataSession) == 2 ){
			$spanClass = 'checkbox-label-disabled';
		}#END IF
    }#END IF
######################################################/***[/JCBGUI$$$$]***/


?>

<!--[JCBGUI.layout.layout.7.$$$$]-->
<?php
# Layout -> productcardmob -> Add/Edit Customcode
# Карточка товара-Сравнение Категория MOBILE
?>
<li class="comparison-list-l-i" data-name="product-block" data-product_id="<?=$product->virtuemart_product_id?>" >
    <div class="comparison-list-checkbox">
        <div class="checkbox-block " >
            <label class="checkbox" >
                <input type="checkbox"
	                <?=($checked?'checked':null)?>
                       class="hidden checkbox-input <?=($checked?'checked':null)?>"
                       name="pruduct_id[]"
                       value="<?=$product->virtuemart_product_id?>"
                >
                <span class="<?=$spanClass?>" onclick="Comparisons.CheckboxEvt(this)" >
                    <?= $svg ?>
                </span>
            </label>
        </div>
    </div>
    <div class="comparison-list-offer clearfix">
        <a class="pos-fix responsive-img g-picture" id="<?=$product->virtuemart_product_id?>" href="<?= $product->link ?>">
            <div class="g-tags">
                <div class="g-tags-i"></div>
                <div class="g-tags-i"></div>
            </div>
            <img src="<?= $file_url_thumb ?>"
                 alt="<?=$product->product_name?>"
                 title="<?=$product->product_name?>" class="">
        </a>
        <div class="g-info-b clearfix">
            <a class="g-title" type="offer" id="<?=$product->virtuemart_product_id?>" location="" href="<?= $product->link ?>">
                <?=$product->product_name?>
            </a>
            <div class="g-info-b-i">
                <div class="g-price-wrap available">
                    <div class="g-price ">
	                    <?= shopFunctionsF::renderVmSubLayout( 'prices' , [ 'product' => $product , 'currency' => $currency ] ); ?>
                    </div>
                </div>
                <div class="g-list-i-b-tools">
                    <div class="g-tools">
                        <a href="#" class="g-tools-i small" onclick="Comparisons.MobileAddToCart(event)">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                 class="svg-icon cart-icon svg-green">
                                <use xlink:href="#cart"></use>
                            </svg>
                        </a>
                    </div>
                    <a href="#" class="remove-i"  onclick="Comparisons.RemoveMobile(event,this)">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                             class="svg-icon more-icon ">
                            <use xlink:href="#more"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</li>
<!--[/JCBGUI$$$$]-->

