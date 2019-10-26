<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	
	if( !class_exists( 'VmView' ) )
	{
		require( VMPATH_SITE . DS . 'helpers' . DS . 'vmview.php' );
	}
	
	
	class VirtuemartViewComparisons extends VmView
	{
		
		function display ( $tpl = null )
		{
			$app = JFactory::getApplication();
			// Code that may throw an Exception or Error.
			JLoader::register( 'vm_copmare\helper' , JPATH_PLUGINS.'/vmextended/vm_copmare/helpers/helper.php' );
			$helper = vm_copmare\helper::instance() ;
			
			
			$task = $app->input->get('task') ;
			
			$helper->{$task}();
			$result = [1,2,3] ;
			echo new JResponseJson($result);
			$app->close();
		}#END FN

	}#END CLASS