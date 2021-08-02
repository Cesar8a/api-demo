<?php

class dbConnection {

	private $connection = null;

	protected $server = "localhost";
	protected $user = "root";
	protected $password = "";
	protected $database = "api_demo";

	private function createConnection(){
		//Create connection
		$this->connection = mysqli_connect($this->server, $this->user, $this->password, $this->database);

		//Check connection
		if(mysqli_connect_errno($this->connection)){
			echo "<h2>Error en la conexión MySQL: ".mysqli_connect_error()."</h2>";
		}
	}

	public function __construct(){
		$this->createConnection();
	}

	public function __destruct(){
		if(isset($this->connection)){
			//mysqli_close($this->connect);
			$this->connection->close();
		}
		//Destruye una variable especificada.
		unset($this->connection);
	}

	public function exeQuery($query){
		return $this->connection->query($query);
	}

	function getLastError(){
		return $this->connection->error;
	}

	function fetchRows($result){
		return $result->fetch_object();
	}

	function closeResult($result){
		//Liberar el conjunto de resultados
		$result->close();
	}

	function getNumRows($result){
		return $result->num_rows;
	}

} //Fin de la class dbConnection
?>