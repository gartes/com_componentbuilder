<?php
	/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
					Gstes Co.
	/-------------------------------------------------------------------------------------------------------/
	
		@version		1.0.5
		@build			4th октября, 2019
		@created		23rd сентября, 2019
		@package		vm_product_comparisons
		@subpackage		removepopup.php
		@author			Nikolaychuk Oleg <http://nobd.ml>
		@copyright		Copyright (C) 2015. All Rights Reserved
		@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
	  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____
	 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
	.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(
	\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__)
	
	/------------------------------------------------------------------------------------------------------*/
	
	// No direct access to this file
	defined( 'JPATH_BASE' ) or die( 'Restricted access' );
	
	

?>

<div class="g-remove-popup">
	<div class="g-remove-tools">
        <a href="#" class="g-remove-tools-i wishlists">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
			     class="svg-icon wishlists-icon svg-yellow">
				<use xlink:href="#wishlists"></use>
			</svg>
			<span>Добавить</span>
            <br>
            <span>в список желаний</span>
        </a>
        <a href="#" class="g-remove-tools-i remove">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
			     class="svg-icon cross-icon svg-red">
				<use xlink:href="#cross"></use>
			</svg>
			<span>Удалить</span> товар<br><span>из списка</span>
            <br>
        </a>
    </div>
	<a href="#" class="g-remove-cancel">
		<span>Отмена</span>
	</a>
</div>
