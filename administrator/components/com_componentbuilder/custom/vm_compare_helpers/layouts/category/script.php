<?php
	extract($displayData);
	?>
<script> 
    // Sctipt PLG Product Comparisons
    document.addEventListener("DOMContentLoaded", function () {
        Comparisons = window.Comparisons || {};
        Comparisons.category_id = '<?= $virtuemart_category_id ?>';
        var load = ['/plugins/vmextended/vm_copmare/assets/js/product_comparisons_btn.js'];
        if (typeof gn_z11 === 'undefined') {
            var I;
            I = setInterval(function () {
                if (typeof gn_z11 === 'function') {
                    clearInterval(I);
                    var gnz11 = new gn_z11();
                    gnz11.loadedAndEvent("comparisons_loaded", load)
                }
            }, 500);
        } else {
            setTimeout(function () {
                var gnz11 = new gn_z11();
                gnz11.loadedAndEvent("comparisons_loaded", load)
            }, 500)
        }
    });
</script>