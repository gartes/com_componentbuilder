<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		ajax.php
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

jimport('joomla.application.component.helper');

/**
* Vm_product_comparisons Ajax Model
* @since 3.9
*
*/
class Vm_product_comparisonsModelAjax extends JModelList
{
	protected $app_params;
    protected $app;

    /**
    * Vm_product_comparisonsModelAjax constructor.
    * @since 3.9
    */
	public function __construct()
	{
		parent::__construct();
		// get params
		$this->app_params = JComponentHelper::getParams('com_vm_product_comparisons');

        $this->app = \JFactory::getApplication() ;
	}#END FUNCTION

    

	// Used in comparison

/***[JCBGUI.site_view.php_ajaxmethod.28.$$$$]***/
# Site View -> Comparison All
# PHP TAB
# Add PHP (AJAX) *
public function getLayotNow($layotName){
	$dataLayot = $this->app->input->get( 'dataLayot' , [] , 'ARRAY' );
	$html = JLayoutHelper::render( $layotName , $dataLayot );
	echo new JResponseJson( [ 'html' => $html ] );
	$this->app->close();
}#END FN

        /**
	 * Обработка истории отмеченных ческбоксов товаров на мобильных устройствах
	 *
	 * @param $operation  - Оператор добавления
	 *
	 * @since 3.9
	 */
	public function Js_eventHistory ( $operation )
	{
		$virtuemart_category_id = $this->app->input->get( 'virtuemart_category_id' , 0 , 'INT' );
		$virtuemart_product_id  = $this->app->input->get( 'virtuemart_product_id' , 0 , 'INT' );
		$session                = JFactory::getSession();
		$dataSession            = $session->get( 'mobileHistory' , [] , 'com_vm_product_comparisons' );
		
		if( !isset( $dataSession[ $virtuemart_category_id ] ) )
		{
			$dataSession[ $virtuemart_category_id ] = [];
		}#END IF
		
		if( $operation == 'add' )
		{
			$dataSession[ $virtuemart_category_id ][ $virtuemart_product_id ] = true;
		}
		else
		{
			if( isset( $dataSession[ $virtuemart_category_id ][ $virtuemart_product_id ] ) )
			{
				unset( $dataSession[ $virtuemart_category_id ][ $virtuemart_product_id ] );
			}#END IF
		}#END IF
		
		if( !count( $dataSession[ $virtuemart_category_id ] ) )
		{
			unset( $dataSession[ $virtuemart_category_id ] );
		}#END IF
		
		$session->set( 'mobileHistory' , $dataSession , 'com_vm_product_comparisons' );
		echo new JResponseJson( $dataSession );
		$this->app->close();
	}#END FN

/***[/JCBGUI$$$$]***/


}#END CLASS
