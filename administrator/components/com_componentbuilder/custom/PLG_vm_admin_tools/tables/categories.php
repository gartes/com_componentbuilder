<?php
/**
*
* Product table
*
* @package	VirtueMart
* @subpackage Category
* @author jseros
* @link https://virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: categories.php 9881 2018-06-20 09:03:58Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * Category table class
 * The class is is used to table-level abstraction for Categories.
 *
 * @package	VirtueMart
 * @subpackage Category
 * @author jseros
 */
	// vm_admin_tools_category
class TableVm_admin_toolsCategories extends JTable {

	/** @var int Primary key */
//	var $virtuemart_category_id	= null;
	/** @var integer Product id */
	// var $short_category_name		= '';
	/** @var string Category name */
	
	private $my_tbl = '#__vm_admin_tools_category' ;

	/**
	 * Class contructor
	 *
	 * @author Max Milbers
	 * @param $db database connector object
	 */
	public function __construct($db) {
	
		$app = \JFactory::getApplication() ;
		$view = $app->input->get('view') ;
		
		
		
		parent::__construct( $this->my_tbl,   'virtuemart_category_id'  , $db);
		
//
//		die(__FILE__ .' Lines '. __LINE__ );
		if( $view == 'vm_admin_tools' )
		{
//			$this->_tbl_key = false ;
//			$this->_tbl_keys = false ;
		}
	}
	
	public function storeMy(){
		$id = $this->virtuemart_category_id ;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true) ;
		$query->select('*')->from($this->my_tbl)->where('virtuemart_category_id = ' . $id );
		$db->setQuery($query);
		$Result = $db->loadResult();
		if( !$Result )
		{
			$this->_tbl_key = false ;
			$this->_tbl_keys = false ;
		}#END IF
		
		echo'<pre>';print_r( $Result );echo'</pre>'.__FILE__.' '.__LINE__;
		// die(__FILE__ .' Lines '. __LINE__ );
		
		//		$res = $this->load($id) ;
		/*if( !$res )
		{
			$this->_tbl_key = false ;
			$this->_tbl_keys = false ;
		}#END IF
		$this->_tbl_key = false ;
		$this->_tbl_keys = false ;*/
		
//		echo'<pre>';print_r( $res );echo'</pre>'.__FILE__.' '.__LINE__;
//		echo'<pre>';print_r( $this );echo'</pre>'.__FILE__.' '.__LINE__;
//		die(__FILE__ .' Lines '. __LINE__ );
		return parent::store();
	}
	
	private function CheckInShort(){
		$db=JFactory::getDbo();
		
	}
	
	public function load($tbl_key= NULL, $reset = true){
		// Code that may throw an Exception or Error.
		$this->virtuemart_category_id = $tbl_key ;
		return parent::load($tbl_key) ;
	}
	
	
}
