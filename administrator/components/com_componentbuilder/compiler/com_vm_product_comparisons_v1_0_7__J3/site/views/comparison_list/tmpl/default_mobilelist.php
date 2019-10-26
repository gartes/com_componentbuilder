<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		default_mobilelist.php
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


/***[JCBGUI.template.php_view.3.$$$$]***/
####
# Template Comparison_List - Mobile
# Custom Script
       
       $fileUrl = '/components/com_vm_product_comparisons/assets/css/comparison_list_mobile.min.css' ;
       Vm_product_comparisonsHelper::loadCss( $fileUrl , true );

	$comparison_listUrl = JRoute::_( 'index.php?option=com_vm_product_comparisons&view=comparison_list' );
	$comparisonUrl      = JRoute::_( 'index.php?option=com_vm_product_comparisons&lang=ru&view=comparison' );


###########################/***[/JCBGUI$$$$]***/


?>

<!--[JCBGUI.template.template.3.$$$$]-->
<?php 
# Template Comparison_List - Mobile
// echo JLayoutHelper::render('comparisonlistproductmobile', []);
 
?>
<div name="page">
    <div class="comparison-content">

        <div class="comparison-header"><h1>Сравнение товаров</h1>
            <div class="backward-link comparison-category-link">
                <a class="nav-l-i-link" href="<?= $comparisonUrl ?>">
                    <span class="nav-l-i-link-inner">
                        <span>Выбрать другие модели</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="comparison-b">
			<?php
				foreach( $this->products as $product )
				{
					echo JLayoutHelper::render( 'comparisonlistproductmobile' , [ 'product' => $product , 'currency' => $this->currency , ] );
				}#END FOREACH
			?>
        </div>
		<?php
			foreach( $this->result_name as $i => $item )
			{
				?>
                <div class="comparison-b-wrap"><h3 class="comparison-b-title"><?= $item ?></h3>
                    <div class="comparison-b">
						<?php
							foreach( $this->products as $product )
							{
								$valueF = $this->result[ $i ][ $product->virtuemart_product_id ];
								?>
                                <div class="comparison-b-i"><?= $valueF ?></div>
								<?php
							}#END FOREACH
						?>
                    </div>
                </div>
				<?php
			}#END FOREACH?>
    </div>
</div>



<!--[/JCBGUI$$$$]-->

