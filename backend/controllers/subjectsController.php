<?php
/**
*    File        : backend/controllers/subjectsController.php
*    Project     : CRUD PHP
*    Author      : Tecnologías Informáticas B - Facultad de Ingeniería - UNMdP
*    License     : http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
*    Date        : Mayo 2025
*    Status      : Prototype
*    Iteration   : 3.0 ( prototype )
*/

require_once("./repositories/subjects.php");
require_once("./repositories/studentsSubjects.php");

function handleGet($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input['id'])) 
    {
        $subject = getSubjectById($conn, $input['id']);
        echo json_encode($subject);
    } 
    else 
    {
        $subjects = getAllSubjects($conn);
        echo json_encode($subjects);
    }
}

function handlePost($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);
    $name = trim($input['name'] ?? '');

    if (empty($name)) {
        http_response_code(400);
        echo json_encode(["error" => "El nombre de la materia no puede estar vacío"]);
        return;
    }

    $existing = getSubjectByName($conn, $name);
    if ($existing) {
        http_response_code(400);
        echo json_encode(["error" => "Ya existe una materia con ese nombre"]);
        return;
    }

    $result = createSubject($conn, $name);
    if ($result['inserted'] > 0) 
    {
        echo json_encode(["message" => "Materia creada correctamente"]);
    } 
    else 
    {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo crear"]);
    }
}

function handlePut($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);
    $id = $input['id'] ?? null;
    $name = trim($input['name'] ?? '');

    if (!$id) {
        http_response_code(400);
        echo json_encode(["error" => "Falta id"]);
        return;
    }

    if ($name === '') {
        http_response_code(400);
        echo json_encode(["error" => "El nombre no puede estar vacío"]);
        return;
    }

    $existing = getSubjectByName($conn, $name);
    if ($existing && $existing['id'] != $id) {
        http_response_code(409); 
        echo json_encode(["error" => "Ya existe otra materia con ese nombre"]);
        return;
    }

    $result = updateSubject($conn, $id, $name);
    if ($result['updated'] > 0) 
    {
        echo json_encode(["message" => "Materia actualizada correctamente"]);
    } 
    else 
    {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo actualizar"]);
    }
}

function handleDelete($conn) 
{
    $id = json_decode(file_get_contents("php://input"), true)['id'];
    
    if (subjectHasStudents($conn, $id))
    {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo eliminar ya que existen estudiantes asociados a esta materia"]);
        return;
    }

    $result = deleteSubject($conn, $id);
    if ($result['deleted'] > 0) 
    {
        echo json_encode(["message" => "Materia eliminada correctamente"]);
    } 
    else 
    {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo eliminar"]);
    }
}
?>