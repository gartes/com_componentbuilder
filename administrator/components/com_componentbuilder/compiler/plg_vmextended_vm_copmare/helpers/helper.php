<?php
	namespace vm_copmare ;
	use JLoader ;
	use JFactory ;
	use JLayoutFile ;
	use Vm_product_comparisonsModelCopmare ;
	use Vm_product_comparisonsModelCopmare_list ;
	use Exception;
	
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');
	
	class helper
	{
		public static $instance ;
		private $app ;
		private $session ;
		
		public $sessionId ;
		/**
		 * Проверка загрзка JS скрипта на странице
		 * vmextended/vm_copmare/layouts/category/script.php
		 * @var bool
		 * @since 3.9
		 */
		private $scriptLoad = false ;
		
		/**
		 * helper constructor.
		 * @since 3.9
		 */
		private function __construct ( $options =  array () )
		{
			
			$this->app = JFactory::getApplication() ;
			$this->session = JFactory::getSession();
			JLoader::register( 'Vm_product_comparisonsModelCopmare', JPATH_ADMINISTRATOR . '/components/com_vm_product_comparisons/models/copmare.php' );
			JLoader::register( 'Vm_product_comparisonsModelCopmare_list', JPATH_ADMINISTRATOR . '/components/com_vm_product_comparisons/models/copmare_list.php' );
			JLoader::register( 'Vm_product_comparisonsHelper' , JPATH_ADMINISTRATOR . '/components/com_vm_product_comparisons/helpers/vm_product_comparisons.php' );
			
			JLoader::register( 'Comparisons\helpers\dbHelper' , JPATH_PLUGINS . '/vmextended/vm_copmare/helpers/dbHelper.php' );
			
			$this->sessionId = $this->session->getId();
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
		
		/**
		 * Обработка события Login User
		 * Добавить отобрвнные товары без аккаунта в аккаунт пользователя
		 *
		 * @param $user_id
		 *
		 * @throws Exception
		 * @since 3.9
		 *
		 */
		public function ProcessUserLogin( $oldSessionId ,  $user_id ){
			
			$ModelCopmare = new Vm_product_comparisonsModelCopmare();
			
			# Получить продукты отобранные до авторизации
			$Items = $this->getAllPruductForUser( $oldSessionId );
			
			foreach( $Items as $item )
			{
				$item->user_id = $user_id ;
				$resSave = $ModelCopmare->save( (array)$item );
			}#END FOREACH
			try
			{
				// Code that may throw an Exception or Error.
				$this->deliteDublicateProductAnUser( $user_id );
			}
			catch( Exception $e )
			{
				// Executed only in PHP 5, will not be reached in PHP 7
				echo 'Выброшено исключение: ' , $e->getMessage() , "\n";
				echo '<pre>';
				print_r( $e );
				echo '</pre>' . __FILE__ . ' ' . __LINE__;
				die( __FILE__ . ' Lines ' . __LINE__ );
			}
			catch( Throwable $e )
			{
				// Executed only in PHP 7, will not match in PHP 5
				echo 'Выброшено исключение: ' , $e->getMessage() , "\n";
				echo '<pre>';
				print_r( $e );
				echo '</pre>' . __FILE__ . ' ' . __LINE__;
				die( __FILE__ . ' Lines ' . __LINE__ );
			}
			
			
			/*echo'<pre>';print_r( $userProdoct );echo'</pre>'.__FILE__.' '.__LINE__;
			
			$ModelCopmare_list = new Vm_product_comparisonsModelCopmare_list();
			
			# выбрать товары добавленные до авторизации
			$key = 'com_vm_product_comparisons.copmare_list.filter.sesion_id';
			$this->app->setUserState( $key , $oldSessionId );
			$Items = $ModelCopmare_list->getItems();
			
			echo'<pre>';print_r( $Items );echo'</pre>'.__FILE__.' '.__LINE__;
			
			# выбрать товары добавленные для вошедшего пользователя
			
			$key = 'com_vm_product_comparisons.copmare_list.filter';
			$this->app->setUserState( $key , false );
			
			$key = 'com_vm_product_comparisons.copmare_list.filter.user_id';
			$this->app->setUserState( $key , $user_id );
			$ItemsUser = $ModelCopmare_list->getItems();
			
			echo'<pre>';print_r( $ItemsUser );echo'</pre>'.__FILE__.' '.__LINE__;
			
			$registry = $this->session->get('registry');
			
			
			echo'<pre>';print_r( $registry );echo'</pre>'.__FILE__.' '.__LINE__;
			die(__FILE__ .' Lines '. __LINE__ );
			
			*/
			
			return ;
		}#END FN
		
		/**
		 * Удалить дубликаты товаров
		 * @param $user_id
		 *
		 * @return bool
		 * @since 3.9
		 */
		private function deliteDublicateProductAnUser($user_id)
		{
			$group = [ 'user_id' , 'virtuemart_category_id' , 'virtuemart_product_id' ];
			$where = [ 'published = 1' ];
			
			$dbHelper = \Comparisons\helpers\dbHelper::instance();
			$dublicateFieldsArr = $dbHelper->dublicateRemove( '#__vm_product_comparisons_copmare' , $group , 'id' , $where );
			
			return true;
			
		}#END FN
		
		private function getAllPruductForUser( $oldSessionId ){
			
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.*');
			$query->from($db->quoteName('#__vm_product_comparisons_copmare' , 'a'));
			$query->where( $db->quoteName('a.published') . '= 1 ');
			// $query->where( $db->quoteName('a.user_id') . ' = ' . $db->quote($userId));
			$query->where( $db->quoteName('a.sesion_id') . ' = ' . $db->quote($oldSessionId));
			
			$db->setQuery( $query ) ;
			$res = $db->loadObjectList();
			
			
			return $res ;
		}#END FN
		
		/**
		 * Получить кнопки для сравнения
		 * @param $product - obj - Объект продукта
		 *
		 * @return string|null - html - разметка кнопок из файла vmextended/vm_copmare/layouts/category/btn_tmpl.php
		 * @since 3.9
		 */
		public function get_comparisons_Btn(   $product ){
			
			$html = null ;
			if( !$this->scriptLoad )
			{
				$this->scriptLoad = true ;
				$html .= $this->addScriptLoaderCompareBtn( $product->virtuemart_category_id );
			}#END IF
			
			$layout = new JLayoutFile( 'category.btn_tmpl' , JPATH_PLUGINS.DS.'vmextended/vm_copmare/layouts' );
			$html .= $layout->render(['product' => $product , 'sessionId' => $this->sessionId ]);
			
			return $html ;
		}#END FN
		
		/**
		 * Добавить JS - Загрузщик скрипта для кнопок
		 * @param $virtuemart_category_id
		 *
		 * @return string|null
		 * @since 3.9
		 */
		private function addScriptLoaderCompareBtn( $virtuemart_category_id ){
			$html = null ;
			$layout = new JLayoutFile( 'category.script' , JPATH_PLUGINS.DS.'vmextended/vm_copmare/layouts' );
			$html .= $layout->render(['virtuemart_category_id' => $virtuemart_category_id ]);
			
			return $html ;
		}#END FN
		
		public static function AddStyle(){
			$doc = JFactory::getDocument();
			$doc->addStyleDeclaration('
			
.comparison-2-goods .comparison-t,.comparison-2-goods .comparison-t-head {
    width: 100%
}

@media screen and (max-width: 1614px) {
    .comparison-2-goods .comparison-t-container {
        width:100%
    }
}

@media screen and (min-width: 1615px) {
    .comparison-2-goods .comparison-t-container {
        width:1520px
    }
}

@media screen and (max-width: 1090px) {
    .comparison-2-goods .comparison-t-cell,.comparison-2-goods .comparison-t-head-cell {
        width:50%
    }
}

@media screen and (min-width: 1091px) {
    .comparison-2-goods .comparison-t-cell,.comparison-2-goods .comparison-t-head-cell {
        width:382px
    }
}

@media not all and (min-resolution: 0.001dpcm) {
    .comparison-2-goods .comparison-t-cell,.comparison-2-goods .comparison-t-head-cell {
        width:382px
    }
}

.comparison-3-goods .comparison-t,.comparison-3-goods .comparison-t-head {
    /* width: 100% */
}

@media screen and (max-width: 1614px) {
    .comparison-3-goods .comparison-t-container {
        width:100%
    }
}

@media screen and (min-width: 1615px) {
    .comparison-3-goods .comparison-t-container {
        width:1520px
    }
}

@media screen and (max-width: 1535px) {
    .comparison-3-goods .comparison-t-cell,.comparison-3-goods .comparison-t-head-cell {
        width:33%
    }
}

@media screen and (min-width: 1536px) {
    .comparison-3-goods .comparison-t-cell,.comparison-3-goods .comparison-t-head-cell {
        width:382px
    }
}

@media not all and (min-resolution: 0.001dpcm) {
    .comparison-3-goods .comparison-t-cell,.comparison-3-goods .comparison-t-head-cell {
        width:382px
    }
}

@media screen and (max-width: 1614px) {
    .comparison-4-goods .comparison-t-container {
        width:100%
    }
}

@media screen and (min-width: 1615px) {
    .comparison-4-goods .comparison-t-container {
        width:1520px
    }
}

@media screen and (min-width: 1165px) {
    .comparison-4-goods .comparison-t,.comparison-4-goods .comparison-t-head {
        width:100%
    }

    .comparison-4-goods .comparison-t-cell,.comparison-4-goods .comparison-t-head-cell {
        width: -webkit-calc((100% - 295px)/ 4);
        width: -moz-calc((100% - 295px)/ 4);
        width: -o-calc((100% - 295px)/ 4);
        width: calc((100% - 295px)/ 4)
    }

    .comparison-4-goods .comparison-t-cell,.comparison-4-goods .comparison-t-head-cell,.comparison-4-goods _::-webkit-:not(:root:root) {
        width: 209px
    }
}

@media not all and (min-resolution: 0.001dpcm) {
    .comparison-4-goods .comparison-t-cell,.comparison-4-goods .comparison-t-head-cell {
        width:209px
    }
}

@media screen and (min-width: 1436px) and (max-width:1920px) {
    .comparison-5-goods .comparison-t-container {
        width:100%
    }
}

@media screen and (min-width: 1921px) {
    .comparison-5-goods .comparison-t-container {
        width:1825px
    }
}

@media screen and (min-width: 1436px) {
    .comparison-5-goods .comparison-t,.comparison-5-goods .comparison-t-head {
        width:100%
    }

    .comparison-5-goods .comparison-t-cell,.comparison-5-goods .comparison-t-head-cell {
        width: -webkit-calc((100% - 295px)/ 5);
        width: -moz-calc((100% - 295px)/ 5);
        width: -o-calc((100% - 295px)/ 5);
        width: calc((100% - 295px)/ 5)
    }

    .comparison-5-goods .comparison-t-cell,.comparison-5-goods .comparison-t-head-cell,.comparison-5-goods _::-webkit-:not(:root:root) {
        width: 209px
    }
}

@media not all and (min-resolution: 0.001dpcm) {
    .comparison-5-goods .comparison-t-cell,.comparison-5-goods .comparison-t-head-cell {
        width:209px
    }
}

@media screen and (min-width: 1645px) and (max-width:1920px) {
    .comparison-6-goods .comparison-t-container {
        width:100%
    }
}

@media screen and (min-width: 1921px) {
    .comparison-6-goods .comparison-t-container {
        width:1825px
    }
}

@media screen and (min-width: 1645px) {
    .comparison-6-goods .comparison-t,.comparison-6-goods .comparison-t-head {
        width:100%
    }

    .comparison-6-goods .comparison-t-cell,.comparison-6-goods .comparison-t-head-cell {
        width: -webkit-calc((100% - 295px)/ 6);
        width: -moz-calc((100% - 295px)/ 6);
        width: -o-calc((100% - 295px)/ 6);
        width: calc((100% - 295px)/ 6)
    }

    .comparison-6-goods .comparison-t-cell,.comparison-6-goods .comparison-t-head-cell,.comparison-6-goods _::-webkit-:not(:root:root) {
        width: 209px
    }
}

@media not all and (min-resolution: 0.001dpcm) {
    .comparison-6-goods .comparison-t-cell,.comparison-6-goods .comparison-t-head-cell {
        width:209px
    }
}

@media screen and (min-width: 1854px) and (max-width:1920px) {
    .comparison-7-goods .comparison-t-container {
        width:100%
    }
}

@media screen and (min-width: 1921px) {
    .comparison-7-goods .comparison-t-container {
        width:1825px
    }
}

@media screen and (min-width: 1854px) {
    .comparison-7-goods .comparison-t,.comparison-7-goods .comparison-t-head {
        width:100%
    }

    .comparison-7-goods .comparison-t-cell,.comparison-7-goods .comparison-t-head-cell {
        width: -webkit-calc((100% - 295px)/ 7);
        width: -moz-calc((100% - 295px)/ 7);
        width: -o-calc((100% - 295px)/ 7);
        width: calc((100% - 295px)/ 7)
    }

    .comparison-7-goods .comparison-t-cell,.comparison-7-goods .comparison-t-head-cell,.comparison-7-goods _::-webkit-:not(:root:root) {
        width: 209px
    }
}

@media not all and (min-resolution: 0.001dpcm) {
    .comparison-7-goods .comparison-t-cell,.comparison-7-goods .comparison-t-head-cell {
        width:209px
    }
}
			
			');
		}#END FN
		
		/**
		 * Получить список отобранных товаров для сравнения по ID - категории
		 *
		 * @param $virtuemart_category_id
		 *
		 * @return array
		 * @since 3.9
		 */
		public function getItemCopmare_listInCategory( $virtuemart_category_id = 0  ){
			
			$user = JFactory::getUser();
			
			$key = 'com_vm_product_comparisons.copmare_list.filter';
			$this->app->setUserState( $key , [] );
			
			if( !$user->id )
			{
				$key = 'com_vm_product_comparisons.copmare_list.filter.sesion_id';
				$this->app->setUserState( $key , $this->sessionId );
			}
			else
			{
				$key = 'com_vm_product_comparisons.copmare_list.filter.user_id';
				$this->app->setUserState( $key , $user->id );
			}#END IF
			
			if( $virtuemart_category_id )
			{
				$key = 'com_vm_product_comparisons.copmare_list.filter.virtuemart_category_id';
				$this->app->setUserState( $key , $virtuemart_category_id );
			}#END IF
			
			
			
			$ModelCopmare_list = new Vm_product_comparisonsModelCopmare_list();
			$Items = $ModelCopmare_list->getItems();
			
		 
			
			$productInCetegoryArr = [];
			foreach( $Items as $i => $item )
			{
				$productInCetegoryArr[$item->virtuemart_category_id ][$item->id] = $item->virtuemart_product_id ;
			}#END FOREACH
			
			return $productInCetegoryArr ;
			
		}#END FN
		
		/**
		 * Получить формы для списка товаров
		 * @since 3.9
		 */
		public function get_comparisons_form()
		{
			# Макет кнопок
			$layout = new JLayoutFile( 'btn' , JPATH_PLUGINS . DS . 'vmextended/vm_copmare/layouts' );
			
			# Категория товаров открытая у клиента
			$virtuemart_category_id = $this->app->input->get( 'category_id' , null , 'INT' );
			# Товары На странице
			$Prod                   = $this->app->input->get( 'Prod' , [] , 'ARRAY' );
			
			# Получить список отобранных товаров для сравнения по ID - категории
			$productInCetegoryArr = $this->getItemCopmare_listInCategory( $virtuemart_category_id );
			
			
			foreach( $Prod as $Prod_item )
			{
				$check = false;
				if( isset( $productInCetegoryArr[ $virtuemart_category_id ] ) && in_array( $Prod_item , $productInCetegoryArr[ $virtuemart_category_id ] ) )
				{
					$check = true;
				}#END IF
				
				$html[ $Prod_item ] = $layout->render( [ 'prod' => $Prod_item , 'check' => $check , 'virtuemart_category_id' => $virtuemart_category_id ] );
			}#END FOREACH
			
			echo new \JResponseJson( $html );
			
			$this->app->close();
		
		}#END FN
		
		/**
		 * Удаление категории из сравненния
		 * @since 3.9
		 */
		public function del_cat_comparisons(){
			
			
			$ModelCopmare = new Vm_product_comparisonsModelCopmare();
			$table = $ModelCopmare->getTable();
			$virtuemart_category_id = $this->app->input->get('virtuemart_category_id' , null , 'INT' ) ;
			# Получить список отобранных товаров для сравнения по ID - категории
			$productInCetegoryArr = $this->getItemCopmare_listInCategory( $virtuemart_category_id );
			
			foreach( $productInCetegoryArr[$virtuemart_category_id] as $key => $item )
			{
				$table->delete($key) ;
			}#END FOREACH
			
			
			$session                = JFactory::getSession();
			$dataSession            = $session->get( 'mobileHistory' , [] , 'com_vm_product_comparisons' );
			if( isset( $dataSession[ $virtuemart_category_id ] ) ){
				unset( $dataSession[ $virtuemart_category_id ] ) ;
			}
			$session->set( 'mobileHistory' , $dataSession , 'com_vm_product_comparisons' );
			
			$this->app->enqueueMessage( 'Категория удалена.');
			
			return ;
		}#END FN
	
		/**
		 * Удалить отобраный товар из сравнения
		 *
		 * @since 3.9
		 */
		public function del_comparisons(){
			
			$productModel = \VmModel::getModel ('product');
			
			
			/*$ModelCopmare = new Vm_product_comparisonsModelCopmare();
			$table = $ModelCopmare->getTable();
			$virtuemart_category_id = $this->app->input->get('virtuemart_category_id' , null , 'INT' ) ;
			# Получить список отобранных товаров для сравнения по ID - категории
			$productInCetegoryArr = $this->getItemCopmare_listInCategory( $virtuemart_category_id );
			
			echo'<pre>';print_r( $productInCetegoryArr );echo'</pre>'.__FILE__.' '.__LINE__;
			die(__FILE__ .' Lines '. __LINE__ );*/
			
			
			$ModelCopmare = new Vm_product_comparisonsModelCopmare();
			$table = $ModelCopmare->getTable();
			
			
			$virtuemart_product_id = $this->app->input->get('virtuemart_product_id' , null , 'INT' ) ;
			$virtuemart_category_id = $this->app->input->get('virtuemart_category_id' , null , 'INT' ) ;
			
			# Получить список отобранных товаров для сравнения по ID - категории
			$productInCetegoryArr = $this->getItemCopmare_listInCategory( $virtuemart_category_id );
			
			
			
			$key = array_search($virtuemart_product_id, $productInCetegoryArr[$virtuemart_category_id] );
			
			
			
			$dataSession            = $this->session->get( 'mobileHistory' , [] , 'com_vm_product_comparisons' );
			if( isset( $dataSession[$virtuemart_category_id][$virtuemart_product_id] ) )
			{
				unset( $dataSession[$virtuemart_category_id][$virtuemart_product_id] ) ;
			}#END IF
			$this->session->set( 'mobileHistory' , $dataSession , 'com_vm_product_comparisons' );
			
			
			
			if( !$table->delete($key) )
			{
				echo'<pre>';print_r( $table->getError() );echo'</pre>'.__FILE__.' '.__LINE__;
				die(__FILE__ .' Lines '. __LINE__ );
			}#END IF
			
			
			
			
			$product = $productModel->getProduct ( $virtuemart_product_id );
			$this->app->enqueueMessage($product->product_name . ' - Удален из списка сравнения.');
			return ;
			
		}#END FN
		
		/**
		 * Добавить в стравнение товар
		 * @since 3.9
		 * @throws Exception
		 */
		public function add_comparisons()
		{
			
			$user = JFactory::getUser();
			
			$productModel = \VmModel::getModel( 'product' );
			
			$ModelCopmare = new Vm_product_comparisonsModelCopmare();
			
			$virtuemart_category_id = $this->app->input->get( 'virtuemart_category_id' , null , 'INT' );
			$virtuemart_product_id  = $this->app->input->get( 'virtuemart_product_id' , null , 'INT' );
			
			# Получить объект продукта по ID
			$product = $productModel->getProduct( $virtuemart_product_id );
			
			# Получить список отобранных товаров для сравнения по ID - категории
			$productInCetegoryArr = $this->getItemCopmare_listInCategory( $virtuemart_category_id );
			
			# Если товар есть в отобранных
			if( in_array( $virtuemart_product_id , $productInCetegoryArr[ $product->virtuemart_category_id ] ) )
			{
				$this->app->close();
			}#END IF
			
			$data    = [
				'sesion_id' => $this->sessionId,
				'user_id' => $user->id ,
				'virtuemart_category_id' => $virtuemart_category_id ,
				'virtuemart_product_id' => $virtuemart_product_id ,
			];
			
			$resSave = $ModelCopmare->save( $data );
			
			
			$this->app->enqueueMessage( $product->product_name . ' - Дбавлен для сравнения.' );
			echo new \JResponseJson( true );
			$this->app->close();
			
			return true;
		}#END FN
		
		
		
		
		
		
		public function get_js_layot(){
			
			$layout    = new JLayoutFile( 'menu.comparison.comparison_html' , JPATH_PLUGINS.DS.'vmextended/vm_copmare/layouts' );
			$result = [
				'html' => $layout->render()
			];
			
			echo new \JResponseJson($result);
			$this->app->close();
			
		}#END FN
		public function get_js_layot_mobile(){
			
			$layout    = new JLayoutFile( 'menu.comparison_mobile.comparison_html' , JPATH_PLUGINS.DS.'vmextended/vm_copmare/layouts' );
			$result = [
				'html' => $layout->render()
			];
			
			echo new \JResponseJson($result);
			$this->app->close();
			
		}#END FN
		
		
	}#END CLASS
 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	