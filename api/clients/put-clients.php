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
        if (isset($_GET['type']) && $_GET['type'] == 'updateClient' ) {

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

            if (empty($data["client_name"])) {;
                $hasError = true;
                $errors['client_name'] = 'Client name is required';
            } else {
                $client_name = data_input($data['client_name']);
            }

            if (empty($data["business_name"])) {;
                $business_name = NULL;
            } else {
                $business_name = data_input($data['business_name']);
            }

            if (empty($data["business_address"])) {;
                $business_address = NULL;
            } else {
                $business_address = data_input($data['business_address']);
            }

            if (empty($data["billing_address"])) {;
                $billing_address = NULL;
            } else {
                $billing_address = data_input($data['billing_address']);
            }

            if (empty($data["email"])) {;
                $hasError = true;
                $errors['email'] = 'Email is required';
            } else {
                $email = data_input($data['email']);
            }

            if (empty($data["phone"])) {;
                $hasError = true;
                $errors['phone'] = 'Phone is required';
            } else {
                $phone = data_input($data['phone']);
            }

            if (empty($data["mobile"])) {;
                $mobile = NULL;
            } else {
                $mobile = data_input($data['mobile']);
            }

            if (empty($data["vat_number"])) {;
                $vat_number = NULL;
            } else {
                $vat_number = data_input($data['vat_number']);
            }

            if (empty($data["po_number"])) {;
                $po_number = NULL;
            } else {
                $po_number = data_input($data['po_number']);
            }

            if ($hasError === false) {
              global $conn;
              $sql = "UPDATE client_list SET client_name=:client_name, business_name=:business_name, business_address=:business_address, billing_address=:billing_address, email=:email, phone=:phone, mobile=:mobile, vat_number=:vat_number, po_number=:po_number
              WHERE id =:id";
              $stmt= $conn->prepare($sql);
              $stmt->bindParam(":client_name", $client_name, PDO::PARAM_STR);
              $stmt->bindParam(":business_name", $business_name, PDO::PARAM_STR);
              $stmt->bindParam(":business_address", $business_address, PDO::PARAM_STR);
              $stmt->bindParam(":billing_address", $billing_address, PDO::PARAM_STR);
              $stmt->bindParam(":email", $email, PDO::PARAM_STR);
              $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
              $stmt->bindParam(":mobile", $mobile, PDO::PARAM_STR);
              $stmt->bindParam(":vat_number", $vat_number, PDO::PARAM_STR);
              $stmt->bindParam(":po_number", $po_number, PDO::PARAM_STR);
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
