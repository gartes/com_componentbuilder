<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		default_mobile.php
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


/***[JCBGUI.template.php_view.2.$$$$]***/
####################################
# Template default_mobile
# default_mobile
# Add PHP (custom view script) *
# Custom Script
echo JLayoutHelper::render( 'productcardmobsvg' , [] );
	$currency           = CurrencyDisplay::getInstance();
	$comparison_listUrl = JRoute::_( 'index.php?option=com_vm_product_comparisons&view=comparison_list' );
	$comparisonUrl      = JRoute::_( 'index.php?option=com_vm_product_comparisons&lang=ru&view=comparison' );
	$fileUrl            = '/components/com_vm_product_comparisons/assets/css/comparison_mobile.min.css';
//	$fileUrl            = '/components/com_vm_product_comparisons/assets/css/comparison_mobile.css';
	Vm_product_comparisonsHelper::loadCss( $fileUrl , true );
	$session     = JFactory::getSession();
	$dataSession = $session->get( 'mobileHistory' , [] , 'com_vm_product_comparisons' );

        $doc = JFactory::getDocument();
	$doc->addStyleSheet( '/components/com_vm_product_comparisons/assets/css/remove_popup.css' );



/***[/JCBGUI$$$$]***/


?>

<!--[JCBGUI.template.template.2.$$$$]-->
<?php 
# Template default_mobile
# default_mobile

?>
 <script>
    ;Comparisons = window.Comparisons || {};
    Comparisons.View = 'comparison';
    Comparisons.comparisonUrl = '<?=$comparisonUrl?>';
    Comparisons.comparison_listUrl = '<?=$comparison_listUrl?>';
</script>
<div class="body-layout" id="content" role="main" style="min-height: 827px;">
    <div name="page">
        <div class="comparison-list-content">
            <div class="comparison-list-header">
                <h1 class="comparison-list-header-title">
                    <span>Списки сравнений</span>
                </h1>
                <p class="comparison-list-header-description">
                    <span>Выберите 2 товара для сравнения</span>
                </p>
            </div>
            <div class="comparison-list-empty-b hidden">
                <span class="comparison-list-empty-b-title">
                    <span>Нет товаров для сравнения</span>
                </span>
           </div>
			<?php
				foreach( $this->items[ 'allProduct' ] as $catID => $item )
				{
					?>
                    <div class="comparison-list-sect clearfix" data-name="category_block"
                         data-category_id="<?= $catID ?>">
                        <div class="comparison-list-sect-header clearfix">
                            <h2 class="comparison-list-sect-header-title">
                                <span class="catName"
                                      data-cat-id="<?= $catID ?>"><?= $item[ 0 ]->category_name ?></span>
                                <span class="comparison-list-sect-header-count"> <?= count( $item ) ?> </span>
                            </h2>
                            <a href="#" class="comparison-list-sect-clear-link"
                               onclick="Comparisons._DELCategory(event)">
                                <span>Удалить</span>
                            </a>
                        </div>
                        <ul class="comparison-list-l">
							<?php
								foreach( $item as $product )
								{
									echo JLayoutHelper::render( 'productcardmob' , [ 'product' => $product , 'currency' => $currency , 'dataSession' => ( isset( $dataSession[ $catID ] ) ? $dataSession[ $catID ] : [] ) , ] );
								}#END FOREACH
							?>
                        </ul>
						<?php
							$catURL = JRoute::_( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $catID , false );
						?>
                        <div class="comparison-list-sect-footer clearfix">
							<?php
								$disabled = 'disabled';
								if( isset( $dataSession[ $catID ] ) && count( $dataSession[ $catID ] ) == 2 )
								{
									$disabled = null;
								}#END IF
							?>
                            <div class="gz btn-link btn-link-blue comparison-list-sect-main-btn <?= $disabled ?>"
                                 onclick="Comparisons.mobileComparison(this)">Сравнить
                            </div>
                            <a class="comparison-list-sect-add-link" href="<?= $catURL ?>">Товар</a>
                        </div>
                    </div>
					<?php
				}#END FOREACH
			?>
        </div>
    </div>
</div>
<template id="TPML-popup">
    <div class="popup-content" name="content">
        <div class="popup-info ">
            <div class="popup-info-text">
                Удалить все товары категории <span class="catName"></span>?
            </div>
            <div class="clearfix popup-info-tools">
                <a class="gz btn-link btn-link-blue popup-info-tools-btn" href="#">Удалить</a>
                <a href="#" class="gz btn-link btn-link-gray popup-info-tools-btn-cancel">Отмена</a>
            </div>
        </div>
    </div>
</template>

<!--[/JCBGUI$$$$]-->

