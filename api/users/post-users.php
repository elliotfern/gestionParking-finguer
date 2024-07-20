<?php
/*
 * BACKEND INTRANET
 * POST CREATE NEW USER
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

          // a) NEW USER
        if (isset($_GET['type']) && $_GET['type'] == 'user' ) {

            $hasError = false;
            $errors = []; // Array para almacenar los errores encontrados
 
            if (empty($_POST["email"])) {;
              $hasError = true;
              $errors['email'] = 'Email is required';
            } else {
              $email = data_input($_POST['email']);
              // Validar el formato del correo electrónico
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $hasError = true;
                  $errors['email'] = 'Correct email format is required';
              }
          }

            if (empty($_POST["name"])) {;
                $hasError = true;
                $errors['name'] = 'Name is required';
              } else {
                $name = data_input($_POST['name']);
            }

            if (empty($_POST["password"])) {;
                $hasError = true;
                $errors['password'] = 'Password is required';
              } else {
                $password = data_input($_POST['password']);
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($_POST["access"] === "0" ) {
                $hasError = true;
                $errors['access'] = 'Type of user is required';
            } else {
                $access = data_input($_POST['access']);
            }
            
            if ($hasError === false) {
              global $conn;
              $sql = "INSERT INTO user_list SET email=:email, name=:name, password=:password, access=:access";
              $stmt= $conn->prepare($sql);
              $stmt->bindParam(":email", $email, PDO::PARAM_STR);
              $stmt->bindParam(":name", $name, PDO::PARAM_STR);
              $stmt->bindParam(":password", $hashPassword, PDO::PARAM_STR);
              $stmt->bindParam(":access", $access, PDO::PARAM_INT);
             
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
              // response output - data error
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