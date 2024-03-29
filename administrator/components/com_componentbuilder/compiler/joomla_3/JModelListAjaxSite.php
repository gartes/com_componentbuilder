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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.helper');

/**
* ###Component### Ajax Model
* @since 3.9
*
*/
class ###Component###ModelAjax extends JModelList
{
	protected $app_params;
    protected $app;

    /**
    * ###Component###ModelAjax constructor.
    * @since 3.9
    */
	public function __construct()
	{
		parent::__construct();
		// get params
		$this->app_params = JComponentHelper::getParams('com_###component###');

        $this->app = \JFactory::getApplication() ;
	}#END FUNCTION

    ###AJAX_SITE_MODEL_METHODS###

}#END CLASS
