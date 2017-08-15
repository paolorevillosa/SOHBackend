<?php

class database(){

	public function getData($id){
		//lagay mo dito ung DB config like add,username,pass
		$sql = "SELECT * FROM WHERE ID = $id";
		$result = mysqli_query($sql,$conn);
		return $result;
	}

	public function updateData($id,$value){
		//lagay mo dito ung DB config like add,username,pass
		$sql = "UPDATE SET tuloy mo FROM WHERE ID = $id";
		$result = mysqli_query($sql,$conn);	
	}
}

class data extend database{
	public $id;
	public $amount;

	public function setId($id){
		$this->$id = $id;
	}

	public function setAmount($amount1){
		$this->$amount = $amount1;
	}
}



	database $db = new database();

	$result = $db->getData('1');
	$db->updateData('1',$result['amount']);

?>
