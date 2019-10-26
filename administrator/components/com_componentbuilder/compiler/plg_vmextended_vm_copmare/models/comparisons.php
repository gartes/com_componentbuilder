<?php
	
	
	defined('_JEXEC') or die('Restricted access');
	if(!class_exists('VmModel'))require(VMPATH_ADMIN.DS.'helpers'.DS.'vmmodel.php');
	
	
	
	class VirtueMartModelComparisons extends VmModel
	{
		
		public $allProductCount = 0 ;
		
		protected $app;
		protected $session;
		
		
		/**
		 * VirtueMartModelZifimport constructor.
		 * @throws Exception
		 * @since 3.9
		 */
		public function __construct()
		{
			parent::__construct();
			$this->app = \JFactory::getApplication();
			$this->session = \JFactory::getSession();
		}#END FN
		
		public function getProductList(){
			
			JLoader::register( 'vm_copmare\helper' , JPATH_PLUGINS.'/vmextended/vm_copmare/helpers/helper.php' );
			$helper = vm_copmare\helper::instance() ;
			$product_session = $helper->getItemCopmare_listInCategory();
			
			
			
			
			
			
			
			
			
		
			/*
			if( !count($product_session) )
			{
				$cid = $this->app->input->get('cid' , null , 'INT') ;
//				$this->setRedirect(JRoute::_('index.php', false));
				
				$link = JRoute::_(
					'index.php?'
					.'&option=com_virtuemart&view=category'
					.'&virtuemart_category_id=' . $cid
				);
				
				$this->app->redirect($link);
				
			}#END IF*/
			
			$productModel = \VmModel::getModel ('product');
			
			$product = null ;
			foreach( $product_session as $catId => $item )
			{
				$this->allProductCount += count($item ) ;
				
				$prod = $productModel->getProducts ( $item );
				$productModel->addImages( $prod , 1 );
				$product[$catId] = $prod ;
				
			}
			
			return $product ;
		}#END FN
		
	}#END CLASS





































