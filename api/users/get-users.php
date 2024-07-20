<?php
/*
 * BACKEND INTRANET
 * GET USERS
 */

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
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

          // a) USERS LIST ONLY ACTIVE USERS
          // URL: "/api/users/get/?type=users"
        if (isset($_GET['type']) && $_GET['type'] == 'users' ) {
            global $conn;
            $data = array();
            $stmt = $conn->prepare("SELECT u.id, u.name, u.email, u.access, u.status
            FROM user_list AS u
            WHERE u.status = 1
            ORDER BY u.name ASC");
            $stmt->execute();
            if($stmt->rowCount() === 0) echo ('No rows');
                while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                    $data[] = $users;
                }
            echo json_encode($data);

          // b) USERS LIST WITH ACTIVE AND NON ACTIVE USERS
          // URL: "/api/users/get/?type=users"
        } else if (isset($_GET['type']) && $_GET['type'] == 'usersAll' ) {
          global $conn;
          $data = array();
          $stmt = $conn->prepare("SELECT u.id, u.name, u.email, u.access, u.status
          FROM user_list AS u
          WHERE u.status = 1 OR u.status = 2
          ORDER BY u.name ASC");
          $stmt->execute();
          if($stmt->rowCount() === 0) echo ('No rows');
              while($users = $stmt->fetch(PDO::FETCH_ASSOC) ){
                  $data[] = $users;
              }
          echo json_encode($data);

        // b) USER INFO
          // URL: "/api/users/get/type=user&userId=1"
        } else if (isset($_GET['type']) && $_GET['type'] == 'user' && is_numeric($_GET['id'])) {
            $userId = $_GET['id'];
            global $conn;
            $data = array();
            $stmt = $conn->prepare("SELECT u.id, u.name, u.email, u.access
            FROM user_list AS u
            WHERE u.id =:id");
           if ($stmt->execute(['id' => $userId])) {
              $data = $stmt->fetch(PDO::FETCH_ASSOC); // Usamos fetch en lugar de fetchAll
              echo json_encode($data ?: []); // Si no hay resultados, devolvemos un array vacío
          } else {
              handleSQLError($stmt);
          }
        } else {
          // response output - data error
          $response['status'] = 'error';
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