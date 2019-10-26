<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Gstes Co. 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			23rd октября, 2019
	@created		23rd сентября, 2019
	@package		vm_product_comparisons
	@subpackage		copmare.php
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

use Joomla\Registry\Registry;

/**
* Vm_product_comparisons Copmare Model
* @since 3.9
*/
class Vm_product_comparisonsModelCopmare extends JModelAdmin
{
    /**
    * Массив полей макета вкладки.
    * The tab layout fields array.
    *
    * @var      array
    * @since 3.9
    */
	protected $tabLayoutFields = array(
		'product' => array(
			'left' => array(
				'sesion_id',
				'user_id',
				'virtuemart_category_id',
				'virtuemart_product_id'
			)
		)
	);

    /**
    * Префикс для использования с сообщениями контроллера.
    * The prefix to use with controller messages.
    * @var        string
    * @since   1.6
    */
	protected $text_prefix = 'COM_VM_PRODUCT_COMPARISONS';

    /**
    * Псевдоним типа для этого типа контента.
    * The type alias for this content type.
    * @var      string
    * @since    3.2
    */
	public $typeAlias = 'com_vm_product_comparisons.copmare';

    /**
    * Возвращает объект таблицы, всегда создавая его
    * Returns a Table object, always creating it
    *
    * @param   string  $type    Тип таблицы для создания экземпляра.
    *                           The table type to instantiate
    *
    * @param   string  $prefix  Префикс для имени класса таблицы. Опционально.
    *                           A prefix for the table class name. Optional.
    *
    * @param   array   $config  Конфигурационный массив для модели. Опционально.
    *                           Configuration array for model. Optional.
    *
    * @return  JTable  Объект базы данных
    *                  A database object
    *
    * @since    1.6
    * @author   Gartes
    */
	public function getTable($type = 'copmare', $prefix = 'Vm_product_comparisonsTable', $config = array())
	{
		// add table path for when model gets used from other component
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_vm_product_comparisons/tables');
		// get instance of the table
		return JTable::getInstance($type, $prefix, $config);
	}#END FUNCTION
    

    /**
    * Способ получить одну запись
    * Method to get a single record.
    *
    * @param   integer  $pk  Идентификатор первичного ключа.
    *                        The id of the primary key.
    *
    * @return  mixed  Объект при успехе, ложь при неудаче.
    *                 Object on success, false on failure.
    *
    * @since    1.6
    * @author   Gartes
    */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			if (!empty($item->params) && !is_array($item->params))
			{
				// Convert the params field to an array.
				$registry = new Registry;
				$registry->loadString($item->params);
				$item->params = $registry->toArray();
			}

			if (!empty($item->metadata))
			{
				// Convert the metadata field to an array.
				$registry = new Registry;
				$registry->loadString($item->metadata);
				$item->metadata = $registry->toArray();
			}
			
