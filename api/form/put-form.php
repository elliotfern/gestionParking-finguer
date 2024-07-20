<?php
/*
 * BACKEND INTRANET
 * UPDATE CLIENT
 */

// Check if the request method is POST
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

          // a) DELETE CLIENT
        if (isset($_GET['type']) && $_GET['type'] == 'updateJobForm' ) {

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
          
          $id = $data['id'];

            if (empty($data["jobId"])) {;
                $jobId = NULL;
            } else {
                $jobId = data_input($data['jobId']);
            }

            if ($hasError === false) {
              global $conn;
              $sql = "UPDATE form_client SET jobId=:jobId
              WHERE id =:id";
              $stmt= $conn->prepare($sql);
              $stmt->bindParam(":jobId", $jobId, PDO::PARAM_INT);
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
