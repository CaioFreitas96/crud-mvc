<?php

class MainController{	
		public 
			$title,
			$error,
			$acao,
			$parametros = array(),			
			$modelo,
			$data_atual;		
		
		protected 
			$nivel_acesso,		
			$nome_view, 
			$nome_modulo,
			$config_model,
			$app_nologin,
			$config_list;
				
		public function __construct ( $parametros = array(), $nome_modulo = null){					
			$this->parametros      = $parametros;	
			$this->data_atual = getDataAtual();		
			$this->load_model();			
		} 				
		
		function setModulo($modulo){
			$this->nome_modulo = $modulo;
		}

		function getModulo(){
			return $this->nome_modulo;
		}

		function setView($view){
			$this->nome_view = $view;
		}

		function viewPage($view){
			require_once ABSPATH . "/views/$this->nome_view/$view ";
		}
		 
		public function load_model($model_name = false, $return = false){			
			if($model_name){
				$model_name = $model_name.'-model';
			}else{
				if(isset($this->nome_modulo)){
					$model_name = $this->nome_modulo.'/'.$this->nome_modulo.'-model';
				}
			}
			
			if (!$model_name) return;
			
			$model_name =  strtolower( $model_name );	
			$model_path = ABSPATH . '/models/'.$model_name.'.php';					
			if(file_exists( $model_path )){				
				// Inclui o arquivo
				require_once $model_path;
				
				$model_name = explode('/', $model_name);				
				$model_name = end( $model_name );				
				$model_name = preg_replace( '/[^a-zA-Z0-9]/is', '', $model_name );
				// Verifica se a classe existe				
				if ( class_exists( $model_name ) ){				
					if($return){						
						return new $model_name($this);
					}else{						
						$this->modelo =  new $model_name($this);
					}
				}				
				return;
			} 
		} 		
	} 