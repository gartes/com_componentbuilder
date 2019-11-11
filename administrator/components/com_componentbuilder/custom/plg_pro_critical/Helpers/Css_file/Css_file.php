<?php
	/**
	 * @package     Css_file
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 */
	
	namespace Plg\Pro_critical\HelpersCss;
	
	
	use JFactory;
	use JLoader;
	use JModelLegacy;
	use Exception;
	use JDate;
	
	class Css_file
	{
		private $app;
		public static $instance;
		/**
		 * Имя компонента для вызова модели
		 * @var string
		 * @since 3.9
		 */
		private static $component = 'pro_critical';
		private static $prefix = 'pro_critical' . 'Model';
		
		private $Css_file_list ;
		
		/**
		 * helper constructor.
		 * @throws Exception
		 * @since 3.9
		 */
		private function __construct ( $options = [] )
		{
			$this->app = JFactory::getApplication();
			JLoader::register( 'Pro_criticalHelper', JPATH_ADMINISTRATOR . '/components/com_pro_critical/helpers/pro_critical.php' );
			JModelLegacy::addIncludePath( JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_' . self::$component . DS . 'models', self::$prefix );
			$this->Css_file_list = JModelLegacy::getInstance( 'Css_file_list' , self::$prefix );
			
			return $this;
		}#END FN
		
		/**
		 * @param   array  $options
		 *
		 * @return Css_file
		 * @throws Exception
		 * @since 3.9
		 */
		public static function instance ( $options = [] )
		{
			if( self::$instance === null )
			{
				self::$instance = new self( $options );
			}
			
			return self::$instance;
		}#END FN
		
		
		public function getFileList(){
			
			
			$app = JFactory::getApplication() ; 
			
			$body                = $app->getBody();
			
			# Найти все Style элементы в теле страницы
			$dom = new \GNZ11\Document\Dom();
			$dom->loadHTML( $body );
			$xpath       = new \DOMXPath( $dom );
			$Nodes = $xpath->query( '//link[@rel="stylesheet"]|//style');
			$link = [] ;
			foreach( $Nodes as $node )
			{
				switch ($node->tagName){
					case 'link':
						$attr = $dom::getAttrElement( $node , ['rel'] ) ;
						$hrefArr = explode('?' , $attr['href'] ) ;
						unset($attr['href']) ;
						
						$href = $hrefArr[0] ;
						$link[$href] = [] ;
						$link[$href]['file'] = $href ;
						$link[$href] = array_merge($link[$href] , $attr ) ;
						
						
						
						if( isset($hrefArr[1]) )
						{
							$paramHrefArr = explode('&' , $hrefArr[1]) ;
							$i = 0 ;
							foreach( $paramHrefArr as $item )
							{
								$paramArr = explode('=',$item) ;
								$nam = $paramArr[0];
								$val = $paramArr[1];
								$link[$href]['params_query']['params_query'.$i]['name'] = $nam ;
								$link[$href]['params_query']['params_query'.$i]['value'] = $val ;
								$i++;
							}#END FOREACH
							$link[$href]['params_query'] = json_encode($link[$href]['params_query']) ;
						}#END IF
						
						
						
						break ;
					case 'style' :
						break ;
				}
			}#END FOREACH
			
			
			
			
			$app->input->set('limit' , 0 );
			$Css_file_list = $this->Css_file_list->getItems();
			
			
			$UbdateCssFile = [] ;
			$copyLink = [] ;
			foreach( $Css_file_list as $item )
			{
				if( isset( $link[$item->file] ) ) {
					unset( $link[$item->file] ) ;
				}else{
					
				}#END IF
			}#END FOREACH
			
			$this->addNewLink($link);
			
			
			
//			 die(__FILE__ .' '. __LINE__ );
			
			
			
			
			
//			echo'<pre>';print_r( $Css_file_list );echo'</pre>'.__FILE__.' '.__LINE__;
//			echo'<pre>';print_r( $doc->_scripts );echo'</pre>'.__FILE__.' '.__LINE__;
//			die(__FILE__ .' Lines '. __LINE__ );
		}
		
		private function addNewLink($link){
			if( !count($link) )
			{
				return true ;
			}#END IF
			$db = JFactory::getDbo();
			
			$query = $db->getQuery(true) ;
			$columns = [ 'load' , 'file' , 'params_query' , 'type' , 'media' ];
			$jdata  = new JDate();
			$now   = $jdata->toSql();
			$userId = JFactory::getUser()->id;
			
			
			$columns[] = 'created_by';
			$columns[] = 'created';
			
			
			
			foreach ( $link as $item )
			{
				$values =
					$db->quote( 1 ) . ","
					. $db->quote( $item[ 'file' ] ) . ","
					. $db->quote( $item[ 'params_query' ] ) . ","
					. $db->quote( 'text/css' ) . ","
					. $db->quote( (isset($item[ 'media' ])?$item[ 'media' ]:'') ) . ","
					
					. $db->quote( $userId ) . ","
					. $db->quote( $now );
				
				$query->values( $values );
			}//foreach
			
			$query->insert( $db->quoteName( '#__pro_critical_css_file' ) )->columns( $db->quoteName( $columns ) );
			$db->setQuery( $query );
//			echo $query->dump();
//			die(__FILE__ .' '. __LINE__ );
					try
							{
								// Code that may throw an Exception or Error.
								$db->execute();
							}
							catch (Exception $e)
							{
							   // Executed only in PHP 5, will not be reached in PHP 7
							   echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
							}
							catch (Throwable $e)
							{
								// Executed only in PHP 7, will not match in PHP 5
								echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
								echo'<pre>';print_r( $e );echo'</pre>'.__FILE__.' '.__LINE__;
								die(__FILE__ .' '. __LINE__ );
							}
			
			return true ;
		}
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	