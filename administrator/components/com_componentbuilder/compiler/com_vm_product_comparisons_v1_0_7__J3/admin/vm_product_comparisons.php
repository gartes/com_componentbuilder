<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		vm_product_comparisons.php
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
JHtml::_('behavior.tabstate');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_vm_product_comparisons'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
};

// Add CSS file for all pages
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_vm_product_comparisons/assets/css/admin.css');
$document->addScript('components/com_vm_product_comparisons/assets/js/admin.js');

// require helper files
JLoader::register('Vm_product_comparisonsHelper', __DIR__ . '/helpers/vm_product_comparisons.php'); 
JLoader::register('JHtmlBatch_', __DIR__ . '/helpers/html/batch_.php'); 

// Get an instance of the controller prefixed by Vm_product_comparisons
$controller = JControllerLegacy::getInstance('Vm_product_comparisons');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
