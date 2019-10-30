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
			
			//
			$app = JFactory::getApplication() ; 
			
			$body                = $app->getBody();
			
			# Найти все Style элементы в теле страницы
			$dom = new \Plg\Pro_critical\Platform\Dom();
			
			
			
			$dom->loadHTML( $body );
			$xpath       = new \DOMXPath( $dom );
			$Nodes = $xpath->query( '//link[@rel="stylesheet"]|//style');
			$link = [] ;
			foreach( $Nodes as $node )
			{
				switch ($node->tagName){
					case 'link':
						#Получить атрибуты
//						$excludeAttr=[ 'type' , 'rel'];
						$excludeAttr=['rel'];
						$attr = $dom::getAttrElement( $node , $excludeAttr ) ;
						$hrefArr = explode('?' , $attr['href'] ) ;
						$href = $hrefArr[0] ;
						$link[$href] = [] ;
						
						$link[$href]['file'] = $href ;
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
						
				}
				
//				echo'<pre>';print_r( $node );echo'</pre>'.__FILE__.' '.__LINE__;
			}#END FOREACH
			
			 
			$Css_file_list = $this->Css_file_list->getItems();
			foreach( $Css_file_list as $item )
			{
				
				echo'<pre>';print_r( $item->file );echo'</pre>'.__FILE__.' '.__LINE__;
			}#END FOREACH
			
			
			echo'<pre>';print_r( $link );echo'</pre>'.__FILE__.' '.__LINE__;
			
			
			
			
			
			
//			echo'<pre>';print_r( $Css_file_list );echo'</pre>'.__FILE__.' '.__LINE__;
//			echo'<pre>';print_r( $doc->_scripts );echo'</pre>'.__FILE__.' '.__LINE__;
//			die(__FILE__ .' Lines '. __LINE__ );
		}
		
		
		
		
	}