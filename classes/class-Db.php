<?php

class Db
{
	
	public
		$host      = null, // Host da base de dados
		$db_name   = null, // Nome do banco de dados
		$password  = null, // Senha do usuário da base de dados
		$user      = null, // Usuário da base de dados
		$charset   = null, // Charset da base de dados
		$pdo       = null, // Nossa conexão com o BD
		$error     = null, // Configura o erro
		$debug     = true, // Mostra todos os erros
		$log	   = null,
		$last_id   = null, // Último ID inserido
		$prepare   = null;

	private $hoje;
	
	public function __construct($parametros = null){
		
		$this->hoje = date('Y-m-d H:m:s');
			
		$this->db_name    = !empty($parametros['db_name'])?$parametros['db_name'] : DB_NAME;
        $this->host       = !empty($parametros['host'])?$parametros['host'] : HOSTNAME;
        $this->port       = !empty($parametros['port'])?$parametros['port'] : DB_PORT;
        $this->user       = !empty($parametros['user'])?$parametros['user'] : DB_USER;
        $this->password   = !empty($parametros['password'])? $parametros['password'] : DB_PASSWORD;
        $this->charset    = !empty($parametros['charset'])?$parametros['charset'] : DB_CHARSET;
        $this->debug      = !empty($parametros['debug'])?$parametros['debug'] : DEBUG;
				
		$this->connect();
	} 
	
	protected function connect() {
		
		$pdo_details  = "mysql:host={$this->host};";
		$pdo_details .= "dbname={$this->db_name};";
		$pdo_details .= "charset={$this->charset};";
				
		try {
			$this->pdo = new PDO($pdo_details, $this->user, $this->password, array(PDO::ATTR_PERSISTENT => true));
			$this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT,1);

		}catch(PDOException $e){
			$this->erro = json_decode($e->getMessage());
			die(' Erro DB - DB: '.$this->db_name." HOST: ".$this->host." USER: ".$this->port." PASS: ".$this->password);
		} 
	} 
	
	public function getDbName(){
		return $this->db_name;
	}

	public function query($stmt, $data_array = null) {		
		$query      = $this->pdo->prepare($stmt);		
		$check_exec = $query->execute($data_array);
				
		if($check_exec){			
			if(empty($query->rowCount())){				
				return false;
			}else{				
				return $query;
			}
		}else{			
			$error       = $query->errorInfo();
			$this->error = $error[2];			
			return false;
		}
	}
	
	public function insert( $table ) {		
		$cols = array();		
		$place_holders = '(';	
		$values = array();
		// O $j will assegura que colunas serão configuradas apenas uma vez
		$j = 1;
		// Obtém os argumentos enviados
		$data = func_get_args();	
		if ( ! isset( $data[1] ) || ! is_array( $data[1] ) ) {
			return;
		}
		
		// Faz um laço nos argumentos
		for ( $i = 1; $i < count( $data ); $i++ ) {			
			foreach ( $data[$i] as $col => $val ) {				
				if ( $i === 1 ){
					$cols[] = "`$col`";
				}
				if ( $j <> $i ) {					
					$place_holders .= '), (';
				}
				
				$place_holders .= '?, ';			
				$values[] = $val;
				$j = $i;
			}			
			$place_holders = substr( $place_holders, 0, strlen( $place_holders ) - 2 );
		}
		
		$cols = implode(', ', $cols);			
		if(!array_key_exists("alterado_em", $data[1])){
			$cols .= " , alterado_em ";
			$place_holders .= " ,?";
			$values[] = $this->hoje;
		}
		
		$stmt = "INSERT INTO `$table` ( $cols ) VALUES $place_holders) ";
		
		// Insere os valores		
		$insert = $this->query( $stmt, $values );		
		if($insert){			
			if($this->pdo->lastInsertId()){				
				$this->last_id = $this->pdo->lastInsertId();
			}			
			return $this->last_id;
		}		
		return;
	} 
	public function update( $table, $where_field, $where_field_value, $values ){
		// Você tem que enviar todos os parâmetros
		if (empty($table) || empty($where_field) || empty($where_field_value)){
			return;
		}
		
		$stmt = " UPDATE `$table` SET ";		
		$set = array();
				
		if(is_array($where_field) && is_array($where_field_value)){		
			$where  = " WHERE ";
			$where .= implode(' and ', $where_field);
			exit;
		}elseif(!is_array($where_field) && is_array($where_field_value)){
			$where  = " WHERE $where_field in (";
			$where .= implode(',', $where_field_value).')'; 
		}else{
			$where = " WHERE `$where_field` = ? ";	
		}

		// Você precisa enviar um array com valores
		if(!is_array($values)){
			return;
		}
		
		foreach($values as $column => $value){
			$set[] = " `$column` = ?";
		}		
		
		$set = implode(', ', $set);			
		if(!isset($values['alterado_em'])){
			$set .= " , alterado_em = ? ";
			$values['alterado_em'] = $this->hoje;
		}
		
		$values = array_values($values);		
		if(!is_array($where_field_value)){
			$values[] = $where_field_value;
		}		
		
		$stmt .= $set . $where;		
		$update = $this->query($stmt,$values);
		// Verifica se a consulta está OK
		if ($update){			
			return $update;
		}		
		return;
	} 	

	function exec($stmt, $data_array = null ){					
		$exec = $this->query($stmt, $data_array);						
		if($exec){					
			$return = $exec->fetchAll(PDO::FETCH_ASSOC);			
			return json_encode($return);
		}else{
			return false;
		}
	}
}