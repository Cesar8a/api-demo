<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//Consultar todos los usuarios
$app->get("/users", function(Request $request, Response $response){

	try{
		$dbConnection = new dbConnection();
		$data = array();

		$query = "SELECT * FROM `users`";

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
					"description" => utf8_encode($row->description),
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
$app->get("/users/{id}", function(Request $request, Response $response){
	return "Consultar un usuario";
});

//Agregar un usuario
$app->post("/users/add", function(Request $request, Response $response){

	/*
	$name = empty($request->getParam("name")) ? "" : utf8_decode($request->getParam("name"));
	$phone = empty($request->getParam("phone")) ? "" : utf8_decode($request->getParam("phone"));
	$description = empty($request->getParam("description")) ? "" : utf8_decode($request->getParam("description"));

	if(!empty($name) && !empty($phone)){
		$data = array(
			"status" => $response->status,
			"mensaje" => "Los datos se almacenaran en la bd"
		);
	}else{
		$data = array(
			"status" => $response->status,
			"mensaje" => "Datos incompletos el nombre y/o teléfono son obligatorios"
		);
	}

	$data = json_encode($data);
	*/

	return "Agregar un usuario";

});

//Actualizar un usuario
$app->put("/users/update", function(Request $request, Response $response){
	return "Actualizar un usuario";
});

//Eliminar un usuario
$app->delete("/users/delete", function(Request $request, Response $response){
	return "Eliminar un usuario";
});

?>