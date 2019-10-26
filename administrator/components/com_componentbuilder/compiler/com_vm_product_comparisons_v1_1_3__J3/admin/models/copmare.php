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

use Joomla\Registry\Registry;

/**
* ###Component### ###View### Model
* @since 3.9
*/
class ###Component###Model###View### extends JModelAdmin
{
    /**
    * Массив полей макета вкладки.
    * The tab layout fields array.
    *
    * @var      array
    * @since 3.9
    */
	protected $tabLayoutFields = ###TABLAYOUTFIELDSARRAY###;

    /**
    * Префикс для использования с сообщениями контроллера.
    * The prefix to use with controller messages.
    * @var        string
    * @since   1.6
    */
	protected $text_prefix = 'COM_###COMPONENT###';

    /**
    * Псевдоним типа для этого типа контента.
    * The type alias for this content type.
    * @var      string
    * @since    3.2
    */
	public $typeAlias = 'com_###component###.###view###';

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
	public function getTable($type = '###view###', $prefix = '###Component###Table', $config = array())
	{
		// add table path for when model gets used from other component
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_###component###/tables');
		// get instance of the table
		return JTable::getInstance($type, $prefix, $config);
	}#END FUNCTION
    ###ADMIN_CUSTOM_BUTTONS_METHOD###

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
	{###LICENSE_LOCKED_CHECK###
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
			}###METHOD_GET_ITEM###
			
			if (!empty($item->id))
			{
				$item->tags = new JHelperTags;
				$item->tags->getTagIds($item->id, 'com_###component###.###view###');
			}
		}###LINKEDVIEWGLOBAL###

		return $item;
	}#END FUNCTION

    ###LINKEDVIEWMETHODS######LICENSE_LOCKED_SET_BOOL###

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
		$options['load_data'] = $loadData;###JMODELADMIN_GETFORM###
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
		return 'administrator/components/com_###component###/models/forms/###view###.js';
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
	{###JMODELADMIN_CANDELETE###
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
	{###JMODELADMIN_CANEDITSTATE###
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
	{###JMODELADMIN_ALLOWEDIT###
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
	{###LICENSE_TABLE_LOCKED_CHECK###
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
					->from($db->quoteName('#__###component###_###view###'));
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
		$data = JFactory::getApplication()->getUserState('com_###component###.edit.###view###.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
			// run the perprocess of the data
			$this->preprocessData('com_###component###.###view###', $data);
		}

		return $data;
	}#END FUNCTION
    ###VALIDATIONFIX######UNIQUEFIELDS###
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
	{###JMODELADMIN_BEFORE_DELETE###
		if (!parent::delete($pks))
		{
			return false;
		}###JMODELADMIN_AFTER_DELETE###
		
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
	{###JMODELADMIN_BEFORE_PUBLISH###
		if (!parent::publish($pks, $value))
		{
			return false;
		}###JMODELADMIN_AFTER_PUBLISH###
		
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
		$this->canDo			= ###Component###Helper::getActions('###view###');
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
    ###MODEL_BATCH_COPY######MODEL_BATCH_MOVE###

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
		}###CHECKBOX_SAVE######METHOD_ITEM_SAVE###
        
		// Set the Params Items to data
		if (isset($data['params']) && is_array($data['params']))
		{
			$params = new JRegistry;
			$params->loadArray($data['params']);
			$data['params'] = (string) $params;
		}###TITLEALIASFIX###
		
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
    ###GENERATENEWTITLE###
}
