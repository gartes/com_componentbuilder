<?php
	
	namespace Plg\Pro_critical;
	use JFactory;
	use JLoader;
	
	/**
	 * @since       3.9
	 * @subpackage
	 *
	 * @copyright   A copyright
	 * @license     A "Slug" license name e.g. GPL2
	 * @package     ${NAMESPACE}
	 */
	class Helper
	{
		private $app;
		private $params;
		public static $instance;
		
		/**
		 * Имя компонента для вызова модели
		 * @var string
		 * @since 3.9
		 */
		private static $component = 'pro_critical';
		private static $prefix = 'pro_critical' . 'Model';
		
		/**
		 * helper constructor.
		 * @throws \Exception
		 * @since 3.9
		 */
		private function __construct ( $options  , $params  )
		{
			
			die(__FILE__ .' '. __LINE__ );
			$this->app = JFactory::getApplication();
			$this->params = JFactory::getApplication();
			JLoader::registerNamespace('Plg\Pro_critical\HelpersCss',JPATH_PLUGINS.'/system/pro_critical/Helpers/Css_file',$reset=false,$prepend=false,$type='psr4');
			JLoader::registerNamespace('Plg\Pro_critical\Platform',JPATH_PLUGINS.'/system/pro_critical/Helpers/Platform',$reset=false,$prepend=false,$type='psr4');
			
			
			include_once JPATH_LIBRARIES . '/zaz/Core/vendor/autoload.php' ;
			
			return $this;
		}#END FN
	
		/**
		 * @param   array  $options
		 *
		 * @return helper
		 * @throws \Exception
		 * @since 3.9
		 */
		public static function instance ( $options  ,  $params )
		{
			if( self::$instance === null )
			{
				self::$instance = new self( $options , $params  );
			}
			
			return self::$instance;
		}#END FN
		
		/**
		 * Перед созданием HEAD
		 *
		 * @throws \Exception
		 * @since version
		 */
		public function BeforeCompileHead(){
			$doc = JFactory::getDocument();
			
			
			
			
		}
		
		public function AfterRender(){
			
			$HelpersCss = \Plg\Pro_critical\HelpersCss\Css_file::instance();
			$HelpersCss->getFileList();
			
			
			
		}
	}