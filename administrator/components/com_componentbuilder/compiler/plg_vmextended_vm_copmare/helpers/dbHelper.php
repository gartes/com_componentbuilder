<?php
	
	
	namespace Comparisons\helpers;
	use JFactory;
	
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');
	
	class dbHelper
	{
		public static $instance;
		private $db;
		
		/**
		 * dbHelper constructor.
		 * @since 3.9
		 */
		public function __construct ( $options )
		{
			$this->db = JFactory::getDbo();
		}#END FN
		
		
		/**
		 * @param   array  $options
		 *
		 * @return dbHelper
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
		
		/**
		 * Удаление дубликатов в твблицах Копонента - vm_product_comparisons
		 *
		 * @param   string  $table  - Имя таблицы
		 *                          Ex : '#__vm_product_comparisons_copmare'
		 * @param   array   $group  - Массив уникальных столбцов
		 *                          Ex : ['user_id','virtuemart_category_id','virtuemart_product_id']
		 * @param   string  $key    - Ключ поле - id
		 * @param   array   $where  - Условие отбора записей
		 *
		 * @return mixed
		 * @since   3.9
		 * @author  Gartes
		 * @example :
		 *          JLoader::register( 'Comparisons\helpers\dbHelper' , JPATH_PLUGINS . '/vmextended/vm_copmare/helpers/dbHelper.php' );
		 *          $dbHelper = \Comparisons\helpers\dbHelper::instance();
		 *          $dublicateFieldsArr = $dbHelper->dublicateRemove('#__vm_product_comparisons_copmare' , $group , 'id' , $where );
		 *
		 */
		public function dublicateRemove ( $table , $group , $key = 'id' , $where = [ 'published = 1' ] )
		{
			$sub_query = $this->db->getQuery( true );
			$sub_query->select( 'MAX( ' . $key . ' )' );
			$sub_query->from( $this->db->quoteName( $table ) );
			$sub_query->where( $where );
			$sub_query->group( $group );
			$sub_query->having( 'COUNT(*) > 1' );
			$this->db->setQuery( $sub_query );
			$dublicateFieldsArr = $this->db->loadColumn();
			
			# Если дубилкаты не найдены
			if( !count( $dublicateFieldsArr ) )
			{
				return true ;
			}#END IF
			
			$query = $this->db->getQuery( true );
			$query->delete( $this->db->quoteName( $table ) );
			$query->where( $this->db->quoteName( $key ) . 'IN (' . implode( ',' , $dublicateFieldsArr ) . ')' );
			$this->db->setQuery( $query )->execute();
			
			return $dublicateFieldsArr;
			
		}#END FN
	}#END CLASS
























