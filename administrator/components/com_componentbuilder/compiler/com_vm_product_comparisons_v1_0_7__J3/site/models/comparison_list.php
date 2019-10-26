<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		comparison_list.php
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
 * Vm_product_comparisons Model for Comparison_list
 */
class Vm_product_comparisonsModelComparison_list extends JModelList
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
			array('a.id','a.sesion_id','a.user_id','a.virtuemart_category_id','a.virtuemart_product_id','a.params','a.published','a.created_by','a.modified_by','a.created','a.modified','a.checked_out','a.checked_out_time','a.version','a.hits','a.ordering'),
			array('id','sesion_id','user_id','virtuemart_category_id','virtuemart_product_id','params','published','created_by','modified_by','created','modified','checked_out','checked_out_time','version','hits','ordering')));
		$query->from($db->quoteName('#__vm_product_comparisons_copmare', 'a'));

		// Filtering.

/***[JCBGUI.dynamic_get.php_getlistquery.44.$$$$]***/
#Comparison_List Dynamic Get / Add PHP (getListQuery - JModelList) *
$ids = $this->input->get('ids' , false , 'RAW') ;
$query->where('a.virtuemart_product_id IN ('.$ids.')'  );
$query->where('a.published = 1'  );
$query->group('a.virtuemart_product_id');


/***[/JCBGUI$$$$]***/


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
        
        
        
        


/***[JCBGUI.dynamic_get.php_before_getitems.44.$$$$]***/
#Comparison_List Dynamic Get / Add PHP (before getting the Items) */***[/JCBGUI$$$$]***/


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
        


/***[JCBGUI.dynamic_get.php_after_getitems.44.$$$$]***/
#Comparison_List Dynamic Get / Add PHP (after getting the Items) */***[/JCBGUI$$$$]***/


		// return items
		return $items;
	}#END FUNCTION
    
    
    
}
