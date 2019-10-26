<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	
	if( !class_exists( 'VmView' ) )
	{
		require( VMPATH_SITE . DS . 'helpers' . DS . 'vmview.php' );
	}
	
	
	class VirtuemartViewComparisons extends VmView
	{
		
		private $app ;
		
		/**
		 * VirtuemartViewComparisons constructor.
		 * @since 3.9
		 */
		public function __construct ()
		{
			$this->app = JFactory::getApplication();
			$penthouse = $this->app->input->get('penthouse' , false );
			
			if( $penthouse )
			{
				JLoader::register( 'vm_copmare\helper', JPATH_PLUGINS.'/vmextended/vm_copmare/helper.php' );
				\vm_copmare\helper::AddPenthouse();
			}#END IF
			
		}
		
		function display ( $tpl = null )
		{
			
			$doc = JFactory::getDocument();
			$doc->addScript('/plugins/vmextended/vm_copmare/assets/js/product_cart.js');
			$doc->addScript('/plugins/vmextended/vm_copmare/assets/js/product_comparisons_btn.js');
			$doc->addStyleSheet('/plugins/vmextended/vm_copmare/assets/css/product_cart.css');
			
			
			JLoader::register('VirtueMartModelComparisons', JPATH_PLUGINS.DS.'vmextended/vm_copmare/models/comparisons.php');
			
			$this->_addPath(
				'template' ,
				JPATH_PLUGINS.DS.'vmextended'.DS .'vm_copmare'.DS.'views'.DS.$this->getName().DS.'tmpl' );
			
			 
			
			$Model = new VirtueMartModelComparisons();
			$this->products = $Model->getProductList();
			
			echo'<pre>';print_r( $this->products );echo'</pre>'.__FILE__.' '.__LINE__;
			
			$this->currency = CurrencyDisplay::getInstance( );
			
			
			
			parent::display( $tpl );
		}#END FN
		
		
	}#END CLASS