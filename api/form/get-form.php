<?php
/*
 * BACKEND INTRANET
 * GET JOB LIST
 */

// Check if the request method is GET
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
    // Token no válido
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Invalid token']);
    exit();
}

// Token válido, puedes continuar con el código para obtener los datos del usuario

if (isset($_GET['type'])) {
    // a) ALL FORMS
    if ($_GET['type'] == 'allForms') {
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT
            c.id,
            c.client_name,
            c.company_name,
            c.email,
            c.date,
            b.bq1,
            s.sq1,
            w.wq1,
            c.date,
            c.jobId
            FROM form_client AS c
            LEFT JOIN form_brand AS b ON c.id = b.idClient
            LEFT JOIN form_social AS s ON c.id = s.idClient
            LEFT JOIN form_web AS w ON c.id = w.idClient
            ORDER BY c.date DESC");
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

     // b) FORM ID DETAILS
        } elseif ($_GET['type'] == 'clientId' && isset($_GET['id']) && is_numeric($_GET['id'])) {
        $idClient = $_GET['id'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT
            c.id,
            c.client_name,
            c.company_name,
            c.address,
            c.email,
            c.phone,
            c.vat_number,
            c.po_number,
            c.cq1,
            c.cq2,
            c.cq2_1,
            c.cq3,
            c.cq4,
            c.date,
            b.id AS idBrand,
            b.bq1,
            b.bq2,
            b.bq3,
            b.bq4,
            b.bq5,
            b.bq6,
            b.bq7,
            b.bq8,
            b.bq9,
            b.bq10,
            b.bq10_2,	
            b.bq10_3,	
            b.bq10_4,	
            b.bq11,
            b.bq12,
            b.bq12_1,
            b.bq13,
            b.bq14,	
            b.bq15,	
            b.bq16,	
            b.bq17,	
            b.bq18,
            b.bq19,
            b.bq20,
            b.bq21,
            b.bq22,
            b.bq23,
            b.bq24,
            b.bq25,
            b.bq26,
            s.id AS idSocial,
            s.sq1,
            s.sq1_1,
            s.sq2,
            s.sq3,
            s.sq4,
            s.sq5,
            s.sq6,
            s.sq7,
            s.sq8,
            s.sq9,
            s.sq10,
            s.sq11,
            s.sq12,
            s.sq13,
            s.sq14,
            s.sq15,
            s.sq16,
            s.sq17,
            s.sq18,
            s.sq20,
            s.sq22,
            s.sq23,
            s.sq24,
            s.sq25,
            w.id AS idWeb,
            w.wq1,
            w.wq1_1,
            w.wq2,
            w.wq2_1,
            w.wq2_2,
            w.wq6,
            w.wq8,
            w.wq9,
            w.wq10,
            w.wq11,
            w.wq12,
            w.wq13,
            w.wq14,
            w.wq15,
            w.wq17,
            w.wq18,
            w.wq19,
            w.wq20,
            w.wq20_1,
            w.wq21,
            w.wq23,
            w.wq24,
            w.wq25,
            w.wq26,
            w.wq27
            FROM form_client AS c
            LEFT JOIN form_brand AS b ON c.id = b.idClient
            LEFT JOIN form_social AS s ON c.id = s.idClient
            LEFT JOIN form_web AS w ON c.id = w.idClient
            WHERE c.id =:id");
        $stmt->execute(['id' => $idClient]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

        } else {
        // response output - data error
        echo json_encode(['error' => 'Invalid request type']);
    }
} else {
    // No se proporcionó un tipo de solicitud
    echo json_encode(['error' => 'Request type not specified']);
}