<?php

class Model{
	protected $_db, $_table, $_modelName, $_softDelete = false, $_columnNames = [];
	public $id;

	public function __construct(/* $table */){
		$this->_db = DB::getInstance();
		// $this->_table = $table;
		// $this->_setTableColumns();
		//$this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table)));
	}

	public function set_model_name($model_name){
		$this->_modelName = $model_name;
	}

	public function set_table_name($table){
		//echo $table;
		$this->_table = $table;
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

	public function select($columns, $params = []){
		$model_objs = [];
		$resultsQuery = $this->_db->select($this->_table, $columns, $params);

		foreach($resultsQuery as $result){
			$obj = new $this->_modelName($result);

			/*foreach($result as $key => $val){
				$obj->$key = $val;
			}*/
			$model_objs[] = $obj;
		}
		return $model_objs;
	}

	public function save(){
		$fields = [];
		foreach($this->_columnNames as $column){
			$fields[$column] = $this->$column;
		}
		//determine whether to update or insert
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

	public function get_last_insert_id(){
		return $this->_db->last_insert_id();
	}

	public function data(){
		$data = new stdClass();
		foreach($this->_columnNames as $column){
			$data->column = $this->column;
		}
		return $data;
	}
	
	public function assign($params){
		if(!empty($params)){
			foreach($params as $key => $val){
				if(in_array($key, $this->_columnNames)){
					$this->$key = sanitize($val);
				}
			}
			return true;
		}
		return false;
	}

	public function select_count($columns, $params = []){
		//dnd($params);
		return $this->_db->select_count($this->_table, $columns, $params);
	}

	protected function call_procedure($name, $params = []){
		return $this->_db->call_procedure($name, $params);
	}
}