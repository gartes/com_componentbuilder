<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

# No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * ###Views### Model
 * @since 3.9
 * @author Gartes
 */
class ###Component###Model###Views### extends JModelList
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
				###FILTER_FIELDS###
			);
		}

		parent::__construct($config);
	}#END FUNCTION
    ###ADMIN_CUSTOM_BUTTONS_METHOD_LIST###

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
		###POPULATESTATE###
        
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
	{###LICENSE_LOCKED_CHECK######CHECKINCALL###
		
        # load parent items
		$items = parent::getItems();
        
        ###GET_ITEMS_METHOD_STRING_FIX###
        ###SELECTIONTRANSLATIONFIX###
        ###GET_ITEMS_METHOD_AFTER_ALL###
        
		# return items
		return $items;
	}#END FUNCTION
    ###SELECTIONTRANSLATIONFIXFUNC###

    /**
    * Метод построения запроса SQL для загрузки данных списка.
    * Method to build an SQL query to load the list data.
    *
    * @return	string	An SQL query
    * @since 3.9
    */
	protected function getListQuery()
	{###LICENSE_LOCKED_CHECK###
		###LISTQUERY###
	}#END FUNCTION
    ###MODELEXPORTMETHOD######LICENSE_LOCKED_SET_BOOL###

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
		###STOREDID###

		return parent::getStoreId($id);
	}#END FUNCTION
    ###AUTOCHECKIN###
}
