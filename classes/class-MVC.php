<?php
class MVC{
	
	private 
		$controlador,	
		$acao,
		$parametros;	
	
	
	public function __construct(){
				
		$this->get_url_data();
				
		if (!$this->controlador){
			// Adiciona o controlador padrão
			require_once ABSPATH . '/controllers/home-controller.php';
			$this->controlador = new HomeController();
			$this->controlador->index();			
			
			return;
		}
		
		// Se o arquivo do controlador não existir, não faremos nada
		if(!file_exists(ABSPATH.'/controllers/'.$this->controlador.'.php')){
			echo "PAGINA NÃO ENCONTRADA";
			return;
		}

		// Inclui o arquivo do controlador
		require_once ABSPATH.'/controllers/'.$this->controlador.'.php';		
		$this->controlador = preg_replace('/[^a-zA-Z]/i','',$this->controlador);
		
		if(!class_exists($this->controlador)){
			echo "PAGINA/CLASSE NÃO ENCONTRADA";
			return;
		}		
				
		$this->parametros['acao'] = $this->acao;
		$this->controlador        = new $this->controlador( $this->parametros );	
		$this->acao               = preg_replace( '/[^a-zA-Z]/i', '', $this->acao );
		$this->controlador->acao  = $this->acao;		
		$this->controlador->{$this->acao}($this->parametros);	
		
		return;
	} 

	
	public function get_url_data (){			
		if( isset( $_GET['path'] ) ){			
			$path = $_GET['path'];			
			$path = rtrim($path, '/');
			$path = filter_var($path, FILTER_SANITIZE_URL);
			// Cria um array de parâmetros
			$path = explode('/', $path);			
			
			// Configura as propriedades
			$this->controlador = chk_array($path, 0);			
			$this->controlador .= '-controller';
			$this->acao        = chk_array($path, 1);
			if(!isset($this->acao) || empty($this->acao)){
				$this->acao = "index";
			}
			
			// Configura os parâmetros
			if (chk_array($path, 2)){
				unset($path[0]);
				unset($path[1]);				
				$this->parametros = array_values($path);
			}
			
			if(DEBUG){
				// DEBUG
				echo '<code style="position:absolute; right:0;">';
				echo 'HORA DO SERVIDOR '.date('d/m/Y H:m:s').'<br>';
				echo $this->controlador . '<br>';
				echo $this->acao        . '<br>';
				print_r( $this->parametros );
				echo '</code>';
			}
		}
	} 
} 