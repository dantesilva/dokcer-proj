<?php

$call = $_REQUEST["call"] ?? null;

$conn = mysqli_connect("mysql", "user", "K0QHlEwwLVHK5U", "test");

function getTable($table) {
	global $conn;

	$id = $_POST["id"];
	$query = mysqli_query($conn, "SELECT * FROM $table WHERE id=" . intval($id));
	return mysqli_fetch_assoc($query);
}

function listTable($table, $fieldList) {
	global $conn;

	$query = mysqli_query($conn, "SELECT id, " . implode(", ", $fieldList) . " FROM $table");
	$result = [ "list" => [] ];
	while ($row = mysqli_fetch_assoc($query)) {
		$result["list"][] = $row;
	}
	return $result;
}

function saveTable($table, $fieldList) {
	global $conn;

	$id = $_POST["id"];
	if ($id <= 0) {
		$set = [];
		foreach($fieldList as $field) {
			$set[] = "'" .  mysqli_real_escape_string($conn, $_POST[$field] ?? "") . "'";
		}
		error_log("INSERT INTO $table (" . implode(", ", $fieldList) . ") VALUES (" . implode(", ", $set). ")");
		$query = mysqli_query($conn, "INSERT INTO $table (" . implode(", ", $fieldList) . ") VALUES (" . implode(", ", $set). ")");
	} else {
		$set = [];
		foreach($fieldList as $field) {
			$set[] = "$field='" .  mysqli_real_escape_string($conn, $_POST[$field] ?? "") . "'";
		}
		$query = mysqli_query($conn, "UPDATE $table SET " . implode(", ", $set). " WHERE id=" . intval($id));
	}

	return [];
}

session_start();

if ($call != "login" && empty($_SESSION["id"])) {
	Header("Access denied", true, 401);
	exit;
}

switch ($call) {
	case "getLogin":
		$result = [ "id" => $_SESSION["id"] ];
		break;

	case "login": 
		$login = $_POST["login"];
		$password = $_POST["password"];

		$query = mysqli_query($conn, "SELECT id FROM usuario WHERE codigo='" . mysqli_real_escape_string($conn, $login) . "' AND password='" . mysqli_real_escape_string($conn, md5($password)) . "'");
		$row = mysqli_fetch_assoc($query);
		if (!empty($row["id"])) {
			$result = [];
			$_SESSION["id"] = $row["id"];
		} else {
			Header("Access denied", true, 401);
			exit;
		}
		break;


	case "empresaSave": 
		$id = $_POST["id"];
		$result = saveTable("empresa", [ "codigo", "nome" ]);
		break;

	case "empresaDetail": 
		$id = $_POST["id"];
		$result = getTable("empresa");
		break;

	case "empresaList": 
		$result = listTable("empresa", [ "codigo", "nome" ]);
		break;


	case "pacienteSave": 
		$id = $_POST["id"];
		$result = saveTable("paciente", [ "codigo", "nome", "id_empresa", "area" ]);
		break;

	case "pacienteDetail": 
		$id = $_POST["id"];
		$result = getTable("paciente");
		$result["empresa"] =  listTable("empresa", [ "codigo", "nome" ]);
		break;

	case "pacienteList": 
		$result = listTable("paciente", [ "codigo", "nome" ]);
		break;


	case "usuarioSave": 
		$id = $_POST["id"];
		$fields = [ "codigo", "nome", "id_empresa" ];
		if (!empty($_POST["password"])) {
			$fields[] = "password";
			$_POST["password"] = md5($_POST["password"]);
		}
		$result = saveTable("usuario", $fields);
		break;

	case "usuarioDetail": 
		$result = getTable("usuario");
		unset($result["password"]);
		$result["empresa"] = listTable("empresa", [ "codigo", "nome" ]);
		break;

	case "usuarioList": 
		$result = listTable("usuario", [ "codigo", "nome" ]);
		break;


	default:
		Header("Not found", true, 404);
		exit;
}

header("Content-Type: application/json");

echo json_encode($result);