			if (!empty($item->id))
			{
				$item->tags = new JHelperTags;
				$item->tags->getTagIds($item->id, 'com_vm_product_comparisons.copmare');
			}
		}

		return $item;
	}#END FUNCTION

    

    /**
    * Метод получения формы записи
    * Method to get the record form.
    *
    * @param   array    $data      Данные для формы.
    *                              Data for the form.
    *
    * @param   boolean  $loadData  True, если форма загружает свои данные (регистр по умолчанию), и false, если нет.
    *                              True if the form is to load its own data (default case), false if not.
    *
    * @param   array  $options     Необязательный массив параметров для создания формы.
    *                              Optional array of options for the form creation.
    *
    * @return  mixed  Объект JForm в случае успеха, false при ошибке
    *                 A JForm object on success, false on failure
    *
    * @throws Exception
    * @since    1.6
    * @author   Gartes
    */
	public function getForm($data = array(), $loadData = true, $options = array('control' => 'jform'))
	{
		// set load data option
		$options['load_data'] = $loadData;
		// Get the form.
		$form = $this->loadForm('com_vm_product_comparisons.copmare', 'copmare', $options);

		if (empty($form))
		{
			return false;
		}

		$jinput = JFactory::getApplication()->input;

		// The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.
		if ($jinput->get('a_id'))
		{
			$id = $jinput->get('a_id', 0, 'INT');
		}
		// The back end uses id so we use that the rest of the time and set it to 0 by default.
		else
		{
			$id = $jinput->get('id', 0, 'INT');
		}

		$user = JFactory::getUser();

		// Check for existing item.
		// Modify the form based on Edit State access controls.
		if ($id != 0 && (!$user->authorise('core.edit.state', 'com_vm_product_comparisons.copmare.' . (int) $id))
			|| ($id == 0 && !$user->authorise('core.edit.state', 'com_vm_product_comparisons')))
		{
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('published', 'disabled', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('published', 'filter', 'unset');
		}
		// If this is a new item insure the greated by is set.
		if (0 == $id)
		{
			// Set the created_by to this user
			$form->setValue('created_by', null, $user->id);
		}
		// Modify the form based on Edit Creaded By access controls.
		if (!$user->authorise('core.edit.created_by', 'com_vm_product_comparisons'))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'disabled', 'true');
			// Disable fields for display.
			$form->setFieldAttribute('created_by', 'readonly', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created_by', 'filter', 'unset');
		}
		// Modify the form based on Edit Creaded Date access controls.
		if (!$user->authorise('core.edit.created', 'com_vm_product_comparisons'))
		{
			// Disable fields for display.
			$form->setFieldAttribute('created', 'disabled', 'true');
			// Disable fields while saving.
			$form->setFieldAttribute('created', 'filter', 'unset');
		}
		// Only load these values if no id is found
		if (0 == $id)
		{
			// Set redirected view name
			$redirectedView = $jinput->get('ref', null, 'STRING');
			// Set field name (or fall back to view name)
			$redirectedField = $jinput->get('field', $redirectedView, 'STRING');
			// Set redirected view id
			$redirectedId = $jinput->get('refid', 0, 'INT');
			// Set field id (or fall back to redirected view id)
			$redirectedValue = $jinput->get('field_id', $redirectedId, 'INT');
			if (0 != $redirectedValue && $redirectedField)
			{
				// Now set the local-redirected field default value
				$form->setValue($redirectedField, null, $redirectedValue);
			}
		}
		return $form;
	}#END FUNCTION

    /**
    * Метод, чтобы получить скрипт, который должен быть включен в форму
    * Method to get the script that have to be included on the form
    *
    * @return string	script files
    * @since    3.9
    * @author   Gartes
    */
	public function getScript()
	{
		return 'administrator/components/com_vm_product_comparisons/models/forms/copmare.js';
	}#END FUNCTION

    /**
    * Метод проверки возможности удаления записи.
    * Method to test whether a record can be deleted.
    *
    * @param   object  $record  Объект записи.
    *                           A record object.
    *
    * @return  boolean  Истинно, если разрешено удалить запись. По умолчанию используется разрешение, установленное в компоненте.
    *                   True if allowed to delete the record. Defaults to the permission set in the component.
    *
    * @since    1.6
    * @author   Gartes
    */
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->published != -2)
			{
				return;
			}

			$user = JFactory::getUser();
			// The record has been set. Check the record permissions.
			return $user->authorise('core.delete', 'com_vm_product_comparisons.copmare.' . (int) $record->id);
		}
		return false;
	}#END FUNCTION

    /**
    * Метод проверки возможности редактирования состояния записи.
    * Method to test whether a record can have its state edited.
    *
    * @param   object  $record  Объект записи.
    *                           A record object.
    *
    * @return  boolean  Истинно, если разрешено изменять состояние записи. По умолчанию используется разрешение, установленное в компоненте.
    *                   True if allowed to change the state of the record. Defaults to the permission set in the component.
    *
    * @since    1.6
    * @author   Gartes
    */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();
		$recordId = (!empty($record->id)) ? $record->id : 0;

		if ($recordId)
		{
			// The record has been set. Check the record permissions.
			$permission = $user->authorise('core.edit.state', 'com_vm_product_comparisons.copmare.' . (int) $recordId);
			if (!$permission && !is_null($permission))
			{
				return false;
			}
		}
		// In the absense of better information, revert to the component permissions.
		return parent::canEditState($record);
	}#END FUNCTION

    /**
    * Переопределение метода, чтобы проверить, можете ли вы редактировать существующую запись.
    * Method override to check if you can edit an existing record.
    *
    * @param   array  $data  Массив входных данных.
    *                        An array of input data.
    * @param   string  $key  Имя ключа для первичного ключа.
    *                        The name of the key for the primary key.
    *
    * @return	boolean
    * @since    2.5
    * @author   Gartes
    */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.

		return JFactory::getUser()->authorise('core.edit', 'com_vm_product_comparisons.copmare.'. ((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}#END FUNCTION

    /**
    * Подготовьте и очистите данные таблицы перед сохранением.
    * Prepare and sanitise the table data prior to saving.
    *
    * @param   JTable  $table  Объект JTable.
    *                          A JTable object.
    *
    * @return  void
    *
    * @since   1.6
    * @author   Gartes
    */
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();
		
		if (isset($table->name))
		{
			$table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);
		}
		
		if (isset($table->alias) && empty($table->alias))
		{
			$table->generateAlias();
		}
		
		if (empty($table->id))
		{
			$table->created = $date->toSql();
			
            # установить пользователя
            # set the user
			if ($table->created_by == 0 || empty($table->created_by))
			{
				$table->created_by = $user->id;
			}

			# Установить порядок для последнего элемента, если не установлен
			# Set ordering to the last item if not set
			if (empty($table->ordering))
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery(true)
					->select('MAX(ordering)')
					->from($db->quoteName('#__vm_product_comparisons_copmare'));
				$db->setQuery($query);
				$max = $db->loadResult();

				$table->ordering = $max + 1;
			}
		}
		else
		{
			$table->modified = $date->toSql();
			$table->modified_by = $user->id;
		}
        
		if (!empty($table->id))
		{
			# Увеличить номер версии товара.
			# Increment the items version number.
			$table->version++;
		}
	}#END FUNCTION

    /**
    * Метод для получения данных, которые должны быть введены в форму.
    * Method to get the data that should be injected in the form.
    *
    * @return  mixed  Данные для формы.
    *                 The data for the form.
    *
    * @throws Exception
    * @since   1.6
    * @author  Gartes
    */
	protected function loadFormData() 
	{
		# Проверьте сеанс для ранее введенных данных формы.
		# Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_vm_product_comparisons.edit.copmare.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
			// run the perprocess of the data
			$this->preprocessData('com_vm_product_comparisons.copmare', $data);
		}

		return $data;
	}#END FUNCTION
    

	/**
	 * Method to get the unique fields of this table.
	 *
	 * @return  mixed  An array of field names, boolean false if none is set.
	 *
	 * @since   3.0
	 */
	protected function getUniqeFields()
	{
		return false;
	}
    /**
    * Метод удалить одну или несколько записей.
    * Method to delete one or more records.
    *
    * @param   array  &$pks  Массив записей первичных ключей.
    *                        An array of record primary keys.
    *
    * @return  boolean  True в случае успеха, false в случае ошибки.
    *                   True if successful, false if an error occurs.
    *
    * @since   12.2
    * @author  Gartes
    */
	public function delete(&$pks)
	{
		if (!parent::delete($pks))
		{
			return false;
		}
		
		return true;
	}#END FUNCTION

    /**
    * Метод изменить опубликованное состояние одной или нескольких записей.
    * Method to change the published state of one or more records.
    *
    * @param   array    &$pks    Список первичных ключей для изменения.
    *                            A list of the primary keys to change.
    *
    * @param   integer   $value  Значение опубликованного состояния.
    *                            The value of the published state.
    *
    * @return  boolean  True в случае успеха
    *                   True on success.
    *
    * @since   12.2
    * @author  Gartes
    */
	public function publish(&$pks, $value = 1)
	{
		if (!parent::publish($pks, $value))
		{
			return false;
		}
		
		return true;
    }#END FUNCTION

    /**
    * Метод выполнения пакетных операций над элементом или набором элементов.
    * Method to perform batch operations on an item or a set of items.
    *
    * @param   array  $commands  Массив команд для выполнения.
    *                            An array of commands to perform.
    *
    * @param   array  $pks       Массив идентификаторов значений.
    *                            An array of item ids.
    *
    * @param   array  $contexts  Массив контекстов значений.
    *                            An array of item contexts.
    *
    * @return  boolean  Возвращает true в случае успеха, false в случае неудачи.
    *                   Returns true on success, false on failure.
    *
    * @since   12.2
    * @author  Gartes
    */
	public function batch($commands, $pks, $contexts)
	{
		# Очистить идентификаторы.
		# Sanitize ids.
		$pks = array_unique($pks);
		JArrayHelper::toInteger($pks);

		# Удалите все значения нуля.
		# Remove any values of zero.
		if (array_search(0, $pks, true))
		{
			unset($pks[array_search(0, $pks, true)]);
		}

		if (empty($pks))
		{
			$this->setError(JText::_('JGLOBAL_NO_ITEM_SELECTED'));
			return false;
		}

		$done = false;
        
        # Установить необходимые переменные.
		# Set some needed variables.
		$this->user			= JFactory::getUser();
		$this->table			= $this->getTable();
		$this->tableClassName		= get_class($this->table);
		$this->contentType		= new JUcmType;
		$this->type			= $this->contentType->getTypeByTable($this->tableClassName);
		$this->canDo			= Vm_product_comparisonsHelper::getActions('copmare');
		$this->batchSet			= true;

		if (!$this->canDo->get('core.batch'))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));
			return false;
		}
        
		if ($this->type == false)
		{
			$type = new JUcmType;
			$this->type = $type->getTypeByAlias($this->typeAlias);
		}

		$this->tagsObserver = $this->table->getObserverOfClass('JTableObserverTags');

		if (!empty($commands['move_copy']))
		{
			$cmd = JArrayHelper::getValue($commands, 'move_copy', 'c');

			if ($cmd == 'c')
			{
				$result = $this->batchCopy($commands, $pks, $contexts);

				if (is_array($result))
				{
					foreach ($result as $old => $new)
					{
						$contexts[$new] = $contexts[$old];
					}
					$pks = array_values($result);
				}
				else
				{
					return false;
				}
			}
			elseif ($cmd == 'm' && !$this->batchMove($commands, $pks, $contexts))
			{
				return false;
			}

			$done = true;
		}

		if (!$done)
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));

			return false;
		}

		// Clear the cache
		$this->cleanCache();

		return true;
	}#END FUNCTION
    

	/**
	 * Batch copy items to a new category or current.
	 *
	 * @param   integer  $values    The new values.
	 * @param   array    $pks       An array of row IDs.
	 * @param   array    $contexts  An array of item contexts.
	 *
	 * @return  mixed  An array of new IDs on success, boolean false on failure.
	 *
	 * @since 12.2
	 */
	protected function batchCopy($values, $pks, $contexts)
	{
		if (empty($this->batchSet))
		{
			// Set some needed variables.
			$this->user 		= JFactory::getUser();
			$this->table 		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->canDo		= Vm_product_comparisonsHelper::getActions('copmare');
		}

		if (!$this->canDo->get('core.create') || !$this->canDo->get('core.batch'))
		{
			return false;
		}

		// get list of uniqe fields
		$uniqeFields = $this->getUniqeFields();
		// remove move_copy from array
		unset($values['move_copy']);

		// make sure published is set
		if (!isset($values['published']))
		{
			$values['published'] = 0;
		}
		elseif (isset($values['published']) && !$this->canDo->get('core.edit.state'))
		{
				$values['published'] = 0;
		}

		$newIds = array();
		// Parent exists so let's proceed
		while (!empty($pks))
		{
			// Pop the first ID off the stack
			$pk = array_shift($pks);

			$this->table->reset();

			// only allow copy if user may edit this item.
			if (!$this->user->authorise('core.edit', $contexts[$pk]))
			{
				// Not fatal error
				$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
				continue;
			}

			// Check that the row actually exists
			if (!$this->table->load($pk))
			{
				if ($error = $this->table->getError())
				{
					// Fatal error
					$this->setError($error);
					return false;
				}
				else
				{
					// Not fatal error
					$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
					continue;
				}
			}

			// insert all set values
			if (Vm_product_comparisonsHelper::checkArray($values))
			{
				foreach ($values as $key => $value)
				{
					if (strlen($value) > 0 && isset($this->table->$key))
					{
						$this->table->$key = $value;
					}
				}
			}

			// update all uniqe fields
			if (Vm_product_comparisonsHelper::checkArray($uniqeFields))
			{
				foreach ($uniqeFields as $uniqeField)
				{
					$this->table->$uniqeField = $this->generateUniqe($uniqeField,$this->table->$uniqeField);
				}
			}

			// Reset the ID because we are making a copy
			$this->table->id = 0;

			// TODO: Deal with ordering?
			// $this->table->ordering = 1;

			// Check the row.
			if (!$this->table->check())
			{
				$this->setError($this->table->getError());

				return false;
			}

			if (!empty($this->type))
			{
				$this->createTagsHelper($this->tagsObserver, $this->type, $pk, $this->typeAlias, $this->table);
			}

			// Store the row.
			if (!$this->table->store())
			{
				$this->setError($this->table->getError());

				return false;
			}

			// Get the new item ID
			$newId = $this->table->get('id');

			// Add the new ID to the array
			$newIds[$pk] = $newId;
		}

		// Clean the cache
		$this->cleanCache();

		return $newIds;
	}

	/**
	 * Batch move items to a new category
	 *
	 * @param   integer  $value     The new category ID.
	 * @param   array    $pks       An array of row IDs.
	 * @param   array    $contexts  An array of item contexts.
	 *
	 * @return  boolean  True if successful, false otherwise and internal error is set.
	 *
	 * @since 12.2
	 */
	protected function batchMove($values, $pks, $contexts)
	{
		if (empty($this->batchSet))
		{
			// Set some needed variables.
			$this->user		= JFactory::getUser();
			$this->table		= $this->getTable();
			$this->tableClassName	= get_class($this->table);
			$this->canDo		= Vm_product_comparisonsHelper::getActions('copmare');
		}

		if (!$this->canDo->get('core.edit') && !$this->canDo->get('core.batch'))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
			return false;
		}

		// make sure published only updates if user has the permission.
		if (isset($values['published']) && !$this->canDo->get('core.edit.state'))
		{
			unset($values['published']);
		}
		// remove move_copy from array
		unset($values['move_copy']);

		// Parent exists so we proceed
		foreach ($pks as $pk)
		{
			if (!$this->user->authorise('core.edit', $contexts[$pk]))
			{
				$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));
				return false;
			}

			// Check that the row actually exists
			if (!$this->table->load($pk))
			{
				if ($error = $this->table->getError())
				{
					// Fatal error
					$this->setError($error);
					return false;
				}
				else
				{
					// Not fatal error
					$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk));
					continue;
				}
			}

			// insert all set values.
			if (Vm_product_comparisonsHelper::checkArray($values))
			{
				foreach ($values as $key => $value)
				{
					// Do special action for access.
					if ('access' === $key && strlen($value) > 0)
					{
						$this->table->$key = $value;
					}
					elseif (strlen($value) > 0 && isset($this->table->$key))
					{
						$this->table->$key = $value;
					}
				}
			}


			// Check the row.
			if (!$this->table->check())
			{
				$this->setError($this->table->getError());

				return false;
			}

			if (!empty($this->type))
			{
				$this->createTagsHelper($this->tagsObserver, $this->type, $pk, $this->typeAlias, $this->table);
			}

			// Store the row.
			if (!$this->table->store())
			{
				$this->setError($this->table->getError());

				return false;
			}
		}

		// Clean the cache
		$this->cleanCache();

		return true;
	}

    /**
    * Метод сохранения данных формы.
    * Method to save the form data.
    *
    * @param   array  $data  Данные формы.
    *                        The form data.
    *
    * @return  boolean  Возвращает true в случае успеха.
    * @throws Exception
    * @since   1.6
    * @author  Gartes
    */
	public function save($data)
	{
		$input	= JFactory::getApplication()->input;
		$filter	= JFilterInput::getInstance();
        
		// set the metadata to the Item Data
		if (isset($data['metadata']) && isset($data['metadata']['author']))
		{
			$data['metadata']['author'] = $filter->clean($data['metadata']['author'], 'TRIM');
            
			$metadata = new JRegistry;
			$metadata->loadArray($data['metadata']);
			$data['metadata'] = (string) $metadata;
		}
        
		// Set the Params Items to data
		if (isset($data['params']) && is_array($data['params']))
		{
			$params = new JRegistry;
			$params->loadArray($data['params']);
			$data['params'] = (string) $params;
		}

		// Alter the uniqe field for save as copy
		if ($input->get('task') === 'save2copy')
		{
			// Automatic handling of other uniqe fields
			$uniqeFields = $this->getUniqeFields();
			if (Vm_product_comparisonsHelper::checkArray($uniqeFields))
			{
				foreach ($uniqeFields as $uniqeField)
				{
					$data[$uniqeField] = $this->generateUniqe($uniqeField,$data[$uniqeField]);
				}
			}
		}
		
		if (parent::save($data))
		{
			return true;
		}
		return false;
	}#END FUNCTION

    /**
    * Метод генерации уникального значения.
    * Method to generate a uniqe value.
    *
    * @param   string  $field name.
    * @param   string  $value data.
    *
    * @return  string  New value.
    *
    * @since   3.0
    * @author  Gartes
    */
	protected function generateUniqe($field,$value)
	{

		// set field value uniqe 
		$table = $this->getTable();

		while ($table->load(array($field => $value)))
		{
			$value = JString::increment($value);
		}

		return $value;
	}#END FUNCTION
    
}
