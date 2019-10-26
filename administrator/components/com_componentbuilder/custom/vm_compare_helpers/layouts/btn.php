<?php
	
	extract ($displayData);
	$checkTxt = ( $check ? 'Добавлено к сравнению' : 'Добавить к сравнению' ) ;
	
	?>

<div class="btn-comparisons">
            <span class="incomparison">
                <form method="post" name="comparisons" class="comparisons-form">
                    <label class="g-tools-to-compare-label">
<!--                        checked="checked" -->
                    <input class="g-tools-to-compare-check" type="checkbox" name="tocomparison" />
	                    <!--                        g-compare-added -->
                    <a href="#" class="g-compare <?= ($check?'g-compare-added':'')?>  sprite-side">
                        <img src="https://i.rozetka.ua/design/_.gif" alt="<?= $checkTxt ?>"
                             title="<?= $checkTxt ?>"
                             width="27" height="22" class="sprite g-compare-icon">
                    </a>
                </label>
                <input type="hidden" name="virtuemart_category_id" value="<?= $virtuemart_category_id ?>"/>
                <input type="hidden" name="virtuemart_product_id" value="<?= $prod ?>"/>
                <input type="hidden" name="option" value="com_virtuemart"/>
                <input type="hidden" name="view" value="comparisons"/>
                <input type="hidden" name="task" value="add_comparisons"/>
                </form>
            </span>
</div>
	









































	
	
	
	