<?php
/*
 * BACKEND INTRANET
 * GET USERS
 */

// Verificar si el método de solicitud es GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
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

// Función para manejar errores de consulta SQL
function handleSQLError($stmt) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Database error']);
    exit();
}

// Configurar la cabecera de respuesta JSON
header('Content-Type: application/json');

// Opción a) Lista de clientes
if (isset($_GET['type']) && $_GET['type'] === 'clientsList') {
    global $conn;
    $data = array();
    $stmt = $conn->query("SELECT 
        c.id,
        c.client_name,
        c.business_name,
        c.business_address,
        c.email,
        c.phone,
        c.mobile,
        c.vat_number,
        c.po_number
        FROM client_list AS c
        ORDER BY c.business_name ASC");
    if ($stmt) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    echo json_encode($data ?: []);
}

// Opción b) Lista de clientes (solo nombres)
elseif (isset($_GET['type']) && $_GET['type'] === 'clients') {
    global $conn;
    $data = array();
    $stmt = $conn->query("SELECT 
    CONCAT(c.client_name, ' - (', c.business_name, ')') AS business_name,
    c.id
    FROM client_list AS c 
    ORDER BY c.client_name ASC");
    if ($stmt->rowCount() === 0) {
        echo json_encode(['error' => 'No rows']);
    } else {
        while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $users;
        }
        echo json_encode($data);
    }
}

// Opción c) Información de un cliente específico
elseif (isset($_GET['clientInfo']) && is_numeric($_GET['clientInfo'])) {
    $id = $_GET['clientInfo'];

    global $conn;
    $stmt = $conn->prepare("SELECT
        c.id,
        c.client_name,
        c.business_name,
        c.business_address,
        c.billing_address,
        c.email,
        c.phone,
        c.mobile,
        c.vat_number,
        c.po_number
        FROM client_list AS c
        WHERE c.id = :id");
    if ($stmt->execute(['id' => $id])) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data ?: []);
    } else {
        handleSQLError($stmt);
    }
}

// Opción d) Información de un cliente y sus proyectos
elseif (isset($_GET['clientId']) && is_numeric($_GET['clientId']) ) {
    $clientId = $_GET['clientId'];
    global $conn;
    $stmt = $conn->prepare("SELECT      
        j.id,
        j.project_name,
        j.status,
        j.date,
        j.job_number
        FROM job_list AS j
        WHERE j.client = :client
        ORDER BY j.job_number DESC");
    if ($stmt->execute(['client' => $clientId])) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data ?: []);
    } else {
        handleSQLError($stmt);
    }
}

// Si no se proporciona una opción válida
else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid request']);
    exit();
}
