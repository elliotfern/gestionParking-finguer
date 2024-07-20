<?php
/*
 * BACKEND INTRANET
 * POST CREATE NEW PLANNING TASK
 */

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('HTTP/1.1 405 Method Not Allowed');
  echo json_encode(['error' => 'Method not allowed']);
  exit();
} else {
  // Verificar si se proporciona un token en el encabezado de autorización
  $headers = apache_request_headers();

  if (isset($headers['Authorization'])) {
      $token = str_replace('Bearer ', '', $headers['Authorization']);

      // Verificar el token aquí según tus requerimientos
      if (verificarToken($token)) {
        // Token válido, puedes continuar con el código para obtener los datos del usuario

          // a) NEW PLANNING
        if (isset($_GET['type']) && $_GET['type'] == 'newPlanning' ) {

            $hasError = false;
            $errors = [];

            if (empty($_POST["jobId"])) {;
              $hasError = true;
              $errors['jobId'] = 'Job is required';
            } else {
              $jobId = data_input($_POST['jobId']);
            }

            if (empty($_POST["userId"])) {;
                $hasError = true;
                $errors['userId'] = 'User is required';
              } else {
                $userId = data_input($_POST['userId']);
            }

            if (empty($_POST["hours"])) {;
                $hasError = true;
                $errors['hours'] = 'Hours is required';
              } else {
                $hours = data_input($_POST['hours']);
                $hours = intval($hours); // Convertir a entero
            }

            if (empty($_POST["name_task"])) {;
              $hasError = true;
              $errors['name_task'] = 'Task name is required';
            } else {
              $name_task = data_input($_POST['name_task']);
            }

       
            $status = 1;
            $jobName = data_input($_POST['jobName']);
            $date_created = date('Y-m-d H:i:s');
            $assigned_by = data_input($_POST['assigned_by']);


            if ($hasError === false) {
              global $conn;

              $sql = "INSERT INTO planning_tasks SET name_task=:name_task, jobId=:jobId, userId=:userId, date_created=:date_created, hours=:hours, status=:status, assigned_by=:assigned_by";
              $stmt= $conn->prepare($sql);
              $stmt->bindParam(":jobId", $jobId, PDO::PARAM_INT);
              $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
              $stmt->bindParam(":hours", $hours, PDO::PARAM_INT);
              $stmt->bindParam(":date_created", $date_created, PDO::PARAM_STR);
              $stmt->bindParam(":name_task", $name_task, PDO::PARAM_STR);
              $stmt->bindParam(":status", $status, PDO::PARAM_INT);
              $stmt->bindParam(":assigned_by", $assigned_by, PDO::PARAM_INT);

              if ($stmt->execute()) {
                // response output
                $response['status'] = 'success';
                header( "Content-Type: application/json" );
                echo json_encode($response);

                // Envío del correo electrónico
                enviarEmail($userId,$jobName,$hours, $name_task, $assigned_by);
              } else {
                // response output - data error
                $response['status'] = 'error';
                header( "Content-Type: application/json" );
                echo json_encode($response);
              }
            
            } else {
              // Se encontraron errores, enviar los errores como parte de la respuesta JSON
              header('Content-Type: application/json');
              echo json_encode(['status' => 'error', 'message' => 'Validation errors', 'errors' => $errors]);
              exit();
            } 
        
        } else {
          // response output - data error
          $response['status'] = 'error post';
          header( "Content-Type: application/json" );
          echo json_encode($response);
          exit();
        }

      } else {
      // Token no válido
      header('HTTP/1.1 403 Forbidden');
      echo json_encode(['error' => 'Invalid token']);
      exit();
      }

    } else {
    // No se proporcionó un token
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Access not allowed']);
    exit();
    }
}
function enviarEmail($userId,$job,$hours, $name_task, $assigned_by) {

  if ($userId == 1) {
    $email = 'caroline@designedly.ie';
} elseif ($userId == 2) {
    $email = 'elliot@designedly.ie';
} elseif ($userId == 3) {
    $email = 'geraldine@designedly.ie';
} elseif ($userId == 4) {
    $email = 'tina@designedly.ie';
} elseif ($userId == 5) {
    $email = 'sarah@designedly.ie';
} elseif ($userId == 6) {
    $email = 'olivia@designedly.ie';
} elseif ($userId == 7) {
    $email = 'james@designedly.ie';
} else {
    // Si el $userId no coincide con ninguno de los valores especificados, se puede asignar un valor predeterminado o manejar el error de otra manera
    $email = 'info@designedly.ie';
}

if ($assigned_by == 1) {
  $name = 'Caroline';
} elseif ($assigned_by == 2) {
  $name = 'Elliot';
} elseif ($assigned_by == 3) {
  $name = 'Geraldine';
} elseif ($assigned_by == 4) {
  $name = 'Tina';
} elseif ($assigned_by == 5) {
  $name = 'Sarah';
} elseif ($assigned_by == 6) {
  $name = 'Olivia';
} elseif ($assigned_by == 7) {
  $name = 'James';
} else {
  // Si el $userId no coincide con ninguno de los valores especificados, se puede asignar un valor predeterminado o manejar el error de otra manera
  $name = 'Designedly';
}

$to = $email; // Función para obtener el correo electrónico del usuario
$subject = 'New Task Assignment';

// email message
$message = "<html><body>";
$message .= "<p><strong>Task:</strong> $name_task</p>";
$message .= "<p><strong>You have been assigned the task for the job:</strong> $job</p>";
$message .= "<p><strong>Estimated hours:</strong> $hours</p>";
$message .= "<p><strong>Assigned by:</strong> $name</p>";
$message .= "<br>";
$message .= "<p>Regards,</p>";
$message .= "<p>Designedly</p>";
$message .= "</body></html>";

// Cabeceras adicionales
$headers = 'From: hello@designedly.ie' . "\r\n" .
           'Reply-To: hello@designedly.ie' . "\r\n" .
           'Content-Type: text/html; charset=UTF-8' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

// Envío del correo electrónico
if (mail($to, $subject, $message, $headers)) {
    // El correo se envió con éxito

} else {
    // Error al enviar el correo

}

}
?>
