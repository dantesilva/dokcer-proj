<?php

$call = $_REQUEST["call"] ?? null;

$conn = mysqli_connect("localhost", "zxcv", "K0QHlEwwLVHK5UW7", "test2");

function saveTable($table, $fieldList) {
	global $conn;

	$id = $_POST["id"];
	if ($id <= 0) {
		$set = [];
		foreach($fieldList as $field) {
			$set[] = "'" .  mysqli_real_escape_string($conn, $_POST[$field] ?? "") . "'";
		}
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

switch ($call) {
	case "formularioSave": 
		$id = $_POST["id"];
		$result = saveTable("formulario", [ "nome", "email", "mensagem" ]);
		break;



	default:
		Header("Not found", true, 404);
		exit;
}

header("Content-Type: application/json");

echo json_encode($result);
