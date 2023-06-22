<?php

class HomeModel extends MainModel {
    public function __construct($controller = null ){
		$this->setTable('tarefas');
		parent::__construct($controller);
	}

    function getTarefas($id = null){
        $query = "
        SELECT
            *
        FROM
            tarefas
        WHERE
            (deleted = 0 OR deleted is null)";

        if($id){
            $query .= " and id = $id";
        }

        $query .= " order by id desc";
				
		return $this->db->exec($query);
    } 


}