<?php
/**
 * ActiveRecord
 *
 * Esta clase es la clase padre de todos los modelos
 * de la aplicacion
 *
 * @category Kumbia
 * @package Db
 * @subpackage ActiveRecord
 */
class ActiveRecord extends ActiveRecordBase {	
	//Regresa un solo registro, por medio de un ID o un SQL dado.
	public static function consultar($id){
		$objeto = get_called_class();	
		$objeto = new $objeto;
		
		if($objeto -> count($id)==0){
			return false;
		}
		
		return $objeto -> find_first($id);
	}
	
	//Regresa un arreglo con los registros encontrados en el SQL dado.
	public static function reporte($sql){
		$objeto = get_called_class();	
		$objeto = new $objeto;
		
		if($objeto -> count($id)==0){
			return false;
		}
		
		return $objeto -> find($sql);
	}
	
	//Regresa el total de registros para un SQL dado.
	public static function total($sql){
		$objeto = get_called_class();
		$objeto = new $objeto;
		
		if(is_numeric($sql)){
			return $objeto -> count("id=".$sql);	
		}
		
		return $objeto -> count($sql);
	}
	
	//Regresa true, si el Id o SQL dado encuentra almenos un registro, sino false
	public static function existe($id){
		$objeto = get_called_class();
		$objeto = new $objeto;
		
		if($objeto -> count($id)>0){
			return true;
		}
		
		return false;
	}
	
	//Elimina el registro correspondiente al objeto. No verifica las relaciones que pueda tener.
	public function eliminar(){
		if(!$this -> existe($this -> id)){
			return false;
		}
		
		$this -> delete();
	}
	
	//Elimina el registro correspondiente al objeto. No verifica las relaciones que pueda tener.
	public static function eliminarID($id){
		$objeto = get_called_class();
		$objeto = new $objeto;
		
		if($objeto -> count($id)==0){
			return false;
		}

		$objeto = $objeto -> find_first($id);
				
		$objeto -> delete();
	}
	
	//Sirve para guardar en la base de datos los cambios que haya podido tener le objeto.
	public function guardar(){
		$this -> save();
	}
}

		if(!function_exists('get_called_class')) {
	        class class_tools {
	                static $i = 0;
	                static $fl = null;
	
	                static function get_called_class() {
	                    $bt = debug_backtrace();
	
	                        if (self::$fl == $bt[2]['file'].$bt[2]['line']) {
	                            self::$i++;
	                        } else {
	                            self::$i = 0;
	                            self::$fl = $bt[2]['file'].$bt[2]['line'];
	                        }
	
	                        $lines = file($bt[2]['file']);
	
	                        preg_match_all('/([a-zA-Z0-9\_]+)::'.$bt[2]['function'].'/',
	                            $lines[$bt[2]['line']-1],
	                            $matches);
	
	                return $matches[1][self::$i];
	            }
	        }
	
	        function get_called_class() {
	            return class_tools::get_called_class();
	        }
		}