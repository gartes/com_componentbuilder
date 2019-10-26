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


/***[JCBGUI.site_view.php_view.29.$$$$]***/
# Site View / Comparison_List / Add PHP (custom view script) *

// echo $this->loadTemplate('mobilelist');

$count       = count( $this->products );
$categoryUrl = JRoute::_( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $this->cid . '&virtuemart_manufacturer_id=0' );
$comparison_listUrl = JRoute::_('index.php?option=com_vm_product_comparisons&view=comparison_list');
$comparisonUrl = JRoute::_('index.php?option=com_vm_product_comparisons&lang=ru&view=comparison');
/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.29.$$$$]-->
<?php 
#Site View / Comparison_List
echo JLayoutHelper::render( 'productcardmobsvg' , [] );
?>
<script>
    ;Comparisons = window.Comparisons || {};
    Comparisons.View='comparison_list' ;
    Comparisons.comparisonUrl = '<?=$comparisonUrl?>';
    Comparisons.comparison_listUrl='<?=$comparison_listUrl?>';
</script>

<div class="comparison-title">
    <h1 class="comparison-title-text">Сравниваем <span class="comparison-title-text-i"><?=$this->category->category_name?></span></h1>
    <a href="<?= $categoryUrl ?>" class="comparison-list-clear blacklink" name="clear_comparison_goods" data-section="<?=$this->cid?>" onclick="Comparisons.del_cat_comparisons(event , <?=$this->cid?>)">
        Очистить все
    </a>
</div>
<section class="comparison c-section clearfix" data-category_id="<?= $this->cid ?>">
    <div class="comparison comparison-<?= $count ?>-goods">
        <div class="wrap container aligned-center" name="comparison_container"
             style="overflow-x: scroll; will-change: scroll-position;">
            <div class="comparison-t-container" name="table_container">
                <div class="comparison-t-head-wrap" name="table_head_wrap" style="will-change:transform;top: 0px;">
                    <div class="comparison-t-head" name="table_head" style="">
                        <div class="comparison-t-head-row">
                            <div class="comparison-t-head-cell-first valigned-top">
                                <a href="<?= $categoryUrl ?>" class="comparison-g-link novisited clearfix">
                                    <span class="comparison-g-img responsive-img">
                                        <img src="https://i1.rozetka.ua/goods/13681495/115815277_images_13681495021.jpg" width="50" height="37">
                                    </span>
                                    <span class="comparison-g-title">Добавить<br>еще одну модель</span>
                                </a>
                                <div id="compare-menu">
                                    <ul class="m-tabs">
                                        <li class="m-tabs-i">
                                            <span class="m-tabs-link novisited active">Все параметры</span>
                                        </li>
                                        <li class="m-tabs-i">
                                            <a href="#only-different" onclick="Comparisons.onlyDifferent(event)" class="m-tabs-link novisited">Только отличия</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
							
							<?php
                                foreach( $this->products as $product )
								{
									echo JLayoutHelper::render( 'comparisonlistproduct' , [ 'product' => $product , 'currency' => $this->currency , ] );
				                }#END FOREACH
							?>
                        </div>
                    </div>
                </div>
                <div class="comparison-t-head-clone" name="table_head_clone" style=""></div>
                <div class="comparison-t">
					<?php
						foreach( $this->result_name as $i => $item )
						{
							$class = null;
							?>
                            <div class="comparison-t-row" name="different">
                                <div class="comparison-t-cell-first valigned-middle">
									<?= $item ?>
                                </div>
								<?php
									$oldValue = false;
									
									foreach( $this->products as $product )
									{
										$valueF = $this->result[ $i ][ $product->virtuemart_product_id ];
										if( $oldValue && $oldValue != $valueF )
										{
											$class = 'differences';
										}#END IF ?>
                                        <div class="comparison-t-cell <?= $class ?> " data-product_id="<?= $product->virtuemart_product_id ?>">
                                            <div class="comparison-chars-t">
                                                <div class="comparison-chars-t-row">
                                                    <div class="comparison-chars-value">
                                                        <span class="chars-value-inner">
                                                            <?= $valueF ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										<?php
										$oldValue = $valueF;
									}#END FOREACH ?>
                            </div>
							<?php
						}#END FOREACH ?>
                </div>
            </div>
        </div>
    </div>
</section>




<!--[/JCBGUI$$$$]-->

