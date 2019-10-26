<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.5
	@build			4th октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		appmessage.php
	@author			Nikolaychuk Oleg <http://nobd.ml>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('JPATH_BASE') or die('Restricted access');


/***[JCBGUI.layout.php_view.11.$$$$]***/
# Layout - app-message / Add PHP (custom view script) *
       extract( $displayData );
	$doc = JFactory::getDocument();
//	$doc->addStyleSheet( '/plugins/vmextended/vm_copmare/assets/css/app_message.css' );
    $doc->addStyleDeclaration('
   
    ');

/***[/JCBGUI$$$$]***/


?>

<!--[JCBGUI.layout.layout.11.$$$$]-->
<div name="app-message">
<style>
    .message {
        position: relative;
        max-width: 31.6em;
        margin: .7em 0;
        padding: 1.35em 3.4em;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 1rem;
        line-height: 1.25rem;
        z-index: 2;
    }
    .message.code2 {
        background-color: #f7fbfd;
        border: solid 1px rgba(178,213,244,.75);
    }
    .sprite-both:after, .sprite-both:before, .sprite-side:before {
        content: \'\';
        position: absolute;
    }
    .message.code2:before {
        background-position: -296px -838px;
        width: 25px;
        height: 25px;
        left: 11px;
        top: 12px;
    }
    .message-close-link {
        position: absolute;
        top: 7px;
        right: 5px;
    }
    .message-close-link-img {
        background-position: -131px -878px;
        width: 24px;
        height: 24px;
    }
    .message-close-link-img:hover {
        background-position: -376px -838px;
        width: 24px;
        height: 24px;
    }
</style>

    <div class="pos-fix sprite-side message code2">
        <a href="" class="message-close-link" onclick="Comparisons.clearUserMessages(event);"> 
            <img src="https://i.rozetka.ua/design/_.gif" width="24" height="24" class="sprite message-close-link-img"> 
        </a>
        <?= $message ?>
    </div>
</div><!--[/JCBGUI$$$$]-->

