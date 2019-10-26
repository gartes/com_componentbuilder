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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Copmare_list Controller
 */
class Vm_product_comparisonsControllerCopmare_list extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_VM_PRODUCT_COMPARISONS_COPMARE_LIST';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Copmare', $prefix = 'Vm_product_comparisonsModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('copmare.export', 'com_vm_product_comparisons') && $user->authorise('core.export', 'com_vm_product_comparisons'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			JArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Copmare_list');
			// get the data to export
			$data = $model->getExportData($pks);
			if (Vm_product_comparisonsHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				Vm_product_comparisonsHelper::xls($data,'Copmare_list_'.$date->format('jS_F_Y'),'Copmare list exported ('.$date->format('jS F, Y').')','copmare list');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_VM_PRODUCT_COMPARISONS_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_vm_product_comparisons&view=copmare_list', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('copmare.import', 'com_vm_product_comparisons') && $user->authorise('core.import', 'com_vm_product_comparisons'))
		{
			// Get the import model
			$model = $this->getModel('Copmare_list');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (Vm_product_comparisonsHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('copmare_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'copmare_list');
				$session->set('dataType_VDM_IMPORTINTO', 'copmare');
				// Redirect to import view.
				$message = JText::_('COM_VM_PRODUCT_COMPARISONS_IMPORT_SELECT_FILE_FOR_COPMARE_LIST');
				$this->setRedirect(JRoute::_('index.php?option=com_vm_product_comparisons&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_VM_PRODUCT_COMPARISONS_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_vm_product_comparisons&view=copmare_list', false), $message, 'error');
		return;
	}
}
