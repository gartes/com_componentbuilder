<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		comparison.php
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
 * Vm_product_comparisons Model for Comparison
 */
class Vm_product_comparisonsModelComparison extends JModelList
{
	/**
	 * Model user data.
	 *
	 * @var        strings
	 */
	protected $user;
	protected $userId;
	protected $guest;
	protected $groups;
	protected $levels;
	protected $app;
	protected $input;
	protected $uikitComp;

    /**
    * Метод построения запроса SQL для загрузки данных списка.
    * Method to build an SQL query to load the list data.
    *
    * @return	string	An SQL query
    * @throws Exception
    * @since 3.9
    */
	protected function getListQuery()
	{
        # Получить текущего пользователя для проверки авторизации
        # Get the current user for authorisation checks
		$this->user = JFactory::getUser();
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();
		$this->app = JFactory::getApplication();
		$this->input = $this->app->input;
		$this->initSet = true;

        
		// Make sure all records load, since no pagination allowed.
		$this->setState('list.limit', 0);
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Get from #__vm_product_comparisons_copmare as a
		$query->select($db->quoteName(
			array('a.id','a.asset_id','a.sesion_id','a.virtuemart_category_id','a.virtuemart_product_id','a.user_id','a.published','a.created_by','a.modified_by','a.created','a.modified','a.version','a.hits','a.ordering'),
			array('id','asset_id','sesion_id','virtuemart_category_id','virtuemart_product_id','user_id','published','created_by','modified_by','created','modified','version','hits','ordering')));
		$query->from($db->quoteName('#__vm_product_comparisons_copmare', 'a'));

		// Filtering.

/***[JCBGUI.dynamic_get.php_getlistquery.43.$$$$]***/
		# Get List Query
		# Custom Script
		#Add PHP (getListQuery - JModelList) *
		
		$session = JFactory::getSession();
		$penthouse = $this->app->input->get('penthouse' , false );
		if( !$this->userId )
		{
			if( !$penthouse )
			{
				$query->where('a.sesion_id = ' . $db->quote($session->getId()));
			}#END IF
		}else{
			$query->where('a.user_id = ' . $db->quote($this->userId));
		}#END IF



/***[/JCBGUI$$$$]***/

		// Get where a.published is 1
		$query->where('a.published = 1');

		// return the query object
		return $query;
	}#END FUNCTION

	/**
	 * Метод, чтобы получить массив элементов данных.
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 * @since 3.9
     */
	public function getItems()
	{
		$user = JFactory::getUser();
        
        
        
        


/***[JCBGUI.dynamic_get.php_before_getitems.43.$$$$]***/
		# Get List Query
		# Custom Script
		#Add PHP (before getting the Items) */***[/JCBGUI$$$$]***/


		// load parent items
		$items = parent::getItems();

		// Get the global params
		$globalParams = JComponentHelper::getParams('com_vm_product_comparisons', true);
        

		// Insure all item fields are adapted where needed.
		if (Vm_product_comparisonsHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// Always create a slug for sef URL's
				$item->slug = (isset($item->alias) && isset($item->id)) ? $item->id.':'.$item->alias : $item->id;
			}
		}
        


/***[JCBGUI.dynamic_get.php_after_getitems.43.$$$$]***/
                # Get List Query
		# Custom Script
		#Add PHP (after getting the Items) * 
		if(!class_exists('VmModel'))require(VMPATH_ADMIN.DS.'helpers'.DS.'vmmodel.php');
		
		$productModel = \VmModel::getModel ('product');
		$productInCetegoryArr = [] ; 
		$products = [] ;
		
		$products['allProductCount'] = count($items ) ;
		foreach( $items as $i => &$item )
		{
			$productInCetegoryArr[ $item->virtuemart_category_id ][ $item->id ] = $item->virtuemart_product_id ;
		}#END FOREACH
                # TODO - создать надстройку для penthouse
		#
		$penthouse = $this->input->get('penthouse' , false );
		if( $penthouse )
		{
			$productInCetegoryArr = ['252'=>array( '1202' , '1186' , '1168' )];
		}#END IF
		foreach( $productInCetegoryArr as $catId => $prodArr )
		{
			$prod = $productModel->getProducts ( $prodArr );
			$productModel->addImages( $prod , 1 );
			$products['allProduct'][$catId] = $prod ;
		}#END FOREACH
		
		$items = $products ;
		# END Get List Query

/***[/JCBGUI$$$$]***/


		// return items
		return $items;
	}#END FUNCTION
    
    
    
}
