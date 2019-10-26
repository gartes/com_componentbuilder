<?php
	
	
	namespace vm_admin_tools;
	
	use VmController;
	
	
	class VirtueMartControllerCategory extends  VmController
	{
		public function __construct ( $cidName='cid', $config=array() )
		{
			parent::__construct($config);
			
		}
		public function apply($data){
			
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
			
			$this->setRedirect($redir, $msg,$type);
		}
	}