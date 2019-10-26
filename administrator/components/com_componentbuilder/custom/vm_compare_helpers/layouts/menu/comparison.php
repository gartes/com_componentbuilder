<?php
	
	
	
	?>
<script>
    (function (d) {
        setTimeout(function() {
            

             var load=['/plugins/vmextended/vm_copmare/assets/js/comparisons.core.js'];
			 var gnz11 = new gn_z11();
			 gnz11.loadAssets( load ).then(function (a) {
				 d.addEventListener("ComparisonsModulUpdate", function () {
					 Comparisons.ModulUpdate();
				 })
				 
			 } , function (err) { console.log( err ) });
        },500);
    })(document)
</script>

<?= $this->sublayout('comparison_html' , [] ); ?>

