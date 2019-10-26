<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	
	if( !class_exists( 'VmView' ) )
	{
		require( VMPATH_SITE . DS . 'helpers' . DS . 'vmview.php' );
	}
	
	
	class VirtuemartViewComparisonsprod extends VmView
	{
		private $app ;
		public $products ;
		public $category ;
		public $currency ;
		public $result ;
		public $result_name ;
		public $cid ;
		
		/**
		 * VirtuemartViewComparisonsprod constructor.
		 * @throws Exception
		 * @since 3.9
		 */
		public function __construct ()
		{
			$this->app = JFactory::getApplication();
			$penthouse = $this->app->input->get('penthouse' , false );
			JLoader::register( 'vm_copmare\helper', JPATH_PLUGINS.'/vmextended/vm_copmare/helper.php' );
			
			if( $penthouse )
			{
				\vm_copmare\helper::AddPenthouse();
			}#END IF
		}
		
		
		function display ( $tpl = null )
		{
			
			JLoader::register('VirtueMartModelComparisons', JPATH_PLUGINS.DS.'vmextended/vm_copmare/models/comparisons.php');
			
			
			$app = JFactory::getApplication();
			$session = \JFactory::getSession();
			$Model = new VirtueMartModelComparisons();
			$categoryModel = VmModel::getModel('category');
			
			$doc = JFactory::getDocument();
//
			$doc->addStyleSheet('/plugins/vmextended/vm_copmare/assets/css/comparisonsprod.css');
			$doc->addScript('/plugins/vmextended/vm_copmare/assets/js/comparisonsprod.js');
			 
			
			
			$this->_addPath(
				'template' ,
				JPATH_PLUGINS.DS.'vmextended'.DS .'vm_copmare'.DS.'views'.DS.$this->getName().DS.'tmpl' );
			
			$cid = $app->input->get('cid' , null , 'INT') ;
			
			
			$products = $Model->getProductList();
			$this->products = $products[$cid];
			
			$this->currency = CurrencyDisplay::getInstance( );
			$this->cid = $cid ;
			$this->category = $categoryModel->getCategory( $cid );
			
			
			/*echo'<pre>';print_r( $this->category->category_name );echo'</pre>'.__FILE__.' '.__LINE__;
			die(__FILE__ .' Lines '. __LINE__ );*/
			
			
			JLoader::register( 'ZiffilterModelFvmcategoryfieldscode', JPATH_SITE . '/components/com_ziffilter/models/fvmcategoryfieldscode.php' );
			JLoader::register( 'ZiffilterHelper' , JPATH_BASE . '/components/com_ziffilter/helpers/ziffilter.php' );
			
			
			$product_session = $session->get('products' , [] , 'comparisons' );
			
			
			
			VirtueMartModelProduct::$_alreadyLoadedIds = $product_session[$cid] ;
			$ZiffilterModel   = new ZiffilterModelFvmcategoryfieldscode();
			$ZiffilterProduct = $ZiffilterModel->getItems();
			
			$this->result = [] ;
			$this->result_name = [] ;
			foreach( $ZiffilterProduct as   $item )
			{
				if( $item->field_add )
				{
					$this->result[$item->name_field_list][$item->virtuemartproduct_id] = $item->value_fild_value ;
					$this->result_name[$item->name_field_list] =  $item->field_name ;
					
					
				}#END IF
				
				
				
			}#END FOREACH
			
			
			\vm_copmare\helper::AddStyle();
			parent::display( $tpl );
		} // end function
		
		
	}// end class