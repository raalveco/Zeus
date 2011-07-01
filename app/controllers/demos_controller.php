<?php
	class DemosController extends ApplicationController 
	{
		
		public function index(){
			
		}
		
		public function formatos(){
			$this -> render(null,null);
			
			Load::lib("formato");
			
			echo "UTF8: ".Formato::utf8("México")."<br />";
			echo "Normal: "."México"."<br />";
			echo "ISO8859-1: ".Formato::iso88591("México")."<br />";
			echo "<br />";
			echo "Numero: ".Formato::numero(738374)."<br />";
			echo "Dinero: ".Formato::dinero(738374)."<br />";
			echo "Ceros: ".Formato::ceros(73,5)."<br />";
			echo "<br />";
			echo "Numero con Letra: ".Formato::numeroLetra(738374)."<br />";
			echo "<br />";
			echo "Mayusculas: ".Formato::mayusculas("Lorem Ipsum is simply dummy text of the printing and typesetting industry")."<br />";
			echo "Minusculas: ".Formato::minusculas("Lorem Ipsum is simply dummy text of the printing and typesetting industry")."<br />";
			echo "Capital: ".Formato::capital("Lorem Ipsum is simply dummy text of the printing and typesetting industry")."<br />";
			echo "Texto: ".Formato::texto("clientes_distinguidos")."<br />";
			echo "Camello: ".Formato::camello("clientes_distinguidos")."<br />";
			echo "InversaCamello: ".Formato::inversaCamello("facturasEmitidasMes")."<br />";
			echo "<br />";
			echo "Fecha: ".Formato::fecha(date("Y-m-d"))."<br />";
			echo "Fecha DB: ".Formato::fechaDB(date("d/m/Y"))."<br />";
			echo "Hora: ".Formato::hora(452)."<br />";
			
		}
		
		public function html(){
			
		}
		
		public function formulario(){
			
		}
		
		public function envioFormulario(){
			$this -> render(null,null);
			
			echo "Hola: ".$this -> post("mensaje");
		}
		
		public function ajax(){
			
		}
		
		public function horaAjax(){
			$this -> render(null,null);
			echo date("H:i:s");
		}
		
		public function postAjax(){
			$this -> render(null,null);
			echo "El mensaje fue enviado correctamente: ".$this -> post("mensaje");
		}
		
		public function mensajeAjax($mensaje){
			if($this -> is_ajax()){
				$this -> set_response("view");
			}
			
			$this -> mensaje = "Hola Mundó";			
		}
	}
?>