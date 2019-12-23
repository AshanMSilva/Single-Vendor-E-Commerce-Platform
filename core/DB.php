<?php

class DB{
	private static $_instance = null;
	private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_lastInsertID = null;

	private function __construct(){
		try{
			$this->_pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
		}
		catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public function query($sql, $params = []){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1; 
			if(count($params)){
				foreach($params as $p){
					$this->_query->bindValue($x, $p);
					$x++;
				}
			}			
			//dnd($this->_query);
			if($this->_query->execute()){
				$this->_result = $this->_query->fetchALL(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				$this->_lastInsertID = $this->_pdo->lastInsertID();				
			}
			else{
				$this->_error = true;
			}
		}
		return $this;
	}

	/*public function select($table, $fields = '*', $conditions = 1){
		$fieldString = '';
		if ($fields != '*'){
			foreach($fields as $field){
				$fieldString .= '`' . $field . '`,';
			}
			$fieldString = rtrim($fieldString, ',');
		}
		else{
			$fieldString = $fields;
		}

		$sql = "SELECT {$fieldString} FROM {$table} WHERE {$conditions}";
		if(!$this->query($sql)->error()){
			return $this; 
		}
		else{
			$this->_error = true;
			return $this;
		}
	}*/

	protected function _read($table, $columns, $params=[]){
		//print_r($params);
		//dnd($columns);
		$conditionString = '';
		$bind = [];
		$order = '';
		$limit = '';
		
		if(isset($columns)){
			$columnString = '';
			if(is_array($columns)){
				foreach($columns as $column){
					$columnString .= ' ' . $column . ',';
				}
				$columnString = trim($columnString);
				$columnString = rtrim($columnString, ',');
			}
			else{
				$columnString = $columns;
			}			
		}

		//conditions
		if(isset($params['conditions'])){
			if(is_array($params['conditions'])){
				foreach($params['conditions'] as $condition){
					$conditionString .= ' ' . $condition . ' AND';
				}
				$conditionString = trim($conditionString);
				$conditionString = rtrim($conditionString, ' AND');
			}
			else{
				$conditionString = $params['conditions'];
			}
			if($conditionString != ''){
				$conditionString = ' WHERE ' . $conditionString;
			}
		}

		//bind
		if(array_key_exists('bind', $params)){
			$bind = $params['bind'];
		}

		//order
		if(array_key_exists('order', $params)){
			$order = ' ORDER BY ' . $params['order'];
		}

		//limit
		if(array_key_exists('limit', $params)){
			$limit = ' LIMIT ' . $params['limit'];
		}

		$sql = "SELECT {$columnString} FROM {$table}{$conditionString}{$order}{$limit}";
		//echo $sql . "<br>";
		//dnd($sql);
		if($this->query($sql, $bind)){
			if(!count($this->_result)) return false;
			return true;
		}
		return false;
	}

	public function select($table, $columns, $params=[]){
		if($this->_read($table, $columns, $params)){
			return $this->results();
		}
		return false;
	}

	public function insert($table, $fields = []){
		$fieldString = '';
		$valueString = '';
		$values = [];

		foreach($fields as $field => $value){
			$fieldString .= '`' . $field . '`,';
			$valueString .= '?,';
			$values[] = $value;
		}
		$fieldString = rtrim($fieldString, ',');
		$valueString = rtrim($valueString, ',');
		
		$sql =  "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
		// echo $sql . "<br>";
		if(!$this->query($sql, $values)->error()){
			// echo $this->_lastInsertID;
			return $this->_lastInsertID;
			//return true;
		}
		return false;
	}

	public function update($table, $id, $fields = []){
		$fieldString = '';
		$values = [];

		foreach($fields as $field => $value){
			$fieldString .= ' ' . $field . ' = ?,';
			$values[] = $value;
		}
		$fieldString = trim($fieldString);
		$fieldString = rtrim($fieldString, ',');

		$sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
		if(!$this->query($sql, $values)->error()){
			return true; 
		}
		return false;
	}

	public function delete($table, $id){
		$sql = "DELETE FROM {$table} WHERE id = {$id}";
		if(!$this->query($sql)->error()){
			return true; 
		}
		return false;
	}

	public function select_count($table, $columns, $params){
		//dnd($columns);
		if($this->_read($table, $columns, $params)){
			return $this->get_row_count();
		}
		else{
			return false;
		}
	}

	public function results(){
		return $this->_result;
	}

	public function get_row_count(){
		return $this->_count;
	}

	public function last_insert_id(){
		return $this->_lastInsertID;
	}

	public function get_columns($table){
		return $this->query("SHOW COLUMNS FROM {$table}")->results();
	}

	public function error(){
		return $this->_error;
	}

	public function call_procedure($procedure, $params = []){
		$paramString = '';
		
		if(isset($params)){
			
			if(is_array($params)){
				foreach($params as $param){
					$paramString .= ' ' . $param . ',';
				}
				$paramString = trim($paramString);
				$paramString = rtrim($paramString, ',');
			}
			else{
				$paramString = "'" . $params . "'";
			}
		}
		
		$sql = "CALL {$procedure}({$paramString})";
		// dnd($sql);
		if($this->query($sql)){
			return $this->results();
		}
		else{
			return false;
		}
	}

}