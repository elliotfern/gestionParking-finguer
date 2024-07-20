<?php
/*
 * BACKEND INTRANET
 * POST CREATE NEW JOB
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

          // a) NEW JOB
        if (isset($_GET['type']) && $_GET['type'] == 'job' ) {

            $hasError = false;
            $errors = [];
 
              if (isset($_POST["project_management"])) {
                // Obtener los valores del formulario
                $project_management_values = $_POST["project_management"];
            
                // Inicializar un array para almacenar los valores únicos
                $unique_values = [];
            
                // Recorrer los valores recibidos
                foreach ($project_management_values as $value) {
                    // Agregar el valor al array solo si no existe ya en él
                    if (!in_array($value, $unique_values)) {
                        $unique_values[] = $value;
                    }
                }
            
                // Construir la cadena final en el formato deseado {6,5,2}
                $formatted_values = '{' . implode(',', $unique_values) . '}';
                
                // Asignar la cadena formateada a $poject_management
                $project_management = $formatted_values;
            } else {
                $hasError = true;
                $errors['project_management'] = 'Client name is required';
            }


            if (empty($_POST["project_name"])) {;
              $hasError = true;
              $errors['project_name'] = 'Project name is required';
            } else {
              $project_name = data_input($_POST['project_name']);
            }

            if (empty($_POST["date"])) {;
                $hasError = true;
                $errors['date'] = 'Date is required';
              } else {
                $date = data_input($_POST['date']);
            }

            if (empty($_POST["int_ext"])) {;
                $hasError = true;
                $errors['int_ext'] = 'Type of job is required';
              } else {
                $int_ext = data_input($_POST['int_ext']);
            }

            if (empty($_POST["client"])) {;
                $hasError = true;
                $errors['client'] = 'Client is required';
              } else {
                $client = data_input($_POST['client']);
            }

            if (empty($_POST["project_email"])) {;
                $project_email = NULL;
              } else {
                $project_email = data_input($_POST['project_email']);
            }

            if (empty($_POST["project_phone"])) {;
                $project_phone = NULL;
              } else {
                $project_phone = data_input($_POST['project_phone']);
            }

            if (empty($_POST["logged_by"])) {;
              $hasError = true;
            } else {
              $logged_by = data_input($_POST['logged_by']);
            }

            if (empty($_POST["job_comment"])) {;
              $job_comment = NULL;
            } else {
              $job_comment = data_input($_POST['job_comment']);
             }

             if (empty($_POST["estimated_time"])) {;
              $estimated_time = 0;
            } else {
              $estimated_time = data_input($_POST['estimated_time']);
             }

            $status = 1;
            $job_number = "DY" . data_input($_POST['job_number']);


            $userId = $_POST['userId'];
            $timestamp = date('Y-m-d H:i:s');
            $date_now = $timestamp;
            
            if ($hasError === false) {
              global $conn;

              $sql = "INSERT INTO job_list SET project_name=:project_name, status=:status, date=:date, job_number=:job_number, int_ext=:int_ext, logged_by=:logged_by, client=:client, project_email=:project_email, project_phone=:project_phone, project_management=:project_management, job_comment=:job_comment, estimated_time=:estimated_time";
              $stmt= $conn->prepare($sql);
              $stmt->bindParam(":project_name", $project_name, PDO::PARAM_STR);
              $stmt->bindParam(":status", $status, PDO::PARAM_INT);
              $stmt->bindParam(":job_number", $job_number, PDO::PARAM_STR);
              $stmt->bindParam(":int_ext", $int_ext, PDO::PARAM_INT);
              $stmt->bindParam(":logged_by", $logged_by, PDO::PARAM_INT);
              $stmt->bindParam(":client", $client, PDO::PARAM_INT);
              $stmt->bindParam(":project_email", $project_email, PDO::PARAM_STR);
              $stmt->bindParam(":project_phone", $project_phone, PDO::PARAM_STR);
              $stmt->bindParam(":project_management", $project_management, PDO::PARAM_STR);
              $stmt->bindParam(":job_comment", $job_comment, PDO::PARAM_STR);
              $stmt->bindParam(":estimated_time", $estimated_time, PDO::PARAM_STR);
              $stmt->bindParam(":date", $date, PDO::PARAM_STR);

              if ($stmt->execute()) {
                $idJob = $conn->lastInsertId();
                // response output

                global $conn;
                $sql2 = "INSERT INTO job_list_history_status SET idJob=:idJob, status=:status, user=:user, date=:date";
                $stmt2= $conn->prepare($sql2);
                $stmt2->bindParam(":idJob", $idJob, PDO::PARAM_INT);
                $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                $stmt2->bindParam(":user", $userId, PDO::PARAM_INT);
                $stmt2->bindParam(":date", $date_now, PDO::PARAM_STR);
                $stmt2->execute();

                $response['status'] = 'success';
                header( "Content-Type: application/json" );
                echo json_encode($response);
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
          // b) NEW NOTE
        } else if (isset($_GET['type']) && $_GET['type'] == 'newNote' ) {

          $hasError = false;
          $errors = [];

          if (empty($_POST["note"])) {;
            $hasError = true;
            $errors['note'] = 'Note is required';
          } else {
            $note = data_input($_POST['note']);
            $sanitized_note = sanitize_html($note);
          }


          $idJob = data_input($_POST['idJob']);
          $idUser_created = data_input($_POST['idUser']);
          $date_created = date("Y-m-d H:i:s");

          
          if ($hasError === false) {
            global $conn;

            $sql = "INSERT INTO job_list_notes SET note=:note, idJob=:idJob, date_created=:date_created, idUser_created=:idUser_created";
            $stmt= $conn->prepare($sql);
            $stmt->bindParam(":note", $sanitized_note, PDO::PARAM_STR);
            $stmt->bindParam(":idJob", $idJob, PDO::PARAM_INT);
            $stmt->bindParam(":idUser_created", $idUser_created, PDO::PARAM_INT);
            $stmt->bindParam(":date_created", $date_created, PDO::PARAM_STR);

            if ($stmt->execute()) {
              // response output
              $response['status'] = 'success';
              header( "Content-Type: application/json" );
              echo json_encode($response);
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
?>
