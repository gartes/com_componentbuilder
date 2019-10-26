<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		copmare_list.php
	@author			Nikolaychuk Oleg <http://nobd.ml>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

# No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Copmare_list Model
 * @since 3.9
 * @author Gartes
 */
class Vm_product_comparisonsModelCopmare_list extends JModelList
{
    /**
    * Vm_product_comparisonsModelCopmare_list constructor.
    *
    * @param   array  $config
    * @since 3.9
    * @author Gartes
    */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
        {
			$config['filter_fields'] = array(
				'a.id','id',
				'a.published','published',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'a.sesion_id','sesion_id',
				'a.user_id','user_id',
				'a.virtuemart_category_id','virtuemart_category_id',
				'a.virtuemart_product_id','virtuemart_product_id'
			);
		}

		parent::__construct($config);
	}#END FUNCTION
    

    /**
    * Способ автоматического заполнения модельного состояния.
    * Method to auto-populate the model state.
    * @param   null  $ordering
    * @param   null  $direction (asc | desc)
    *
    * @return  void
    * @throws Exception
    * @since 3.9
    *
    * @author Gartes
    * @see https://api.joomla.org/cms-3/classes/Joomla.CMS.MVC.Model.ListModel.html#method_setState
    */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

        # Настройте контекст для поддержки модальных макетов
		# Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}
		$sesion_id = $this->getUserStateFromRequest($this->context . '.filter.sesion_id', 'filter_sesion_id');
		$this->setState('filter.sesion_id', $sesion_id);

		$user_id = $this->getUserStateFromRequest($this->context . '.filter.user_id', 'filter_user_id');
		$this->setState('filter.user_id', $user_id);

		$virtuemart_category_id = $this->getUserStateFromRequest($this->context . '.filter.virtuemart_category_id', 'filter_virtuemart_category_id');
		$this->setState('filter.virtuemart_category_id', $virtuemart_category_id);

		$virtuemart_product_id = $this->getUserStateFromRequest($this->context . '.filter.virtuemart_product_id', 'filter_virtuemart_product_id');
		$this->setState('filter.virtuemart_product_id', $virtuemart_product_id);
        
		$sorting = $this->getUserStateFromRequest($this->context . '.filter.sorting', 'filter_sorting', 0, 'int');
		$this->setState('filter.sorting', $sorting);
        
		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);
        
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
        
		$created_by = $this->getUserStateFromRequest($this->context . '.filter.created_by', 'filter_created_by', '');
		$this->setState('filter.created_by', $created_by);

		$created = $this->getUserStateFromRequest($this->context . '.filter.created', 'filter_created');
		$this->setState('filter.created', $created);

		# List state information.
		parent::populateState($ordering, $direction);
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
		// check in items
		$this->checkInNow();

		
        # load parent items
		$items = parent::getItems();
        
        
        
        
        
		# return items
		return $items;
	}#END FUNCTION
    

    /**
    * Метод построения запроса SQL для загрузки данных списка.
    * Method to build an SQL query to load the list data.
    *
    * @return	string	An SQL query
    * @since 3.9
    */
	protected function getListQuery()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the vm_product_comparisons_item table
		$query->from($db->quoteName('#__vm_product_comparisons_copmare', 'a'));

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published = 0 OR a.published = 1)');
		}
		// Filter by search.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search) . '%');
				$query->where('(a.sesion_id LIKE '.$search.' OR a.user_id LIKE '.$search.' OR a.virtuemart_category_id LIKE '.$search.' OR a.virtuemart_product_id LIKE '.$search.')');
			}
		}

		// Filter by Sesion_id.
		if ($sesion_id = $this->getState('filter.sesion_id'))
		{
			$query->where('a.sesion_id = ' . $db->quote($db->escape($sesion_id)));
		}
		// Filter by User_id.
		if ($user_id = $this->getState('filter.user_id'))
		{
			$query->where('a.user_id = ' . $db->quote($db->escape($user_id)));
		}
		// Filter by Virtuemart_category_id.
		if ($virtuemart_category_id = $this->getState('filter.virtuemart_category_id'))
		{
			$query->where('a.virtuemart_category_id = ' . $db->quote($db->escape($virtuemart_category_id)));
		}
		// Filter by Virtuemart_product_id.
		if ($virtuemart_product_id = $this->getState('filter.virtuemart_product_id'))
		{
			$query->where('a.virtuemart_product_id = ' . $db->quote($db->escape($virtuemart_product_id)));
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.id');
		$orderDirn = $this->state->get('list.direction', 'asc');	
		if ($orderCol != '')
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}#END FUNCTION
    

	/**
	 * Method to get list export data.
	 *
	 * @return mixed  An array of data items on success, false on failure.
	 */
	public function getExportData($pks)
	{
		// setup the query
		if (Vm_product_comparisonsHelper::checkArray($pks))
		{
			// Set a value to know this is exporting method.
			$_export = true;
			// Get the user object.
			$user = JFactory::getUser();
			// Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// Select some fields
			$query->select('a.*');

			// From the vm_product_comparisons_copmare table
			$query->from($db->quoteName('#__vm_product_comparisons_copmare', 'a'));
			$query->where('a.id IN (' . implode(',',$pks) . ')');

			// Order the results by ordering
			$query->order('a.ordering  ASC');

			// Load the items
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$items = $db->loadObjectList();

				// set values to display correctly.
				if (Vm_product_comparisonsHelper::checkArray($items))
				{
					foreach ($items as $nr => &$item)
					{
						// unset the values we don't want exported.
						unset($item->asset_id);
						unset($item->checked_out);
						unset($item->checked_out_time);
					}
				}
				// Add headers to items array.
				$headers = $this->getExImPortHeaders();
				if (Vm_product_comparisonsHelper::checkObject($headers))
				{
					array_unshift($items,$headers);
				}
				return $items;
			}
		}
		return false;
	}

	/**
	* Method to get header.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getExImPortHeaders()
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// get the columns
		$columns = $db->getTableColumns("#__vm_product_comparisons_copmare");
		if (Vm_product_comparisonsHelper::checkArray($columns))
		{
			// remove the headers you don't import/export.
			unset($columns['asset_id']);
			unset($columns['checked_out']);
			unset($columns['checked_out_time']);
			$headers = new stdClass();
			foreach ($columns as $column => $type)
			{
				$headers->{$column} = $column;
			}
			return $headers;
		}
		return false;
	}

    /**
    * Метод получения идентификатора на основе состояния конфигурации модели.
    * Method to get a store id based on model configuration state.
    *
    * @return  string  A store id.
    *
    * @since 3.9
    */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.id');
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.ordering');
		$id .= ':' . $this->getState('filter.created_by');
		$id .= ':' . $this->getState('filter.modified_by');
		$id .= ':' . $this->getState('filter.sesion_id');
		$id .= ':' . $this->getState('filter.user_id');
		$id .= ':' . $this->getState('filter.virtuemart_category_id');
		$id .= ':' . $this->getState('filter.virtuemart_product_id');

		return parent::getStoreId($id);
	}#END FUNCTION
    

	/**
	 * Создает SQL-запрос для проверки всех элементов, оставленных извлеченными, дольше установленного времени.
	 * Build an SQL query to checkin all items left checked out longer then a set time.
	 *
	 * @return  a bool
	 *
	 * @since 3.9
	 *
	 */
	protected function checkInNow()
	{
		// Get set check in time
		$time = JComponentHelper::getParams('com_vm_product_comparisons')->get('check_in');

		if ($time)
		{

			// Get a db connection.
			$db = JFactory::getDbo();
			// reset query
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__vm_product_comparisons_copmare'));
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				// Get Yesterdays date
				$date = JFactory::getDate()->modify($time)->toSql();
				// reset query
				$query = $db->getQuery(true);

				// Fields to update.
				$fields = array(
					$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',
					$db->quoteName('checked_out') . '=0'
				);

				// Conditions for which records should be updated.
				$conditions = array(
					$db->quoteName('checked_out') . '!=0', 
					$db->quoteName('checked_out_time') . '<\''.$date.'\''
				);

				// Check table
				$query->update($db->quoteName('#__vm_product_comparisons_copmare'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
