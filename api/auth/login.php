<?php
global $conn;

require_once(APP_ROOT . '/vendor/autoload.php');
use Dotenv\Dotenv;
use Firebase\JWT\JWT;

// Cargar variables de entorno desde .env
$dotenv = Dotenv::createImmutable(APP_ROOT . '/');
$dotenv->load();

$jwtSecret = $_ENV['TOKEN'];

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hasError = 1;

    // check its a valid email and password

    $data = array();
    $stmt = $conn->prepare(
    "SELECT u.id, u.email, u.password, u.access, u.status
    FROM user_list AS u
    WHERE u.email = :email");
    $stmt->execute(
      ['email' => $email]
    );
    if ($stmt->rowCount() === 0) {
      $_SESSION['message'] = array('type'=>'danger', 'msg'=>'Your account has not ben enabled.');
    } else {
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $hash = $row['password'];
        $id = $row['id'];
        $access = $row['access'];
        $status = $row['status'];
        if(password_verify($password, $hash) AND ($access >= 1 && $access <= 4) AND ($status == 1) ) {
          session_start();
          $_SESSION['user']['id'] = $row['id'];
          $_SESSION['user']['email'] = $row['email'];

          $key = $jwtSecret;
          $algorithm = "HS256";  // Elige el algoritmo adecuado para tu aplicación
          $payload = array(
              "user_id" =>  $row['id'],
              "email" => $row['email'],
              "kid" => "key_api" 
          );

          $headers = [
            'x-forwarded-for' => 'localhost'
          ];
        
          // Encode headers in the JWT string
          $jwt = JWT::encode($payload, $key, $algorithm);

          // Almacenar en localStorage

          // Establecer la caducidad de la cookie en 1 día (86400 segundos en un día)
          $expiration = time() + (10 * 24 * 60 * 60); // 10 días

          // Establecer la cookie 'user_id'
          $user_id = $row['id'];
          setcookie('user_id', $user_id, $expiration, '/', '', false, true); 

          // Devolver el token al cliente (puedes enviarlo en una respuesta JSON)
          // Preparar la respuesta
          $response = array(
            "token" => $jwt,
            "status" => "success"
          );

          // Establecer el encabezado como JSON
          header('Content-Type: application/json');

          // Devolver la respuesta JSON
          echo json_encode($response);
        } else {
          // response output
          $response['status'] = 'error';

          header( "Content-Type: application/json" );
          echo json_encode($response);
        }
        
      }
    }
} else {
    $response['status'] = 'error password or email';

    header( "Content-Type: application/json" );
    echo json_encode($response);
}