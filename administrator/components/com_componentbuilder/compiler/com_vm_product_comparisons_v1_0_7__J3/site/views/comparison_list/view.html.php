<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		view.html.php
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

/**
 * Vm_product_comparisons View class for the Comparison_list
 */
class Vm_product_comparisonsViewComparison_list extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{		
		// get combined params of both component and menu
		$this->app = JFactory::getApplication();
		$this->params = $this->app->getParams();
		$this->menu = $this->app->getMenu()->getActive();
		// get the user object
		$this->user = JFactory::getUser();
		// Initialise variables.
		$this->items = $this->get('Items');
		
		/***[JCBGUI.site_view.php_jview_display.29.$$$$]***/
		# Site View / Comparison_List / Add PHP (custom JViewLegacy display) *                
		                $doc = JFactory::getDocument();
				$doc->addStyleSheet('/plugins/vmextended/vm_copmare/assets/css/comparison_list.css');
		//		$doc->addScript('/plugins/vmextended/product_comparisons/assets/js/comparisonsprod.js');
				
				$categoryModel = VmModel::getModel('category');
				$productModel = VmModel::getModel('product');
		
				$this->currency = CurrencyDisplay::getInstance( );
				$this->cid = $this->items[0]->virtuemart_category_id ;
				$this->category = $categoryModel->getCategory( $this->cid );
				
				$productArrID = [] ;
				foreach( $this->items as $product )
				{
					$productArrID[] = $product->virtuemart_product_id  ;
				}#END FOREACH
				$this->products = $productModel->getProducts ( $productArrID );
				$productModel->addImages( $this->products , 1 );
				
				
				JLoader::register( 'ZiffilterModelFvmcategoryfieldscode', JPATH_SITE . '/components/com_ziffilter/models/fvmcategoryfieldscode.php' );
				JLoader::register( 'ZiffilterHelper' , JPATH_BASE . '/components/com_ziffilter/helpers/ziffilter.php' );
				
				VirtueMartModelProduct::$_alreadyLoadedIds = $productArrID ;
				$ZiffilterModel   = new ZiffilterModelFvmcategoryfieldscode();
				$ZiffilterProduct = $ZiffilterModel->getItems();
				
				$this->result = [] ;
				$this->result_name = [] ;
				foreach( $ZiffilterProduct as   $item )
				{
					if( $item->field_add )
					{
						$this->result[$item->name_field_list][$item->virtuemartproduct_id] = $item->value_fild_value ;
						$this->result_name[$item->name_field_list] =  $item->field_name ;
					}#END IF
				}#END FOREACH
		
		                JLoader::register( 'Joomla\CMS\Environment\Browser' , JPATH_LIBRARIES . '/src/Environment/Browser.php' );
				$UserAgent = Joomla\CMS\Environment\Browser::getInstance();
				$isMobile  = $UserAgent->isMobile();
				if( $isMobile )
				{
					$tpl = 'mobilelist';
				}else{
		                       JLoader::register( 'vm_copmare\helper' , JPATH_PLUGINS . '/vmextended/vm_copmare/helpers/helper.php' );
		                       \vm_copmare\helper::AddStyle();
		                }#END IF
		
				
		
				
				/***[/JCBGUI$$$$]***/
		

		// Set the toolbar
		$this->addToolBar();

		// set the document
		$this->_prepareDocument();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		parent::display($tpl);
	}


/***[JCBGUI.site_view.php_jview.29.$$$$]***/
# Site View / Comparison_List / Add PHP (custom JViewLegacy methods) */***[/JCBGUI$$$$]***/


	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{

		// always make sure jquery is loaded.
		JHtml::_('jquery.framework');
		// Load the header checker class.
		require_once( JPATH_COMPONENT_SITE.'/helpers/headercheck.php' );
		// Initialize the header checker.
		$HeaderCheck = new vm_product_comparisonsHeaderCheck;
		
		/***[JCBGUI.site_view.php_document.29.$$$$]***/
		# Site View / Comparison_List / Add PHP (custom document script) */***[/JCBGUI$$$$]***/
		
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/components/com_vm_product_comparisons/assets/css/comparison_list.css', (Vm_product_comparisonsHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// adding the joomla toolbar to the front
		JLoader::register('JToolbarHelper', JPATH_ADMINISTRATOR.'/includes/toolbar.php');
		
		// set help url for this view if found
		$help_url = Vm_product_comparisonsHelper::getHelpUrl('comparison_list');
		if (Vm_product_comparisonsHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_VM_PRODUCT_COMPARISONS_HELP_MANAGER', false, $help_url);
		}
		// now initiate the toolbar
		$this->toolbar = JToolbar::getInstance();
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var, $sorten = false, $length = 40)
	{
		// use the helper htmlEscape method instead.
		return Vm_product_comparisonsHelper::htmlEscape($var, $this->_charset, $sorten, $length);
	}
}
