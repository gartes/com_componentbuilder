<?php
	if( !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
	defined ('VMPATH_ADMIN') or define ('VMPATH_ADMIN', JPATH_VM_ADMINISTRATOR);
	if(!class_exists('VmController'))
		require(VMPATH_ADMIN.DS.'helpers'.DS.'vmcontroller.php');
	
	
	class VirtueMartControllerComparisonsprod extends VmController {
		
		function __construct( ){
			parent::__construct(  );
			$this->addViewPath(JPATH_PLUGINS.DS .'vmextended'.DS.'vm_copmare'.DS.'views');
			$this->addPath('models', JPATH_PLUGINS.DS .'vmextended'.DS.'vm_copmare'.DS.'models');
		}#END FN
		
		function display( $cachable = false, $urlparams = false ){
			
			
			try
			{
				// Code that may throw an Exception or Error.
				parent::display( $cachable , $urlparams );
			}
			catch( Exception $e )
			{
				// Executed only in PHP 5, will not be reached in PHP 7
				echo 'Выброшено исключение: ' , $e->getMessage() , "\n";
				echo '<pre>'; print_r( $e ); echo '</pre>' . __FILE__ . ' ' . __LINE__;
				die( __FILE__ . ' Lines ' . __LINE__ );
			}
			catch( Throwable $e )
			{
				// Executed only in PHP 7, will not match in PHP 5
				echo 'Выброшено исключение: ' , $e->getMessage() , "\n";
				echo '<pre>'; print_r( $e ); echo '</pre>' . __FILE__ . ' ' . __LINE__;
				die( __FILE__ . ' Lines ' . __LINE__ );
			}
			
		}#END FN
		
		
	}#END CLASS
