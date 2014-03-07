<?php
namespace samson\i18n;

use samson\core\CompressableExternalModule;

/** Стандартный путь к папке со словарями */
if(!defined('__SAMSON_I18N_PATH'))  define('__SAMSON_I18N_PATH', __SAMSON_APP_PATH.'/i18n' );

/** Стандартный путь главному словарю сайта */
if(!defined('__SAMSON_I18N_DICT'))  define('__SAMSON_I18N_DICT', __SAMSON_I18N_PATH.'/dictionary.php' );

/**
 * Интернализация / Локализация
 *
 * @author Vitaly Iegorov <vitalyiegorov@gmail.com>
 * @version 1.0
 */
class i18n extends CompressableExternalModule
{	
	/** Идентификатор модуля */
	public $id = 'i18n';
	
	/** Автор модуля */
	public $author = 'Vitaly Iegorov';	
	
	/** Текущая локаль */
	public $locale = 'en';
	
	/** Путь к файлу словаря */
	public $path;
	
	/** Коллекция данных для перевода */
	public $dictionary = array( 'ru' => array() );
	
	/** @see \samson\core\ModuleConnector::prepare() */
	/*public function prepare()
	{
		
	}*/
	
	/** Конструктор */
	//public function __construct()
	//{		
		// Если существует главный словарь 
		//if( file_exists( __SAMSON_I18N_DICT ) ) 
		//{			
			// Загрузим его содержимое
			//$data = include(__SAMSON_I18N_DICT);	
			//echo '!!!!!!!!!!!!!!!!! - __construct - !!!!!!!!!!!!!!';
			//include(__SAMSON_I18N_DICT);
			/*$data = \dictionary ();
			// Пробежимся по локалям в словаре
			foreach ( $data as $locale => $dict )
			{			
				// Создадим словарь для локали
				$this->data[ $locale ] = array();
				
				// Преобразуем ключи 
				foreach ( $dict as $k => $v ) $this->data[ $locale ][ (trim($k)) ] = $v;
			}	*/	 
		//}
	//}
	
	public function init( array $params = array() )
	{
		parent::init();
		$this->create();
	}
	
	public function create()
	{
		if( file_exists( __SAMSON_I18N_DICT ) )
		{
			include(__SAMSON_I18N_DICT);
		}
		
		if( function_exists('\dictionary') )
		{
			$data = \dictionary ();
			
			// Пробежимся по локалям в словаре
			foreach ( $data as $locale => $dict )
			{
				// Создадим словарь для локали
				$this->data[ $locale ] = array();
			
				// Преобразуем ключи
				foreach ( $dict as $k => $v ) $this->data[ $locale ][ (trim($k)) ] = $v;
			}
		}
	}
	
	/**
	 * Translate(Перевести) фразу
	 *
	 * @param string $key 		Ключ для поиска перевода фразы
	 * @param string $locale 	Локаль в которую необходимо перевести
	 * @return string Переведенная строка или просто значение ключа
	 */
	function translate( $key, $locale = NULL )
	{
		// Если требуемая локаль не передана - получим текущую локаль
		if( !isset( $locale ) ) $locale = locale();
		
		// Получим словарь для нужной локали
		$dict = & $this->data[ $locale ];
		
		// Получим хеш строки
		$md5_key = (trim( $key ));
		
		// Попытаемся найти запись в словаре
		if( isset( $dict[ $md5_key ] ) ) return $dict[ $md5_key ];
		// Просто вернем ключ		
		else return $key;
	}
}