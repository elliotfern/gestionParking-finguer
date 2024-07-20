<?php
/*
 * BACKEND INTRANET
 * POST CREATE NEW CLIENT
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

          // a) NEW CLIENT
        if (isset($_GET['type']) && $_GET['type'] == 'client' ) {

            $hasError = false;
            $errors = [];
 
            if (empty($_POST["client_name"])) {;
              $hasError = true;
              $errors['client_name'] = 'Client name is required';
            } else {
              $client_name = data_input($_POST['client_name']);
            }

            if (empty($_POST["business_name"])) {;
                $hasError = true;
                $errors['business_name'] = 'Business name is required';
              } else {
                $business_name = data_input($_POST['business_name']);
            }

            if (empty($_POST["business_address"])) {;
                $business_address = NULL;
              } else {
                $business_address = data_input($_POST['business_address']);
            }

            if (empty($_POST["email"])) {;
                $hasError = true;
                $errors['email'] = 'Correct email format is required';
              } else {
                $email = data_input($_POST['email']);
                // Validar el formato del correo electrónico
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $hasError = true;
                    $errors['email'] = 'Correct email format is required';
                }
            }

            if (empty($_POST["phone"])) {;
                $hasError = true;
                $errors['phone'] = 'Phone is required';
              } else {
                $phone = data_input($_POST['phone']);
            }

            if (empty($_POST["vat_number"])) {;
                $vat_number = NULL;
              } else {
                $vat_number = data_input($_POST['vat_number']);
            }

            if (empty($_POST["po_number"])) {;
                $po_number = NULL;
              } else {
                $po_number = data_input($_POST['po_number']);
            }

            $timestamp = date('Y-m-d');
            $date_created = $timestamp;
            
            if ($hasError === false) {
              global $conn;
              $sql = "INSERT INTO client_list SET client_name=:client_name, business_name=:business_name, business_address=:business_address, email=:email, phone=:phone, vat_number=:vat_number, po_number=:po_number, date_created=:date_created";
              $stmt= $conn->prepare($sql);
              $stmt->bindParam(":client_name", $client_name, PDO::PARAM_STR);
              $stmt->bindParam(":business_name", $business_name, PDO::PARAM_STR);
              $stmt->bindParam(":business_address", $business_address, PDO::PARAM_STR);
              $stmt->bindParam(":email", $email, PDO::PARAM_STR);
              $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
              $stmt->bindParam(":vat_number", $vat_number, PDO::PARAM_STR);
              $stmt->bindParam(":po_number", $po_number, PDO::PARAM_STR);
              $stmt->bindParam(":date_created", $date_created, PDO::PARAM_STR);

              if ($stmt->execute()) {
                  // Obtener el ID del último registro creado
                  $newClientId = $conn->lastInsertId();

                  // Devolver la respuesta con el ID
                  $response = array(
                      "status" => 'success',
                      "clientId" => $newClientId
                  );
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
