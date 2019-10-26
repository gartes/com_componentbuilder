<?php
	defined( '_JEXEC' ) or die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' );


?>
<div class="browse-view product_comparisons"><?php
		$layout = new \JLayoutFile( 'product_cart' , JPATH_PLUGINS . DS . 'vmextended/vm_copmare/layouts' );
		foreach( $this->products as $virtuemart_category_id => $productArr )
		{
			$category_name = $productArr[ 0 ]->category_name; ?>
            <section class="comparison c-section clearfix" data-category_id="<?= $virtuemart_category_id ?>">
                <div class="catName"><h2><?= $category_name ?></h2></div><?php
					foreach( $productArr as $product )
					{
						echo $layout->render( [ 'product' => $product , 'virtuemart_category_id' => $virtuemart_category_id , 'category_name' => $category_name , 'currency' => $this->currency ] );
					}#END FOREACH
				
				?>
                <div class="clearfix"></div>
                <div class="btn-link-to-compare">
                    <a href="/index.php?option=com_virtuemart&view=comparisonsprod&cid=<?= $virtuemart_category_id ?>"
                       class="btn-link btn-link-gray" onclick="">
                        <span class="btn-link-i">Сравнить эти товары</span>
                    </a>
                </div>
            </section> <?php
		}#END FOREACH ?>
</div>
