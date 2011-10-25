<?php
	
	class Pdf extends HTML2PDF{
		public function url($url){
			$contenido = file_get_contents($url);
			
			$this -> writeHTML(utf8_encode($contenido));
		}
		
		public function controlador($controlador){
			$contenido = file_get_contents(APLICACION_URL.$controlador);
			
			$this -> writeHTML(utf8_encode($contenido));
		}
		
		public function vista($vista){
			$contenido = file_get_contents(APP_PATH.$vista);
			
			$this -> writeHTML(utf8_encode($contenido));
		}
		
		public function contenido($contenido){
			$this -> writeHTML(utf8_encode($contenido));
		}
		
		public function renderizar($archivo = "archivo.pdf"){
			$this -> Output($archivo);
		}
		
		public function js($archivo){
			$this -> pdf -> IncludeJS($archivo);
		}
	}
