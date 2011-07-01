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
		$objeto = new $objeto();
		
		if(!$objeto::existe($id)){
			return false;
		}
		
		return $objeto -> find_first($id);
	}
	
	//Regresa un arreglo con los registros encontrados en el SQL dado.
	public static function reporte($sql){
		$objeto = get_called_class();	
		$objeto = new $objeto();
		
		if(!$objeto::existe($sql)){
			return false;
		}
		
		return $objeto -> find($sql);
	}
	
	//Regresa el total de registros para un SQL dado.
	public static function total($sql){
		$objeto = get_called_class();	
		$objeto = new $objeto();
		
		if(is_numeric($sql)){
			return $objeto -> count("id=".$sql);	
		}
		
		return $objeto -> count($sql);
	}
	
	//Regresa true, si el Id o SQL dado encuentra almenos un registro, sino false
	public static function existe($id){
		$objeto = get_called_class();	
		$objeto = new $objeto();
		
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
		$objeto = new $objeto();
		
		if(!$objeto::existe($id)){
			return false;
		}

		$objeto = $objeto::consultar($id);
				
		$objeto -> delete();
	}
	
	//Sirve para guardar en la base de datos los cambios que haya podido tener le objeto.
	public function guardar(){
		$this -> save();
	}
}