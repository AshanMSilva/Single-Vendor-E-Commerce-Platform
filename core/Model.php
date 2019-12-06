<?php

class Model{
	protected $_db, $_table, $_modelName, $_softDelete = false, $_columnNames = [];
	public $id;

	public function __construct($table){
		$this->_db = DB::getInstance();
		$this->_table = $table;
		$this->_setTableColumns();
		$this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table)));
	}

	protected function _setTableColumns(){
		$columns = $this->get_columns();
		foreach($columns as $column){
			$this->_columnNames[] = $column->Field;
			$this->{$columnName} = null;
		}
	}

	public function get_columns(){
		return $this->_db->get_columns($this->_table);
	}

	public function select($params = []){
		$results = [];
		$resultsQuery = $this->_db->select($this->_table, $params);

		foreach($resultsQuery as $result){
			$obj = new $this->_modelName($this->_table);

			foreach($result as $key => $val){
				$obj->$key = $val;
			}
			$results[] = $obj;
		}
		return $results;
	}

	public function save(){
		$fields = [];
		foreach($this->_columnNames as $column){
			$fields[$column] = $this->$column;
		}
		//determine whether to update of insert
		if(property_exists($this, 'id') && $this->id != ''){
			return $this->update($this->id, $fields);
		}
		else{
			return $this->insert($fields);
		}
	}

	public function insert($fields){
		if(empty($fields))	return false;
		return $this->_db->insert($this->_table, $fields);
	}

	public function update($id, $fields){
		if(empty($fields) || $id == '')  return false;
		return $this->_db->update($this->_table, $id, $fields);
	}

	public function delete($id = ''){
		if($id == '' && $this->id == '')	return false;
		$id = ($id == '') ? $this->id : $id;
		if($this->_softDelete){
			return $this->update($id, ['deleted' => 1]);	//need a column named 'deleted'
		}
		return $this->_db->delete($this->_table, $id);
	}

	public function query($sql, $bind = []){
		return $this->_db->query($sql, $bind);
	}
}