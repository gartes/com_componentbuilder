<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');
	
	$app = \JFactory::getApplication() ;
	$option = $app->input->get('option') ;
	$view = $app->input->get('view') ;
	
	
	/*echo'<pre>';print_r(  );echo'</pre>'.__FILE__.' '.__LINE__;
	die(__FILE__ .' Lines '. __LINE__ );*/
	
	
	?>
 
<script>
    (function (d) {
        setTimeout(function() {
            
            
            var load=['/plugins/vmextended/vm_copmare/assets/js/comparisons.core.js?i=1'];
            if (typeof gn_z11 === 'undefined') {
                var I;
                I = setInterval(function () {
                    if (typeof gn_z11 === 'function') {
                        clearInterval(I);
                        var gnz11 = new gn_z11();
                        gnz11.loadAssets( load ).then(function (a) {
                            d.addEventListener("ComparisonsModulUpdate", function () {
                                Comparisons.ModulUpdate();
                            })
                        } , function (err) { console.log( err ) });
                    }
                }, 500);
            } else {
                setTimeout(function () {
                    var gnz11 = new gn_z11();
                    gnz11.loadAssets( load ).then(function (a) {
                        d.addEventListener("ComparisonsModulUpdate", function () {
                            Comparisons.ModulUpdate();
                        })

                    } , function (err) { console.log( err ) });
                }, 500)
            }
        },500);
    })(document)
</script>
<style>
    .sprite-both:after, .sprite-both:before, .sprite-side:before {
        content: '';
        position: absolute;
        background-image: url(/modules/mod_virtuemart_zif_filter/assets/img/sprite.svg)!important;
        background-repeat: no-repeat;
    }
	div#comparison .hub-i-comparison-link:not(.hub-i-link-empty) {
		cursor:pointer;
	}
	div#comparison.comparison-m.label {
		position: fixed;
		right: 10px;
		background: #494949;
		border-radius: 50%;
		bottom: 40px;
        z-index: 1000;
	}
    i.total_products-i {
        position: absolute;
        background: #fd802b;
        padding: 5px;
        border-radius: 100%;
        width: 21px;
        text-align: center;
        height: 21px;
        left: -7px;
        bottom: 0;
        border: 1px solid;
    }
</style>
<div class="wrp">
    <?php
	    if( $option != 'com_vm_product_comparisons' && $view != 'comparison' )
	    {
		    echo $this->sublayout('comparison_html' , [] );
	    }#END IF
    ?>
	
</div>


