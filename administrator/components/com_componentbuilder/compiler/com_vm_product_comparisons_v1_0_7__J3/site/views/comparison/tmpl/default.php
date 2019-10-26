<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		default.php
	@author			Nikolaychuk Oleg <http://nobd.ml>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');


/***[JCBGUI.site_view.php_view.28.$$$$]***/
# Site View
# PHP TAB
# Add PHP (custom view script) * / Custom Script
        $currency = CurrencyDisplay::getInstance( );
	$doc = JFactory::getDocument();
	$doc->addScript('/plugins/vmextended/vm_copmare/assets/js/product_cart.js');
	$doc->addScript('/plugins/vmextended/vm_copmare/assets/js/product_comparisons_btn.js');
	$doc->addStyleSheet('/plugins/vmextended/vm_copmare/assets/css/product_cart.css');

	$comparison_listUrl = JRoute::_('index.php?option=com_vm_product_comparisons&view=comparison_list');
	$comparisonUrl = JRoute::_('index.php?option=com_vm_product_comparisons&lang=ru&view=comparison');


/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.28.$$$$]-->
<?php 
# Site View -> comparison ->  Default View
# Список всех отобранных товаров
 ?>
<?php // echo JLayoutHelper::render('productcardmob', [?]); ?>
<?php // echo $this->loadTemplate('mobile'); ?>
 <script>
    ;Comparisons = window.Comparisons || {};
    Comparisons.View='comparison' ;
    Comparisons.comparisonUrl = '<?=$comparisonUrl?>';
    Comparisons.comparison_listUrl='<?=$comparison_listUrl?>';
</script>
<div class="browse-view product_comparisons"><?php
		foreach( $this->items['allProduct'] as $virtuemart_category_id => $productArr )
		{
			$category_name = $productArr[ 0 ]->category_name; ?>

                        <?php
			if( count( $productArr ) < 2  )
			{
				echo JLayoutHelper::render('appmessage', [
					'message'=>'Недостаточно товаров для сравнения'
				]);
			}#END IF
                        ?>
            <section class="comparison c-section clearfix" data-category_id="<?= $virtuemart_category_id ?>">
                <div class="catName"><h2><?= $category_name ?></h2></div><?php
					
                    $virtuemart_product_idArr = [] ;
                    foreach( $productArr as $product )
					{
					    echo JLayoutHelper::render( 'productcard' , [
							'product' => $product ,
							'virtuemart_category_id' => $virtuemart_category_id ,
							'category_name' => $category_name ,
							'currency' => $currency ,
						]);
						
						$virtuemart_product_idArr[] = $product->virtuemart_product_id ;
					}#END FOREACH ?>
                <div class="clearfix"></div>
                <?php
	                if( count( $productArr ) > 1  ){
		                $href = JRoute::_('index.php?option=com_vm_product_comparisons&view=comparison_list') ;
	                    ?>
                        <div class="btn-link-to-compare">
			               <a href="<?= $href ?>?ids=<?=implode( ',' , $virtuemart_product_idArr) ?>" class="btn-link btn-link-gray" onclick="">
                                <span class="btn-link-i">Сравнить эти товары</span>
                           </a>
                        </div>
                        <?php
	                }#END IF
                ?>
            </section> <?php
		}#END FOREACH ?>
</div>


<!--[/JCBGUI$$$$]-->

