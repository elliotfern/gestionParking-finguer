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
} else {
  // Verificar si se proporciona un token en el encabezado de autorización
  $headers = apache_request_headers();

  if (isset($headers['Authorization'])) {
      $token = str_replace('Bearer ', '', $headers['Authorization']);

      // Verificar el token aquí según tus requerimientos
      if (verificarToken($token)) {
        // Token válido, puedes continuar con el código para obtener los datos del usuario

          // a) UPDATE JOB STATUS
        if (isset($_GET['type']) && $_GET['type'] == 'statusTask' && is_numeric($_GET['taskId']) ) {

             // Obtener el cuerpo de la solicitud PUT
                $input_data = file_get_contents("php://input");

                // Decodificar los datos JSON
                $data = json_decode($input_data, true);

                // Verificar si se recibieron datos
                if ($data === null) {
                    // Error al decodificar JSON
                    header('HTTP/1.1 400 Bad Request');
                    echo json_encode(['error' => 'Error decoding JSON data']);
                    exit();
                }


            $hasError = false;
            $errors = [];
            
            $status_net = $data['status'];

            if ($status_net == 1 ) {
                $status = 2;
            } else if ($status_net == 2) {
                $status = 1;
            }

            $id = $data['id'];


            if ($hasError === false) {
              global $conn;
              $sql = "UPDATE planning_tasks SET status=:status WHERE id =:id";
              $stmt= $conn->prepare($sql);
              $stmt->bindParam(":status", $status, PDO::PARAM_INT);
              $stmt->bindParam(":id", $id, PDO::PARAM_INT);

              if ($stmt->execute()) {
                // response output

                $response['status'] = 'success';
                header( "Content-Type: application/json" );
                echo json_encode($response);

              } else {
                // response output - data error
                $response['status'] = 'error db';
                header( "Content-Type: application/json" );
                echo json_encode($response);
              }
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