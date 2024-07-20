<?php
/*
 * BACKEND INTRANET
 * GET PLANNING TASKS
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
    // a) PLANNING TODAY
    // url: "/api/planning/get/?type=planningToday&user=1;
    if ($_GET['type'] == 'planningToday' && is_numeric($_GET['user'])) {
        $user = $_GET['user'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT
            CONCAT(j.job_number, ' || ', j.project_name) AS job_info,
            p.id,
            p.jobId,
            p.userId,
            u.name,
            p.hours,
            p.date
            FROM planning_tasks AS p
            LEFT JOIN job_list AS j ON j.id = p.jobId
            LEFT JOIN user_list AS u ON u.id = p.userId
            WHERE DATE(p.date) = CURDATE() AND p.userId =:user
            ORDER BY j.project_name ASC");
        $stmt->execute(['user' => $user]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }

            // Calcular el total de horas
            $totalHours = 0;
            foreach ($data as $row) {
                $totalHours += $row['hours'];
            }

            // Agregar una fila con el total de horas
            $data[] = array(
                'job_info' => 'Total Hours',
                'hours' => $totalHours
            );

            echo json_encode($data);
        }

        // b) PLANNING  DATE
        // url: "/api/planning/get/?type=planningDate&user=1&year=2024&month=05&day=10"
    } else if ($_GET['type'] == 'planningDate' && is_numeric($_GET['user']) && is_numeric($_GET['year']) && is_numeric($_GET['month']) && is_numeric($_GET['day'])) {
        $user = $_GET['user'];
        $year = $_GET['year'];
        $month = $_GET['month'];
        $day = $_GET['day'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT
            CONCAT(j.job_number, ' || ', j.project_name) AS job_info,
            p.id,
            p.jobId,
            p.userId,
            u.name,
            p.hours,
            p.date
            FROM planning_tasks AS p
            LEFT JOIN job_list AS j ON j.id = p.jobId
            LEFT JOIN user_list AS u ON u.id = p.userId
            WHERE YEAR(p.date) = :year AND MONTH(p.date) = :month AND DAY(p.date) = :day AND p.userId = :user
            ORDER BY j.project_name ASC");
        $stmt->execute([
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'user' => $user
        ]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }

            // Calcular el total de horas
            $totalHours = 0;
            foreach ($data as $row) {
                $totalHours += $row['hours'];
            }

            // Agregar una fila con el total de horas
            $data[] = array(
                'job_info' => 'Total Hours',
                'hours' => $totalHours
            );

            echo json_encode($data);
        }

        // b) PLANNING  TASKS BY EMPLOYEE
        // url: "/api/planning/get/?type=planningTasks&userId=1"
    } else if ($_GET['type'] == 'planningTasks' && is_numeric($_GET['userId'])) {
        $userId = $_GET['userId'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT
        CONCAT(j.job_number, ' || ', j.project_name) AS job_info,
        c.business_name,
        c.id AS idClient,
        p.id,
        p.name_task,
        p.status,
        p.jobId,
        p.userId,
        u.name,
        p.hours,
        p.date_created
        FROM planning_tasks AS p
        LEFT JOIN job_list AS j ON j.id = p.jobId
        LEFT JOIN user_list AS u ON u.id = p.userId
        LEFT JOIN client_list AS c on c.id = j.client
        WHERE p.userId = :user
        ORDER BY p.date_created DESC");
        $stmt->execute(['user' => $userId]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

        // c) PLANNING  TASKS BY JOB ID
        // url: "/api/planning/get/?type=planningTasks&userId=1"
    } else if ($_GET['type'] == 'taskJob' && is_numeric($_GET['jobId'])) {
        $jobId = $_GET['jobId'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT
        p.id,
        p.name_task,
        p.status,
        p.jobId,
        p.userId,
        u.name,
        u.id AS idUser,
        p.hours,
        p.date_created
        FROM planning_tasks AS p
        LEFT JOIN job_list AS j ON j.id = p.jobId
        LEFT JOIN user_list AS u ON u.id = p.userId
        WHERE p.jobId = :jobId
        ORDER BY p.date_created DESC");
        $stmt->execute(['jobId' => $jobId]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

       // c) PLANNING  TASKS ACTIVE
        // url: "/api/planning/get/?type=planningTasksActive"
    } else if ($_GET['type'] == 'planningTasksActive') {
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT
        CONCAT(j.job_number, ' || ', j.project_name) AS job_info,
        c.business_name,
        c.id AS idClient,
        p.id,
        p.name_task,
        p.status,
        p.jobId,
        p.userId,
        u.name,
        u.id AS idUser,
        p.hours,
        p.date_created
        FROM planning_tasks AS p
        LEFT JOIN job_list AS j ON j.id = p.jobId
        LEFT JOIN user_list AS u ON u.id = p.userId
         LEFT JOIN client_list AS c on c.id = j.client
        WHERE p.status = 1
        ORDER BY p.date_created DESC");
        $stmt->execute();
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
