<?php
class MainModel{
		
	public 
		$db,
		$info,	
		$controller;

	protected 
		$table;

	function __construct($controller = null, $parametros = null){		
		
		if($parametros){
			$this->setDb(null, $parametros);
		}else{
			$this->setDb();
		}		
		$this->controller = $controller;	
	}

	function setDb($db = null, $parametros = null){
		if($db){
			$this->db = $db;
		}else{			
			if($parametros){						
				$this->db = new Db($parametros);
			}else{
				$this->db = new Db();
			}			
		}
	}
	
	function setTable($table){
		$this->table = $table;
	}
	
	function getTable(){
		return $this->table;
	}

	function save($param, $id = null, $field = 'id'){
		try{
			if(is_object($param)){
				$param = get_object_vars($param);
			}

			if(!$this->table){
				$retorno['codigo']   = 1;
                $retorno['tipo']     = 'error';
				$retorno['input']    = $param;
				$retorno['output']   = null;
				$retorno['mensagem'] = 'Tabela não definida';
				throw new Exception(json_encode($retorno), 1);
			}
			
			if($id){
				if(is_numeric($id) && !empty($id)){
					$where_field       = $field;
					$where_field_value = $id;
					$this->db->update($this->table, $where_field, $where_field_value, $param);
				}else{
					$retorno['codigo']   = 1;
					$retorno['tipo']     = 'error';
					$retorno['input']    = $id;
					$retorno['output']   = null;
					$retorno['mensagem'] = 'ID do registro invalido';
					throw new Exception(json_encode($retorno), 1);
				}
			}else{				
				$id_db = $this->db->insert( $this->table, $param );				
			}

			if(!$this->db->error){
				if(!$id && $this->db->last_id){
					$id = $this->db->last_id;
				}				
				if($id){
					$retorno['codigo']   = 0;
					$retorno['tipo']     = 'sucesso';
					$retorno['input']    = $param;
					$retorno['output']   = $id;
					$retorno['mensagem'] = 'Sucesso ao salvar registro na tabela '.$this->table;
					throw new Exception(json_encode($retorno), 1);
				}else{
					$retorno['codigo']   = 1;
					$retorno['tipo']     = 'error';
					$retorno['input']    = $param;
					$retorno['output']   = $this->db->error;
					$retorno['mensagem'] = 'Erro desconhecido ao salvar registro na tabela '.$this->table;
					throw new Exception(json_encode($retorno), 1);
				}
			}else{
				$retorno['codigo']   = 1;
				$retorno['tipo']     = 'error';
				$retorno['input']    = $param;
				$retorno['output']   = $this->db->error;
				$retorno['mensagem'] = 'Erro ao salvar registro na tabela '.$this->table;
				throw new Exception(json_encode($retorno), 1);
			}
		} catch (Exception $e) {
			$this->info = json_decode($e->getMessage());
			if($this->info->codigo == 0){
				return $id;
			}else{				
				return false;;
			}
		}
	}	

} 