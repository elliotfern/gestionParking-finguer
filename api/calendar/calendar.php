<?php
global $conn;

// Obtener headers y verificar token
$headers = apache_request_headers();
if (!isset($headers['Authorization'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['error' => 'No token provided']);
    exit();
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

// Verificar el token aquí según tus requerimientos
if (!verificarToken($token)) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Invalid token']);
    exit();
}

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        getEvents($conn);
        break;
    case 'POST':
        addEvent($conn);
        break;
    case 'PUT':
        updateEvent($conn);
        break;
    case 'DELETE':
        deleteEvent($conn);
        break;
}

function getEvents($conn) {
    $stmt = $conn->prepare("SELECT u.name, o.id, o.title, o.start, o.end, o.user, o.type FROM office_calendar AS o LEFT JOIN user_list AS u ON o.user = u.id");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($events);
}

function addEvent($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    $start = $data['start'];
    $end = $data['end'];
    $user = $data['user'];
    $type = $data['type'];

    $title = '';

    if ($type == '1') {
        $title = 'Cleaning';
    } elseif ($type == '2') {
        $title = 'Phone';
    }

    $stmt = $conn->prepare("INSERT INTO office_calendar (title, start, end, user, type) VALUES (:title, :start, :end, :user, :type)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':type', $type);

    if ($stmt->execute()) {
        $data['id'] = $conn->lastInsertId();
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Failed to add event"]);
    }
}

function updateEvent($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $start = $data['start'];
    $end = $data['end'];
    $user = $data['user'];

    $stmt = $conn->prepare("UPDATE office_calendar SET start = :start, end = :end, user = :user WHERE id = :id");
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Failed to update event"]);
    }
}

function deleteEvent($conn) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM office_calendar WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Failed to delete event"]);
    }
}

?>