<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Consultar todos los usuarios
$app->get("/users", function(Request $request, Response $response){

	try{
		$dbConnection = new dbConnection();
		$data = array();

		$query = "SELECT * FROM `users` WHERE `status` = '1' ORDER BY id DESC";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			$i = 0;
			while(($row = $dbConnection->fetchRows($result)) != false){
				$data["users"][$i] = array(
					"id" => $row->id,
					"creation_date" => $row->creation_date,
					"name" => utf8_encode($row->name),
					"phone" => $row->phone,
					"address" => utf8_encode($row->address),
					"email" => $row->email,
					"birth_date" => $row->birth_date,
					"last_access" => $row->last_access
				);
				$i++;
			}
			$dbConnection->closeResult($result);
		}else{
			$data = array("error" => utf8_encode("No existen usuarios en la BD"));
		}

		$dbConnection = null;

		return json_encode($data);

	}catch(Exception $e){
		echo '{"error": {"mensaje":'.$e->getMessage().'}}';
	}

});

//Consultar un usuario
$app->get("/users/{id}", function(Request $request, Response $response, array $args){

	$id = $args["id"];

	try{
		$dbConnection = new dbConnection();
		$data = array();

		$query = "SELECT * FROM `users` WHERE `id` = $id";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			$i = 0;
			while(($row = $dbConnection->fetchRows($result)) != false){
				$data["user"][$i] = array(
					"name" => utf8_encode($row->name),
					"phone" => $row->phone,
					"address" => utf8_encode($row->address),
					"email" => $row->email,
					"birth_date" => $row->birth_date,
					"last_access" => $row->last_access
				);
				$i++;
			}
			$dbConnection->closeResult($result);
		}else{
			$data = array("error" => utf8_encode("No existe usuario con el ID en la BD"));
		}

		$dbConnection = null;

		return json_encode($data);

	}catch(Exception $e){
		echo '{"error": {"mensaje":'.$e->getMessage().'}}';
	}

});

//Agregar un usuario
$app->post("/users/add", function(Request $request, Response $response){

	$name = empty($request->getParam("name")) ? "" : utf8_decode($request->getParam("name"));
	$phone = empty($request->getParam("phone")) ? "" : utf8_decode($request->getParam("phone"));
	$address = empty($request->getParam("address")) ? "" : utf8_decode($request->getParam("address"));
	$email = empty($request->getParam("email")) ? "" : utf8_decode($request->getParam("email"));
	$birth_date = empty($request->getParam("birth_date")) ? "" : utf8_decode($request->getParam("birth_date"));

	try{
		$dbConnection = new dbConnection();
		$data = array();

		$query = "INSERT INTO `users` (`name`,  `phone`, `address`, `email`, `birth_date`) 
					VALUES ('$name', '$phone', '$address', '$email', '$birth_date')";

		if($dbConnection->exeQuery($query)){
			$data = array("success" => "Usuario almacenado con éxito");
		}else{
			$data = array("error" => "No se pudo agregar al usuario");
		}
	
		$dbConnection = null;

		return json_encode($data);

	}catch(Exception $e){
		echo '{"error": {"mensaje":'.$e->getMessage().'}}';
	}

});

//Actualizar un usuario
$app->put("/users/update/{id}", function(Request $request, Response $response, array $args){
	$id = $args["id"];

	$name = empty($request->getParam("name")) ? "" : utf8_decode($request->getParam("name"));
	$phone = empty($request->getParam("phone")) ? "" : utf8_decode($request->getParam("phone"));
	$address = empty($request->getParam("address")) ? "" : utf8_decode($request->getParam("address"));
	$email = empty($request->getParam("email")) ? "" : utf8_decode($request->getParam("email"));
	$birth_date = empty($request->getParam("birth_date")) ? "" : utf8_decode($request->getParam("birth_date"));

	try{
		$dbConnection = new dbConnection();
		$data = array();

		$query = "UPDATE `users` SET
							`name` = '$name',
							`phone` = '$phone',
							`address` = '$address',
							`email` = '$email',
							`birth_date` = '$birth_date'
							WHERE `id` = '$id'";

		if($dbConnection->exeQuery($query)){
			$data = array("success" => "Usuario actualizado con éxito");
		}else{
			$data = array("error" => "No se pudo actualizar al usuario");
		}
	
		$dbConnection = null;

		return json_encode($data);

	}catch(Exception $e){
		echo '{"error": {"mensaje":'.$e->getMessage().'}}';
	}
});

//Eliminar un usuario
$app->delete("/users/delete/{id}", function(Request $request, Response $response, array $args){

	$id = $args["id"];

	try{
		$dbConnection = new dbConnection();
		$data = array();

		$query = "DELETE FROM `users` WHERE `id` = $id";

		if($dbConnection->exeQuery($query)){
			$data = array("success" => "Usuario eliminado con éxito");
		}else{
			$data = array("error" => utf8_encode("No se puedo eliminar al usuario"));
		}

		$dbConnection = null;

		return json_encode($data);

	}catch(Exception $e){
		echo '{"error": {"mensaje":'.$e->getMessage().'}}';
	}
});

?>