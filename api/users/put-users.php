<?php
/*
 * BACKEND INTRANET
 * UPDATE USER
 */

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Verificar si se proporciona un token en el encabezado de autorización
$headers = apache_request_headers();

if (isset($headers['Authorization'])) {
    $token = str_replace('Bearer ', '', $headers['Authorization']);

    // Verificar el token aquí según tus requerimientos
    if (verificarToken($token)) {
        // Token válido, puedes continuar con el código para obtener los datos del usuario

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

        // Inicializar variables
        $response = [];
        $hasError = false;
        $errors = [];

        // Identificar el tipo de solicitud
        if (isset($_GET['type'])) {
            if ($_GET['type'] === 'updatePassword') {
                // Validar datos requeridos
                if (empty($data['password'])) {
                    $hasError = true;
                    $errors['password'] = 'Password is required';
                } else {
                    // Procesar y hashear la contraseña
                    $password = data_input($data['password']);
                    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                }

                // Actualizar la contraseña en la base de datos
                if (!$hasError) {
                    global $conn;
                    $sql = "UPDATE user_list SET password = :password WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":password", $hashPassword, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $data['id'], PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        // Respuesta exitosa
                        $response['status'] = 'success';
                    } else {
                        // Error al actualizar en la base de datos
                        $response['status'] = 'error db';
                    }
                }

            } else if ($_GET['type'] === 'updateStatus') {
                // Validar datos requeridos
                if (empty($data['status'])) {
                  $hasError = true;
                  $errors['status'] = 'Status is required';
                } else {
                    $status = data_input($data['status']);
                }

                if (empty($data['userId'])) {
                  $hasError = true;
                  $errors['userId'] = 'userId is required';
                } else {
                    $userId = data_input($data['userId']);
                }


                // Actualizar la contraseña en la base de datos
                if (!$hasError) {
                    global $conn;
                    $sql = "UPDATE user_list SET status = :status WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":status", $status, PDO::PARAM_INT);
                    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        // Respuesta exitosa
                        $response['status'] = 'success';
                    } else {
                        // Error al actualizar en la base de datos
                        $response['status'] = 'error';
                    }
                }

            } else {
                // Tipo de solicitud no reconocido
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Invalid request type']);
                exit();
            }

            // Enviar respuesta JSON al cliente
            header('Content-Type: application/json');
            echo json_encode($response);

        } else {
            // No se proporcionó el tipo de solicitud
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Missing request type']);
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

?>