<?php

class HomeController extends MainController{
	function __construct($parametros = null){
		$this->setModulo('home');
		$this->setView('home');
		parent::__construct($parametros);
	}

	function index(){	
		$tarefas = json_decode($this->modelo->getTarefas());		
		require_once ABSPATH . '/views/'.$this->nome_view.'/index.php';		
	}

	function create(){		
		try{
			if(!isset($_POST['tarefa']) || empty($_POST['tarefa'])){				
				$retorno['codigo'] = 1;
				$retorno['input']  = $_POST;
				$retorno['output'] = null;
				$retorno['mensagem'] = "Informe uma tarefa";
				throw new Exception (json_encode($retorno), 1);
			}else{
				$insert['tarefa'] = $_POST['tarefa'];
			}		
			
			$save = $this->modelo->save($insert);
			if(isset($save) && is_numeric($save)){
				$retorno['codigo'] = 0;
				$retorno['input']  = $insert;
				$retorno['output'] = $save;
				$retorno['mensagem'] = "Sucesso";
				throw new Exception (json_encode($retorno), 1);
			}else{
				$retorno['codigo'] = 1;
				$retorno['input']  = $_POST;
				$retorno['output'] = $this->modelo->info;
				$retorno['mensagem'] = "Erro em salvar no banco";
				throw new Exception (json_encode($retorno), 1);
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	function delete(){
		try{		
			if(!isset($this->parametros[0]) || empty($this->parametros[0])){				
				$retorno['codigo'] = 1;
				$retorno['input']  = $_POST;
				$retorno['output'] = null;
				$retorno['mensagem'] = "Erro paramêtros id";
				throw new Exception (json_encode($retorno), 1);
			}else{
				$id = $this->parametros[0];
				$insert['deleted'] = 1;
			}		
			
			$save = $this->modelo->save($insert,$id);
			if(isset($save) && is_numeric($save)){
				$retorno['codigo'] = 0;
				$retorno['input']  = $insert;
				$retorno['output'] = $save;
				$retorno['mensagem'] = "Sucesso";
				throw new Exception (json_encode($retorno), 1);
			}else{
				$retorno['codigo'] = 1;
				$retorno['input']  = $_POST;
				$retorno['output'] = $this->modelo->info;
				$retorno['mensagem'] = "Erro em salvar no banco";
				throw new Exception (json_encode($retorno), 1);
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	function update(){
		try{			
			if(!isset($this->parametros[0]) || empty($this->parametros[0])){				
				$retorno['codigo'] = 1;
				$retorno['input']  = $_POST;
				$retorno['output'] = null;
				$retorno['mensagem'] = "Erro paramêtros id";
				throw new Exception (json_encode($retorno), 1);
			}else{
				$id = $this->parametros[0];				
			}	

			if(!isset($_POST['tarefa']) || empty($_POST['tarefa'])){				
				$retorno['codigo'] = 1;
				$retorno['input']  = $_POST;
				$retorno['output'] = null;
				$retorno['mensagem'] = "Informe uma tarefa";
				throw new Exception (json_encode($retorno), 1);
			}else{
				$insert['tarefa'] = $_POST['tarefa'];
			}				
			$update = $this->modelo->save($insert, $id);
			if(isset($update) && is_numeric($update)){
				$retorno['codigo'] = 0;
				$retorno['input']  = $insert;
				$retorno['output'] = $update;
				$retorno['mensagem'] = "Sucesso";
				throw new Exception (json_encode($retorno), 1);
			}else{
				$retorno['codigo'] = 1;
				$retorno['input']  = $_POST;
				$retorno['output'] = $this->modelo->info;
				$retorno['mensagem'] = "Erro em salvar no banco";
				throw new Exception (json_encode($retorno), 1);
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}
?>
