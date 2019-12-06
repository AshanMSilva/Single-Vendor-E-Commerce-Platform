<?php

class Home extends Controller {

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
	}
	
	public function indexAction() {
		$db = DB::getInstance();

		//$contactsQ = $db->delete('contacts', 2);
		//$contactsQ = $db->query("SELECT * FROM contacts ORDER BY name");
		//$contacts = $contactsQ->results();
		//dnd($contacts[0]->name);

		//$columns = $db->get_columns('contacts');
		//dnd($columns);

		//$contactsQ = $db->select('contacts', ['name', 'email'], "id=1 AND name='John'");
		//dnd($contactsQ->results());

		$contacts = $db->select('contacts', [
			'conditions' => ["name = ?", "id = ?"],
			'bind' => ['John', '1'],
			'order' => "name",
			'limit' => 5
		]);
		dnd($contacts);

		/*$fields = [
			'name' => 'Peter',
			'email' => 'peterparker@gmail.com',
			'address' => '12, Temple Rd, Gampaha'
		];
		$insertQ = $db->insert('contacts', $fields);
		dnd($insertQ);*/

		$this->view->render('home/index');
	}

}