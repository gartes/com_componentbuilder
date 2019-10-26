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
 * Vm_product_comparisons View class for the Copmare_list
 */
class Vm_product_comparisonsViewCopmare_list extends JViewLegacy
{
	/**
	 * Copmare_list view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			Vm_product_comparisonsHelper::addSubmenu('copmare_list');
		}

		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->user = JFactory::getUser();
		$this->listOrder = $this->escape($this->state->get('list.ordering'));
		$this->listDirn = $this->escape($this->state->get('list.direction'));
		$this->saveOrder = $this->listOrder == 'ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) JUri::getInstance()));
		// get global action permissions
		$this->canDo = Vm_product_comparisonsHelper::getActions('copmare');
		$this->canEdit = $this->canDo->get('core.edit');
		$this->canState = $this->canDo->get('core.edit.state');
		$this->canCreate = $this->canDo->get('core.create');
		$this->canDelete = $this->canDo->get('core.delete');
		$this->canBatch = $this->canDo->get('core.batch');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			// load the batch html
			if ($this->canCreate && $this->canEdit && $this->canState)
			{
				$this->batchDisplay = JHtmlBatch_::render();
			}
		}
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_LIST'), 'joomla');
		JHtmlSidebar::setAction('index.php?option=com_vm_product_comparisons&view=copmare_list');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('copmare.add');
		}

		// Only load if there are items
		if (Vm_product_comparisonsHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('copmare.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('copmare_list.publish');
				JToolBarHelper::unpublishList('copmare_list.unpublish');
				JToolBarHelper::archiveList('copmare_list.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('copmare_list.checkin');
				}
			}

			// Add a batch button
			if ($this->canBatch && $this->canCreate && $this->canEdit && $this->canState)
			{
				// Get the toolbar object instance
				$bar = JToolBar::getInstance('toolbar');
				// set the batch button name
				$title = JText::_('JTOOLBAR_BATCH');
				// Instantiate a new JLayoutFile instance and render the batch button
				$layout = new JLayoutFile('joomla.toolbar.batch');
				// add the button to the page
				$dhtml = $layout->render(array('title' => $title));
				$bar->appendButton('Custom', $dhtml, 'batch');
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				JToolbarHelper::deleteList('', 'copmare_list.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('copmare_list.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('copmare.export'))
			{
				JToolBarHelper::custom('copmare_list.exportData', 'download', '', 'COM_VM_PRODUCT_COMPARISONS_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('copmare.import'))
		{
			JToolBarHelper::custom('copmare_list.importData', 'upload', '', 'COM_VM_PRODUCT_COMPARISONS_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = Vm_product_comparisonsHelper::getHelpUrl('copmare_list');
		if (Vm_product_comparisonsHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_VM_PRODUCT_COMPARISONS_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_vm_product_comparisons');
		}

		if ($this->canState)
		{
			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);
			// only load if batch allowed
			if ($this->canBatch)
			{
				JHtmlBatch_::addListSelection(
					JText::_('COM_VM_PRODUCT_COMPARISONS_KEEP_ORIGINAL_STATE'),
					'batch[published]',
					JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)
				);
			}
		}

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_ACCESS'),
			'filter_access',
			JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
		);

		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			JHtmlBatch_::addListSelection(
				JText::_('COM_VM_PRODUCT_COMPARISONS_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Set Sesion Id Selection
		$this->sesion_idOptions = $this->getTheSesion_idSelections();
		// We do some sanitation for Sesion Id filter
		if (Vm_product_comparisonsHelper::checkArray($this->sesion_idOptions) &&
			isset($this->sesion_idOptions[0]->value) &&
			!Vm_product_comparisonsHelper::checkString($this->sesion_idOptions[0]->value))
		{
			unset($this->sesion_idOptions[0]);
		}
		// Only load Sesion Id filter if it has values
		if (Vm_product_comparisonsHelper::checkArray($this->sesion_idOptions))
		{
			// Sesion Id Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_SESION_ID_LABEL').' -',
				'filter_sesion_id',
				JHtml::_('select.options', $this->sesion_idOptions, 'value', 'text', $this->state->get('filter.sesion_id'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Sesion Id Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_SESION_ID_LABEL').' -',
					'batch[sesion_id]',
					JHtml::_('select.options', $this->sesion_idOptions, 'value', 'text')
				);
			}
		}

		// Set User Id Selection
		$this->user_idOptions = $this->getTheUser_idSelections();
		// We do some sanitation for User Id filter
		if (Vm_product_comparisonsHelper::checkArray($this->user_idOptions) &&
			isset($this->user_idOptions[0]->value) &&
			!Vm_product_comparisonsHelper::checkString($this->user_idOptions[0]->value))
		{
			unset($this->user_idOptions[0]);
		}
		// Only load User Id filter if it has values
		if (Vm_product_comparisonsHelper::checkArray($this->user_idOptions))
		{
			// User Id Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_USER_ID_LABEL').' -',
				'filter_user_id',
				JHtml::_('select.options', $this->user_idOptions, 'value', 'text', $this->state->get('filter.user_id'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// User Id Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_USER_ID_LABEL').' -',
					'batch[user_id]',
					JHtml::_('select.options', $this->user_idOptions, 'value', 'text')
				);
			}
		}

		// Set Virtuemart Category Id Selection
		$this->virtuemart_category_idOptions = $this->getTheVirtuemart_category_idSelections();
		// We do some sanitation for Virtuemart Category Id filter
		if (Vm_product_comparisonsHelper::checkArray($this->virtuemart_category_idOptions) &&
			isset($this->virtuemart_category_idOptions[0]->value) &&
			!Vm_product_comparisonsHelper::checkString($this->virtuemart_category_idOptions[0]->value))
		{
			unset($this->virtuemart_category_idOptions[0]);
		}
		// Only load Virtuemart Category Id filter if it has values
		if (Vm_product_comparisonsHelper::checkArray($this->virtuemart_category_idOptions))
		{
			// Virtuemart Category Id Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_VIRTUEMART_CATEGORY_ID_LABEL').' -',
				'filter_virtuemart_category_id',
				JHtml::_('select.options', $this->virtuemart_category_idOptions, 'value', 'text', $this->state->get('filter.virtuemart_category_id'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Virtuemart Category Id Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_VIRTUEMART_CATEGORY_ID_LABEL').' -',
					'batch[virtuemart_category_id]',
					JHtml::_('select.options', $this->virtuemart_category_idOptions, 'value', 'text')
				);
			}
		}

		// Set Virtuemart Product Id Selection
		$this->virtuemart_product_idOptions = $this->getTheVirtuemart_product_idSelections();
		// We do some sanitation for Virtuemart Product Id filter
		if (Vm_product_comparisonsHelper::checkArray($this->virtuemart_product_idOptions) &&
			isset($this->virtuemart_product_idOptions[0]->value) &&
			!Vm_product_comparisonsHelper::checkString($this->virtuemart_product_idOptions[0]->value))
		{
			unset($this->virtuemart_product_idOptions[0]);
		}
		// Only load Virtuemart Product Id filter if it has values
		if (Vm_product_comparisonsHelper::checkArray($this->virtuemart_product_idOptions))
		{
			// Virtuemart Product Id Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_VIRTUEMART_PRODUCT_ID_LABEL').' -',
				'filter_virtuemart_product_id',
				JHtml::_('select.options', $this->virtuemart_product_idOptions, 'value', 'text', $this->state->get('filter.virtuemart_product_id'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Virtuemart Product Id Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_VIRTUEMART_PRODUCT_ID_LABEL').' -',
					'batch[virtuemart_product_id]',
					JHtml::_('select.options', $this->virtuemart_product_idOptions, 'value', 'text')
				);
			}
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_LIST'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_vm_product_comparisons/assets/css/copmare_list.css", (Vm_product_comparisonsHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		if(strlen($var) > 50)
		{
			// use the helper htmlEscape method instead and shorten the string
			return Vm_product_comparisonsHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return Vm_product_comparisonsHelper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
			'a.sorting' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'a.sesion_id' => JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_SESION_ID_LABEL'),
			'a.user_id' => JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_USER_ID_LABEL'),
			'a.virtuemart_category_id' => JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_VIRTUEMART_CATEGORY_ID_LABEL'),
			'a.virtuemart_product_id' => JText::_('COM_VM_PRODUCT_COMPARISONS_COPMARE_VIRTUEMART_PRODUCT_ID_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheSesion_idSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('sesion_id'));
		$query->from($db->quoteName('#__vm_product_comparisons_copmare'));
		$query->order($db->quoteName('sesion_id') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $sesion_id)
			{
				// Now add the sesion_id and its text to the options array
				$_filter[] = JHtml::_('select.option', $sesion_id, $sesion_id);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheUser_idSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('user_id'));
		$query->from($db->quoteName('#__vm_product_comparisons_copmare'));
		$query->order($db->quoteName('user_id') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $user_id)
			{
				// Now add the user_id and its text to the options array
				$_filter[] = JHtml::_('select.option', $user_id, JFactory::getUser($user_id)->name);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheVirtuemart_category_idSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('virtuemart_category_id'));
		$query->from($db->quoteName('#__vm_product_comparisons_copmare'));
		$query->order($db->quoteName('virtuemart_category_id') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $virtuemart_category_id)
			{
				// Now add the virtuemart_category_id and its text to the options array
				$_filter[] = JHtml::_('select.option', $virtuemart_category_id, $virtuemart_category_id);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheVirtuemart_product_idSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('virtuemart_product_id'));
		$query->from($db->quoteName('#__vm_product_comparisons_copmare'));
		$query->order($db->quoteName('virtuemart_product_id') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $virtuemart_product_id)
			{
				// Now add the virtuemart_product_id and its text to the options array
				$_filter[] = JHtml::_('select.option', $virtuemart_product_id, $virtuemart_product_id);
			}
			return $_filter;
		}
		return false;
	}
}
