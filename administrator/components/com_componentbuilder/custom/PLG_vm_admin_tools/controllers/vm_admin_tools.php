<?php
	
	if( !class_exists('VirtuemartControllerCategory') )
	{
		require(JPATH_ROOT .'/administrator/components/com_virtuemart/controllers/category.php');
	}#END IF
	
	
	
	class VirtueMartControllerVm_admin_tools extends  VmController
	{
		
		public $redirectPath ;
		public $mainLangKey ;
		private $helper ;
		
		
		public function __construct ( $cidName='cid', $config=array() )
		{
			
			$this->helper = vm_admin_tools\helper::instance();
			
			
			$data = vRequest::getRequest();
			
			$this->_cname = $data['controller'] ;
			$this->_cidName = 'cid' ;
			$this->redirectPath = 'index.php?option=com_virtuemart&view=' . $this->_cname  ;
			$this->mainLangKey= \vmText::_('COM_VIRTUEMART_'.strtoupper($this->_cname));
			
			$redir = $this->redirectPath;
			
			$model = $this->getModel('category');
			$id = $model->store( $data );
			
			
			if( $data['task']  == 'apply'){
				$redir .= '&task=edit&'.$this->_cidName.'='.$id;
			}
			
			$msg = 'failed';
			
			if(!empty($id)) {
				$msg = \vmText::sprintf('COM_VIRTUEMART_STRING_SAVED',$this->mainLangKey);
				$type = 'message';
			}
			else $type = 'error';
			
			echo'<pre>';print_r( $data['virtuemart_category_id'] );echo'</pre>'.__FILE__.' '.__LINE__;
//			die(__FILE__ .' Lines '. __LINE__ );
//			virtuemart_category_id
			
			\JTable::addIncludePath(JPATH_PLUGINS . '/vmextended/vm_admin_tools/tables');
			$table = $this->helper->getTable();
			
			$table->bind( $data );
			$table->storeMy();
			
			
			
			
			
			
		 
			
			
			
			$this->setRedirect($redir, $msg,$type);
			
			
			
			
		}
		/*
		public function getTable($type = 'Categories', $prefix = 'TableVm_admin_tools', $config = array())
		{
			// get instance of the table
			return JTable::getInstance($type, $prefix, $config);
		}*/
		
		
		
	}