<?php
	namespace vm_admin_tools ;
	
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');
	
	class helper {
		
		private $app ;
		
		public static $instance ;
		/**
		 * helper constructor.
		 * @since 3.9
		 */
		private function __construct ( $options =  array () )
		{
			$this->app = \JFactory::getApplication() ;
			return $this;
		}#END FN
		
		/**
		 * @param   array  $options
		 *
		 * @return helper
		 * @since 3.9
		 */
		public static function instance( $options =  array () )
		{
			if (self::$instance === null)
			{
				self::$instance = new self( $options );
			}
			return self::$instance;
		}#END FN
		
		
		public function getShortNamesCategory( $categories ){
			$db = \JFactory::getDbo();
			$query = $db->getQuery(true) ;
			
			$categoriesIdArr = [] ;
			foreach( $categories as $category )
			{
				$categoriesIdArr[] = $category->virtuemart_category_id ;
			}#END FOREACH
			
			$query->select( [ $db->quoteName('short_category_name') , $db->quoteName('virtuemart_category_id') ] )
				->from($db->quoteName('#__vm_admin_tools_category'))
				->where( $db->quoteName('virtuemart_category_id').' IN ('.implode(', ', $categoriesIdArr).')' );
			
			$db->setQuery($query);
			
			$res = $db->loadObjectList( 'virtuemart_category_id');
			
			foreach( $categories as $i => $category )
			{
				if( isset($res[$category->virtuemart_category_id]) )
				{
					$categories[$i]->short_category_name = $res[$category->virtuemart_category_id]->short_category_name ;
				}#END IF
			}#END FOREACH
			
			
			
			return $categories ;
		}#END FN
		
		/**
		 * Добавить вкладку на странице редактирования
		 * @param $view
		 * @param $load_template
		 * @since 3.9
		 */
		public function plgVmBuildTabs ( &$view , &$load_template )
		{
			$viewNameArr = ['category'];
			$viewName = $view->get('_name');
			if( !in_array($viewName , $viewNameArr ) )
			{
				return ;
			}#END IF
			 
			
			\JTable::addIncludePath(JPATH_PLUGINS . '/vmextended/vm_admin_tools/tables');
			$table = $this->getTable($type = 'categories', $prefix = 'TableVm_admin_tools', $config = array('get_short_name'=>true));
			$table->load( $view->category->virtuemart_category_id );
			$view->short_name = $table->short_category_name ;
			$view->addTemplatePath( JPATH_PLUGINS.'/vmextended/vm_admin_tools/views/'.$viewName.'/tmpl' );
			$load_template[ 'tools' ] = 'Инструменты';
			
		}#END FN
		
		
		public function getTable($type = 'categories', $prefix = 'TableVm_admin_tools', $config = array())
		{
			\JTable::addIncludePath(JPATH_PLUGINS . '/vmextended/vm_admin_tools/tables');
			// get instance of the table
			return \JTable::getInstance($type, $prefix, $config);
		}
		
		
		
	}#END CLASS