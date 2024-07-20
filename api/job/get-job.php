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
    // a) JOB LIST
    if ($_GET['type'] == 'jobList') {
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT 
            j.id,
            j.project_name,
            j.status,
            j.date,
            j.job_number,
            j.logged_by,
            u.name,
            j.int_ext,
            j.client,
            c.client_name,
            c.business_name,
            j.project_email,
            j.project_phone,
            j.project_management,
            j.job_comment,
            j.estimated_time,
            COALESCE(SUM(t.hours), 0) AS total_task_hours
        FROM job_list AS j
        LEFT JOIN client_list AS c ON j.client = c.id
        LEFT JOIN user_list AS u ON j.logged_by = u.id
        LEFT JOIN planning_tasks AS t ON j.id = t.jobId
        WHERE j.status >= 1 AND j.status <= 5
        GROUP BY 
            j.id, 
            j.project_name, 
            j.status, 
            j.date, 
            j.job_number, 
            j.logged_by, 
            u.name, 
            j.int_ext, 
            j.client, 
            c.client_name, 
            c.business_name, 
            j.project_email, 
            j.project_phone, 
            j.project_management, 
            j.job_comment, 
            j.estimated_time
        ORDER BY j.job_number ASC;");
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

    // a) TIME AVAILABLE
    } else if ($_GET['type'] == 'jobTime' && $_GET['jobId'] == is_numeric($_GET['jobId'])) {
        $jobId = $_GET['jobId'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT 
            j.estimated_time,
            j.id,
            COALESCE(SUM(t.hours), 0) AS total_task_hours
        FROM job_list AS j
        LEFT JOIN planning_tasks AS t ON j.id = t.jobId
        WHERE j.id = :jobId
        GROUP BY j.id");
        $stmt->execute(['jobId' => $jobId]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

        
        // a) JOB LIST - only title
    } else if ($_GET['type'] == 'allJobs') {
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT 
            j.id,
            CONCAT(j.job_number, ' || ', j.project_name) AS job_info
            FROM job_list AS j
            WHERE j.status >= 1 AND status <= 5
            ORDER BY j.job_number desc");
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

        // 2) JOB LIST BY STATUS
    } else if ($_GET['type'] == 'jobs' && is_numeric($_GET['status'])) {
        $status = $_GET['status'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT 
                    j.id,
                    j.project_name,
                    j.status,
                    j.date,
                    j.job_number,
                    j.logged_by,
                    u.name,
                    j.int_ext,
                    j.client,
                    c.client_name,
                    c.business_name,
                    j.project_email,
                    j.project_phone,
                    j.project_management,
                    j.job_comment,
                    j.estimated_time
                    FROM job_list AS j
                    LEFT JOIN client_list AS c ON j.client = c.id
                    LEFT JOIN user_list AS u ON j.logged_by = u.id
                    WHERE j.status =:status
                    ORDER BY j.job_number ASC");
        $stmt->execute(['status' => $status]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }


        // 3) JOB LIST BY USER
    } else if ($_GET['type'] == 'jobUser' && is_numeric($_GET['user'])) {
        $user = $_GET['user'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT 
                j.id,
                j.project_name,
                j.status,
                j.date,
                j.job_number,
                j.logged_by,
                u.name,
                j.int_ext,
                j.client,
                c.client_name,
                c.business_name,
                j.project_email,
                j.project_phone,
                j.project_management,
                j.job_comment,
                j.estimated_time
                FROM job_list AS j
                LEFT JOIN client_list AS c ON j.client = c.id
                LEFT JOIN user_list AS u ON j.logged_by = u.id
                WHERE FIND_IN_SET(:user, REPLACE(REPLACE(project_management, '{', ''), '}', '')) > 0 AND j.status >= 1 AND j.status <= 5
                ORDER BY j.job_number ASC");
        $stmt->execute(['user' => $user]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

        // a) JOB
    } else if ($_GET['type'] == 'job' && is_numeric($_GET['job'])) {
        $id = $_GET['job'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT 
            j.id,
            j.project_name,
            j.status,
            j.date,
            j.job_number,
            j.logged_by,
            j.int_ext,
            j.client,
            j.project_email,
            j.project_phone,
            j.project_management,
            j.job_comment,
            j.estimated_time
            FROM job_list AS j
            WHERE j.id =:id");
        $stmt->execute(['id' => $id]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

        // b) SELECT JOB NUMBER
    } else if ($_GET['type'] == 'jobNumber') {
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT number FROM job_number_generator");
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            $number = $stmt->fetchColumn();

            // realizar suma +1
            $newNumber = $number + 1;

            $sql = "UPDATE job_number_generator SET number=:number";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":number", $newNumber, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode($newNumber);
            } else {
                echo json_encode(['error' => 'Failed to update job number']);
            }
        }

        // b) SELECT JOB NUMBER
    } else if ($_GET['type'] == 'jobNumberMinus') {
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT number FROM job_number_generator");
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            $number = $stmt->fetchColumn();

            // realizar suma +1
            $newNumber = $number - 1;

            $sql = "UPDATE job_number_generator SET number=:number";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":number", $newNumber, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode($newNumber);
            } else {
                echo json_encode(['error' => 'Failed to update job number']);
            }
        }

        // project information details
    } elseif (isset($_GET['jobId']) && is_numeric($_GET['jobId'])) {
        $projectId = $_GET['jobId'];
        global $conn;
        $stmt = $conn->prepare("SELECT      
                j.id,
                j.project_name,
                j.status,
                j.date,
                j.job_number,	
                j.logged_by,
                j.int_ext,
                j.client,
                j.project_email,
                j.project_phone,
                j.project_management,
                j.job_comment,
                j.estimated_time
                FROM job_list AS j
                WHERE j.id = :projectId");
        if ($stmt->execute(['projectId' => $projectId])) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($data ?: []);
        } else {
            handleSQLError($stmt);
        }

        // HISTORY JOB STATUS
    } else if (isset($_GET['type']) && $_GET['type'] == 'historyStatus' && is_numeric($_GET['historyStatus'])) {
        $id = $_GET['historyStatus'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT 
           j.id,
           j.idJob,
           j.status,
           j.user,
           j.date
            FROM job_list_history_status AS j
            WHERE j.idjob =:idjob");
        $stmt->execute(['idjob' => $id]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

        // 2) FORMS CLIENTS BY JOB
    } else if ($_GET['type'] == 'formJob' && is_numeric($_GET['formJob'])) {
        $jobId = $_GET['formJob'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT 
            c.id,
            c.date,
            b.bq1,
            s.sq1,
            w.wq1,
            c.date
            FROM form_client AS c
            LEFT JOIN form_brand AS b ON c.id = b.idClient
            LEFT JOIN form_social AS s ON c.id = s.idClient
            LEFT JOIN form_web AS w ON c.id = w.idClient
            WHERE c.jobId =:jobId
            ORDER BY c.date DESC");
        $stmt->execute(['jobId' => $jobId]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }


        // JOB NOTES
    } else if (isset($_GET['type']) && $_GET['type'] == 'jobNotes' && is_numeric($_GET['jobNotes'])) {
        $id = $_GET['jobNotes'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT    
            j.id,
            j.idJob,
            j.idUser_created,
            j.idUser_modified,
            u1.name AS nameCreated,
            u2.name AS nameModified,
            j.note,
            j.date_created,
            j.date_modified
            FROM job_list_notes AS j
            LEFT JOIN user_list AS u1 ON j.idUser_created = u1.id
            LEFT JOIN user_list AS u2 ON j.idUser_modified = u2.id
            WHERE j.idjob =:idjob
            ORDER BY j.date_created DESC");
        $stmt->execute(['idjob' => $id]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(['error' => 'No rows']);
        } else {
            while ($users = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $users;
            }
            echo json_encode($data);
        }

          // NOTE ID
    } else if (isset($_GET['type']) && $_GET['type'] == 'noteInfo' && is_numeric($_GET['noteId'])) {
        $id = $_GET['noteId'];
        global $conn;
        $data = array();
        $stmt = $conn->prepare("SELECT    
            j.id,
            j.note,
            j.idJob,
            jl.job_number,
            jl.project_name
            FROM job_list_notes AS j
            LEFT JOIN job_list AS jl ON j.idJob = jl.id
            WHERE j.id =:id");
        $stmt->execute(['id' => $id]);
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
