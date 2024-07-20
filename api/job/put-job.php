<?php
/*
 * BACKEND INTRANET
 * PUT UPDATE JOB LIST
 */

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
  header('HTTP/1.1 405 Method Not Allowed');
  echo json_encode(['error' => 'Method not allowed']);
  exit();
}

// Verificar si se proporciona un token en el encabezado de autorización
$headers = apache_request_headers();

if (!isset($headers['Authorization'])) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Access not allowed']);
    exit();
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

// Verificar el token aquí según tus requerimientos
if (!verificarToken($token)) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Invalid token']);
    exit();
}

// Obtener el cuerpo de la solicitud PUT
$input_data = file_get_contents("php://input");

// Decodificar los datos JSON
$data = json_decode($input_data, true);

// Verificar si se recibieron datos
if ($data === null) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Error decoding JSON data']);
    exit();
}

$type = $_GET['type'] ?? '';
$response = [];

switch ($type) {
    case 'jobStatus':
        updateJobStatus($data, $response);
        break;
    case 'updateJob':
        updateJob($data, $response);
        break;
    case 'updateNote':
        updateNoteData($data, $response);
        break;
    default:
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Invalid type parameter']);
        exit();
}

function updateJobStatus($data, &$response) {
    global $conn;

    $status = $data['status'] ?? null;
    $id = $data['id'] ?? null;
    $userId = $data['userId'] ?? null;

    if (is_null($status) || is_null($id) || is_null($userId)) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Missing required fields']);
        exit();
    }

    $timestamp = date('Y-m-d H:i:s');

    $sql = "UPDATE job_list SET status=:status WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":status", $status, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $sql = "INSERT INTO job_list_history_status SET idJob=:idJob, status=:status, user=:user, date=:date";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":idJob", $id, PDO::PARAM_INT);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        $stmt->bindParam(":user", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":date", $timestamp, PDO::PARAM_STR);
        $stmt->execute();

        $response['status'] = 'success';
    } else {
        $response['status'] = 'error db';
    }

    header("Content-Type: application/json");
    echo json_encode($response);
}

function updateJob($data, &$response) {
    global $conn;

    $requiredFields = ['project_name', 'date', 'int_ext', 'client', 'logged_by'];
    $hasError = false;
    $errors = [];

    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            $hasError = true;
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
        }
    }

    if ($hasError) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Validation errors', 'errors' => $errors]);
        exit();
    }

    $project_management = isset($data["project_management"]) ? '{' . implode(',', array_unique(explode(',', trim($data["project_management"], '{}')))) . '}' : null;

    $sql = "UPDATE job_list SET 
                project_name=:project_name, 
                date=:date, 
                int_ext=:int_ext, 
                logged_by=:logged_by, 
                client=:client, 
                project_email=:project_email, 
                project_phone=:project_phone, 
                project_management=:project_management, 
                job_comment=:job_comment, 
                estimated_time=:estimated_time 
            WHERE id=:id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":project_name", $data['project_name'], PDO::PARAM_STR);
    $stmt->bindParam(":date", $data['date'], PDO::PARAM_STR);
    $stmt->bindParam(":int_ext", $data['int_ext'], PDO::PARAM_INT);
    $stmt->bindParam(":logged_by", $data['logged_by'], PDO::PARAM_INT);
    $stmt->bindParam(":client", $data['client'], PDO::PARAM_INT);
    $stmt->bindParam(":project_email", $data['project_email'], PDO::PARAM_STR);
    $stmt->bindParam(":project_phone", $data['project_phone'], PDO::PARAM_STR);
    $stmt->bindParam(":project_management", $project_management, PDO::PARAM_STR);
    $stmt->bindParam(":job_comment", $data['job_comment'], PDO::PARAM_STR);
    $stmt->bindParam(":estimated_time", $data['estimated_time'], PDO::PARAM_STR);
    $stmt->bindParam(":id", $data['id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error db';
    }

    header("Content-Type: application/json");
    echo json_encode($response);
}

function updateNoteData($data, &$response) {
    global $conn;

    $note = $data['note'] ?? null;
    $sanitized_note = sanitize_html($note);
    $id = $data['id'] ?? null;
    $idUser_modified = $data['idUser'] ?? null;

    if (is_null($note) || is_null($id) || is_null($idUser_modified)) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Missing required fields']);
        exit();
    }

    $date_modified = date("Y-m-d H:i:s");

    $sql = "UPDATE job_list_notes SET 
                note=:note, 
                date_modified=:date_modified, 
                idUser_modified=:idUser_modified 
            WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":note", $sanitized_note, PDO::PARAM_STR);
    $stmt->bindParam(":date_modified", $date_modified, PDO::PARAM_STR);
    $stmt->bindParam(":idUser_modified", $idUser_modified, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error db';
    }

    header("Content-Type: application/json");
    echo json_encode($response);
}

?>
