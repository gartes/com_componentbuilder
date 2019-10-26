<?php
	defined( '_JEXEC' ) or die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' );
	
	
	$count       = count( $this->products );
	$categoryUrl = JRoute::_( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $this->cid . '&virtuemart_manufacturer_id=0' );
	
	


?>

<div class="comparison-title">
    <h1 class="comparison-title-text">Сравниваем <span class="comparison-title-text-i"><?=$this->category->category_name?></span></h1>
    <a href="<?= $categoryUrl ?>" class="comparison-list-clear blacklink" name="clear_comparison_goods" data-section="<?=$this->cid?>">
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
                                <img src="https://i1.rozetka.ua/goods/13681495/115815277_images_13681495021.jpg"
                                     width="50" height="37">
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
									$image          = $product->images[ 0 ];
									$file_url_thumb = $image->displayMediaThumb( $imageArgs = '' , $lightbox = false , $effect = "" , $return = true , $withDescr = false , $absUrl = false , 60 , 60 );
									$file_url_thumb = $image->createThumbFileUrl( 60 , 60 );
									
									//							    echo'<pre>';print_r( $product->product_name );echo'</pre>'.__FILE__.' '.__LINE__;
									?>
                                    <div class="comparison-t-head-cell valigned-top">
                                        <input type="hidden" name="position_number115815277" value="1">
                                        <div class="available" data-context="up" data-location="compare">
                                            <a href="#" class="comparison-g-delete"
                                               data-product_id="<?= $product->virtuemart_product_id ?>"
                                               name="fromcomparison"
                                               onclick="Comparisons._DEL(event)"
                                               title="Удалить">
                                                <img src="https://i.rozetka.com.ua/design/_.gif"
                                                     class="comparison-g-delete-icon sprite" alt="X">
                                            </a>
                                            <div class="comparison-g-top-b clearfix">
                                                <a href="https://bt.rozetka.com.ua/115815277/p115815277/"
                                                   class="comparison-g-img responsive-img" onclick="">
                                                    <img src="<?= $file_url_thumb ?>" width="60" height="60"
                                                         alt="Доработка Aqua BRK к фильтру с обратным осмосом"
                                                         title="Доработка Aqua BRK к фильтру с обратным осмосом"
                                                         style="border: none; visibility: visible; zoom: 1; opacity: 1;">
                                                </a>
                                                <a href="<?= $product->link ?>"
                                                   class="comparison-g-title g-title novisited" onclick="">
													<?= $product->product_name ?>
                                                </a>
                                            </div>
                                            <div class="g-id-wrap clearfix">
                                                <div class="g-id"
                                                     style="display: none;"><?= $product->product_sku ?></div>
                                            </div>
                                            <div class="g-price" name="price">
                                                <div class="g-price-uah">
													<?= shopFunctionsF::renderVmSubLayout( 'prices' , [ 'product' => $product , 'currency' => $this->currency ] ); ?>
                                                    <!--                                                <span class="g-price-uah-sign">&thinsp;грн</span>-->
                                                </div>
                                            </div>
                                            <ul class="g-tools inline">
                                                <li class="g-tools-i">
                                                    <div class="comparison-g-buy-small-btn" name="buy_small_comparison">
                                                        <div class="toOrder">
                                                            <form method="POST"
                                                                  action="https://my.rozetka.com.ua/cgi-bin/form.php?r=https://my.rozetka.com.ua/cart/&amp;action=buy">
                                                                <input type="hidden" value="115815277" name="goods_id">
                                                                <span class="sprite-side btn-link g-cart"> <button
                                                                            class="btn-link-i" type="submit"
                                                                            title="Купить"
                                                                            name="topurchases">  &nbsp;  </button> </span>
                                                            </form>
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
                                    </div>
									<?php
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
										}#END IF
										?>
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
									}#END FOREACH
								
								?>

                            </div>
							<?php
						}#END FOREACH ?>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="browse-view vm_copmare">
    <section class="comparison c-section clearfix">
		<?php
		
		
		?>
</div>
