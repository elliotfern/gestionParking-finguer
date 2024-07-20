<?php
/*
 * BACKEND INTRANET
 * POST CREATE NEW FORM
 */

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('HTTP/1.1 405 Method Not Allowed');
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Method not allowed']);
  exit();
} else {

        // a) NEW CLIENT FORM
        if (isset($_GET['type']) && $_GET['type'] == 'newClientForm' ) {

            $hasError = false;
            $errors = [];

            if (empty($_POST["client_name"])) {
              $hasError = true;
              $errors['client_name'] = 'Client name is required';
            } else {
              $client_name = data_input($_POST['client_name']);
            }

            if (empty($_POST["company_name"])) {
                $hasError = true;
                $errors['company_name'] = 'Company name is required';
            } else {
                $company_name = data_input($_POST['company_name']);
            }

            if (empty($_POST["address"])) {
                $hasError = true;
                $errors['address'] = 'Address is required';
            } else {
                $address = data_input($_POST['address']);
            }

            if (empty($_POST["email"])) {
                $hasError = true;
                $errors['email'] = 'Email is required';
            } else {
                $email = data_input($_POST['email']);
            }

            if (empty($_POST["phone"])) {
                $hasError = true;
                $errors['phone'] = 'Phone number is required';
            } else {
                $phone = data_input($_POST['phone']);
            }

            if (empty($_POST["vat_number"])) {
                $vat_number = NULL;
            } else {
                $vat_number = data_input($_POST['vat_number']);
            }

            if (empty($_POST["po_number"])) {
                $po_number = NULL;
            } else {
                $po_number = data_input($_POST['po_number']);
            }

            if (empty($_POST["cq1"])) {
              $cq1 = NULL;
            } else {
                $cq1 = data_input($_POST['cq1']);
            }

            if (empty($_POST["cq2"])) {
              $cq2 = NULL;
            } else {
                $cq2 = data_input($_POST['cq2']);
            }

            if (empty($_POST["cq2_1"])) {
              $cq2_1 = NULL;
            } else {
                $cq2_1 = data_input($_POST['cq2_1']);
            }
            
            if (empty($_POST["cq3"])) {
              $cq3 = NULL;
            } else {
                $cq3 = data_input($_POST['cq3']);
            }

            if (empty($_POST["cq4"])) {
              $cq4 = NULL;
            } else {
                $cq4 = data_input($_POST['cq4']);
            }

            $date = date('Y-m-d H:i:s');

            if ($hasError === false) {
              global $conn;
              $sql = "INSERT INTO form_client (client_name, company_name, address, email, phone, vat_number, po_number, date, cq1, cq2, cq2_1, cq3, cq4) 
                      VALUES (:client_name, :company_name, :address, :email, :phone, :vat_number, :po_number, :date, :cq1, :cq2, :cq2_1, :cq3, :cq4)";
              $stmt = $conn->prepare($sql);
              $stmt->bindParam(":client_name", $client_name, PDO::PARAM_STR);
              $stmt->bindParam(":company_name", $company_name, PDO::PARAM_STR);
              $stmt->bindParam(":address", $address, PDO::PARAM_STR);
              $stmt->bindParam(":email", $email, PDO::PARAM_STR);
              $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
              $stmt->bindParam(":vat_number", $vat_number, PDO::PARAM_STR);
              $stmt->bindParam(":po_number", $po_number, PDO::PARAM_STR);
              $stmt->bindParam(":date", $date, PDO::PARAM_STR);
              $stmt->bindParam(":cq1", $cq1, PDO::PARAM_STR);
              $stmt->bindParam(":cq2", $cq2, PDO::PARAM_INT);
              $stmt->bindParam(":cq2_1", $cq2_1, PDO::PARAM_STR);
              $stmt->bindParam(":cq3", $cq3, PDO::PARAM_STR);
              $stmt->bindParam(":cq4", $cq4, PDO::PARAM_STR);

              if ($stmt->execute()) {
                // response output
                // Obtener el ID del cliente recién creado
                $newClientId = $conn->lastInsertId();

                // Devolver la respuesta con el ID
                $response = array(
                    "status" => 'success',
                    "clientId" => $newClientId
                );
                header('Content-Type: application/json');
                echo json_encode($response);
              } else {
                // response output - data error
                $response['status'] = 'error';
                header('Content-Type: application/json');
                echo json_encode($response);
              }
            } else {
              // Se encontraron errores, enviar los errores como parte de la respuesta JSON
              header('Content-Type: application/json');
              echo json_encode(['status' => 'error', 'message' => 'Validation errors', 'errors' => $errors]);
            }

        } else if (isset($_GET['type']) && $_GET['type'] == 'newForm' ) {

            $hasError = false;
            $errors = [];

            if (empty($_POST["idClient"])) {
                $idClient = NULL;
            } else {
                $idClient = data_input($_POST['idClient']);
            }

            // BRAND QUESTIONNAIRE

            if (empty($_POST["bq1"])) {
                $bq1 = NULL;
            } else {
                $bq1 = data_input($_POST['bq1']);
            }

            if (empty($_POST["bq2"])) {
                $bq2 = NULL;
            } else {
                $bq2 = data_input($_POST['bq2']);
            }

            if (empty($_POST["bq3"])) {
                $bq3 = NULL;
            } else {
                $bq3 = data_input($_POST['bq3']);
            }

            if (empty($_POST["bq4"])) {
                $bq4 = NULL;
            } else {
                $bq4 = data_input($_POST['bq4']);
            }

            if (empty($_POST["bq5"])) {
                $bq5 = NULL;
            } else {
                $bq5 = data_input($_POST['bq5']);
            }

            if (empty($_POST["bq6"])) {
                $bq6 = NULL;
            } else {
                $bq6 = data_input($_POST['bq6']);
            }

            if (empty($_POST["bq7"])) {
                $bq7 = NULL;
            } else {
                $bq7 = data_input($_POST['bq7']);
            }

            if (empty($_POST["bq8"])) {
                $bq8 = NULL;
            } else {
                $bq8 = data_input($_POST['bq8']);
            }

            if (empty($_POST["bq9"])) {
                $bq9 = NULL;
            } else {
                $bq9 = data_input($_POST['bq9']);
            }

            if (empty($_POST["bq10"])) {
                $bq10 = NULL;
            } else {
                $bq10 = data_input($_POST['bq10']);
            }

            if (empty($_POST["bq10_2"])) {
              $bq10_2 = NULL;
            } else {
                $bq10_2 = data_input($_POST['bq10_2']);
            }

            if (empty($_POST["bq10_3"])) {
              $bq10_3 = NULL;
            } else {
                $bq10_3 = data_input($_POST['bq10_3']);
            }

            if (empty($_POST["bq10_4"])) {
              $bq10_4 = NULL;
            } else {
                $bq10_4 = data_input($_POST['bq10_4']);
            }

            if (empty($_POST["bq11"])) {
                $bq11 = NULL;
            } else {
                $bq11 = data_input($_POST['bq11']);
            }

            if (empty($_POST["bq12"])) {
                $bq12 = NULL;
            } else {
                $bq12 = data_input($_POST['bq12']);
            }

            if (empty($_POST["bq12_1"])) {
              $bq12_1 = NULL;
          } else {
              $bq12_1 = data_input($_POST['bq12_1']);
          }

           // Verificar si la clave "bq13" está presente en el formulario
            if (isset($_POST["bq13"])) {
              // Obtener los valores del formulario
              $bq13_values = $_POST["bq13"];

              // Inicializar un array para almacenar los valores únicos
              $unique_values13 = [];

              // Recorrer los valores recibidos
              foreach ($bq13_values as $value13) {
                  // Agregar el valor al array solo si no existe ya en él
                  if (!in_array($value13, $unique_values13)) {
                      $unique_values13[] = $value13;
                  }
              }

              // Convertir el array de valores únicos al formato {3,4,17}
              $bq13_string = '{' . implode(',', $unique_values13) . '}';
            }

            if (empty($_POST["bq14"])) {
              $bq14 = NULL;
            } else {
                $bq14 = data_input($_POST["bq14"]);
            }

            if (empty($_POST["bq15"])) {
              $bq15 = NULL;
            } else {
                $bq15 = data_input($_POST["bq15"]);
            }

            if (empty($_POST["bq16"])) {
              $bq16 = NULL;
            } else {
                $bq16 = data_input($_POST["bq16"]);
            }

            if (empty($_POST["bq17"])) {
              $bq17 = NULL;
            } else {
                $bq17 = data_input($_POST["bq17"]);
            }

            if (empty($_POST["bq18"])) {
              $bq18 = NULL;
            } else {
                $bq18 = data_input($_POST["bq18"]);
            }

            // Question 13 is an array of numbers
            if (isset($_POST["bq19"])) {
              // Obtener los valores del formulario
              $bq19_values = $_POST["bq19"];
          
              // Inicializar un array para almacenar los valores únicos
              $unique_values33 = [];
          
              // Recorrer los valores recibidos
              foreach ($bq19_values as $value33) {
                  // Agregar el valor al array solo si no existe ya en él
                  if (!in_array($value33, $unique_values33)) {
                      $unique_values33[] = $value33;
                  }
              }
          
              // Construir la cadena final en el formato deseado {6,5,2}
              $formatted_values33 = '{' . implode(',', $unique_values33) . '}';
              
              // Asignar la cadena formateada a $b13
              $bq19 = $formatted_values33;
            } else {
              $bq19 = NULL;
            }

            if (empty($_POST["bq20"])) {
              $bq20= NULL;
            } else {
                $bq20 = data_input($_POST["bq20"]);
            }

            if (empty($_POST["bq21"])) {
              $bq21 = NULL;
            } else {
                $bq21 = data_input($_POST["bq21"]);
            }

            if (empty($_POST["bq22"])) {
              $bq22 = NULL;
            } else {
                $bq22 = data_input($_POST["bq22"]);
            }

            if (empty($_POST["bq23"])) {
              $bq23 = NULL;
            } else {
                $bq23 = data_input($_POST['bq23']);
            }

            if (empty($_POST["bq24"])) {
              $bq24 = NULL;
            } else {
                $bq24 = data_input($_POST['bq24']);
            }

            if (empty($_POST["bq25"])) {
              $bq25 = NULL;
            } else {
                $bq25 = data_input($_POST['bq25']);
            }

            if (empty($_POST["bq26"])) {
              $bq26 = NULL;
            } else {
                $bq26 = data_input($_POST['bq26']);
            }


            // WEBSITE QUESTIONNAIRE
            if (empty($_POST["wq1"])) {
              $wq1 = NULL;
            } else {
                $wq1 = data_input($_POST['wq1']);
            }

            if (empty($_POST["wq1_1"])) {
              $wq1_1 = NULL;
            } else {
                $wq1_1 = data_input($_POST['wq1_1']);
            }

            if (empty($_POST["wq2"])) {
              $wq2 = NULL;
            } else {
                $wq2 = data_input($_POST['wq2']);
            }

            if (empty($_POST["wq2_1"])) {
              $wq2_1 = NULL;
            } else {
                $wq2_1 = data_input($_POST['wq2_1']);
            }

            if (empty($_POST["wq2_2"])) {
              $wq2_2 = NULL;
            } else {
                $wq2_2 = data_input($_POST['wq2_2']);
            }

            if (empty($_POST["wq6"])) {
              $wq6 = NULL;
            } else {
                $wq6 = data_input($_POST['wq6']);
            }


            if (empty($_POST["wq8"])) {
              $wq8 = NULL;
            } else {
                $wq8 = data_input($_POST['wq8']);
            }

            if (empty($_POST["wq9"])) {
              $wq9 = NULL;
            } else {
                $wq9 = data_input($_POST['wq9']);
            }

            if (empty($_POST["wq10"])) {
              $wq10 = NULL;
            } else {
                $wq10 = data_input($_POST['wq10']);
            }

            if (empty($_POST["wq11"])) {
              $wq11 = NULL;
            } else {
                $wq11 = data_input($_POST['wq11']);
            }

            if (empty($_POST["wq12"])) {
              $wq12 = NULL;
            } else {
                $wq12 = data_input($_POST['wq12']);
            }

            if (empty($_POST["wq13"])) {
              $wq13 = NULL;
            } else {
                $wq13 = data_input($_POST['wq13']);
            }

            if (empty($_POST["wq14"])) {
              $wq14 = NULL;
            } else {
                $wq14 = data_input($_POST['wq14']);
            }

            if (empty($_POST["wq15"])) {
              $wq15 = NULL;
            } else {
                $wq15 = data_input($_POST['wq15']);
            }

            if (empty($_POST["wq17"])) {
              $wq17 = NULL;
            } else {
                $wq17 = data_input($_POST['wq17']);
            }

            if (empty($_POST["wq18"])) {
              $wq18 = NULL;
            } else {
                $wq18 = data_input($_POST['wq18']);
            }

            if (isset($_POST["wq19"])) {
              // Obtener los valores del formulario
              $wq19_values = $_POST["wq19"];
          
              // Inicializar un array para almacenar los valores únicos
              $unique_values2 = [];
          
              // Recorrer los valores recibidos
              foreach ($wq19_values as $value2) {
                  // Agregar el valor al array solo si no existe ya en él
                  if (!in_array($value2, $unique_values2)) {
                      $unique_values2[] = $value2;
                  }
              }
          
              // Construir la cadena final en el formato deseado {6,5,2}
              $formatted_values2 = '{' . implode(',', $unique_values2) . '}';
              
              // Asignar la cadena formateada a $poject_management
              $wq19 = $formatted_values2;
              } else {
                  //nothing
              }

              if (empty($_POST["wq20"])) {
                $wq20 = NULL;
              } else {
                  $wq20 = data_input($_POST['wq20']);
              }

              if (empty($_POST["wq20_1"])) {
                $wq20_1 = NULL;
              } else {
                  $wq20_1 = data_input($_POST['wq20_1']);
              }

              if (empty($_POST["wq21"])) {
                $wq21 = NULL;
              } else {
                  $wq21 = data_input($_POST['wq21']);
              }

              if (empty($_POST["wq23"])) {
                $wq23 = NULL;
              } else {
                  $wq23 = data_input($_POST['wq23']);
              }

              if (empty($_POST["wq24"])) {
                $wq24 = NULL;
              } else {
                  $wq24 = data_input($_POST['wq24']);
              }

              if (empty($_POST["wq25"])) {
                $wq25 = NULL;
              } else {
                  $wq25 = data_input($_POST['wq25']);
              }

              if (empty($_POST["wq26"])) {
                $wq26 = NULL;
              } else {
                  $wq26 = data_input($_POST['wq26']);
              }

              if (empty($_POST["wq27"])) {
                  $wq27 = NULL;
                } else {
                    $wq27 = data_input($_POST['wq27']);
              }

                // SOCIAL MEDIA QUESTIONNAIRE
                if (empty($_POST["sq1"])) {
                  $sq1 = NULL;
                } else {
                    $sq1 = data_input($_POST['sq1']);
                }

                if (empty($_POST["sq1_1"])) {
                  $sq1_1 = NULL;
                } else {
                    $sq1_1 = data_input($_POST['sq1_1']);
                }

                if (empty($_POST["sq2"])) {
                  $sq2 = NULL;
                } else {
                    $sq2 = data_input($_POST['sq2']);
                }

                if (empty($_POST["sq3"])) {
                  $sq3 = NULL;
                } else {
                    $sq3 = data_input($_POST['sq3']);
                }

                if (empty($_POST["sq4"])) {
                  $sq4 = NULL;
                } else {
                    $sq4 = data_input($_POST['sq4']);
                }

                if (empty($_POST["sq5"])) {
                  $sq5 = NULL;
                } else {
                    $sq5 = data_input($_POST['sq5']);
                }

                if (empty($_POST["sq6"])) {
                  $sq6 = NULL;
                } else {
                    $sq6 = data_input($_POST['sq6']);
                }

                if (empty($_POST["sq7"])) {
                  $sq7 = NULL;
                } else {
                    $sq7 = data_input($_POST['sq7']);
                }

                if (empty($_POST["sq8"])) {
                  $sq8 = NULL;
                } else {
                    $sq8 = data_input($_POST['sq8']);
                }

                if (empty($_POST["sq9"])) {
                  $sq9 = NULL;
                } else {
                    $sq9 = data_input($_POST['sq9']);
                }

                if (empty($_POST["sq10"])) {
                  $sq10 = NULL;
                } else {
                    $sq10 = data_input($_POST['sq10']);
                }

                if (empty($_POST["sq11"])) {
                  $sq11 = NULL;
                } else {
                    $sq11 = data_input($_POST['sq11']);
                }

                if (empty($_POST["sq12"])) {
                  $sq12 = NULL;
                } else {
                    $sq12 = data_input($_POST['sq12']);
                }

                if (empty($_POST["sq13"])) {
                  $sq13 = NULL;
                } else {
                    $sq13 = data_input($_POST['sq13']);
                }

                if (empty($_POST["sq14"])) {
                  $sq14 = NULL;
                } else {
                    $sq14 = data_input($_POST['sq14']);
                }

                if (empty($_POST["sq15"])) {
                  $sq15 = NULL;
                } else {
                    $sq15 = data_input($_POST['sq15']);
                }

                if (empty($_POST["sq16"])) {
                  $sq16 = NULL;
                } else {
                    $sq16 = data_input($_POST['sq16']);
                }

                if (empty($_POST["sq17"])) {
                  $sq17 = NULL;
                } else {
                    $sq17 = data_input($_POST['sq17']);
                }

                if (empty($_POST["sq18"])) {
                  $sq18 = NULL;
                } else {
                    $sq18 = data_input($_POST['sq18']);
                }

                if (empty($_POST["sq20"])) {
                  $sq20 = NULL;
                } else {
                    $sq20 = data_input($_POST['sq20']);
                }

                if (empty($_POST["sq22"])) {
                  $sq22 = NULL;
                } else {
                    $sq22 = data_input($_POST['sq22']);
                }

                if (empty($_POST["sq23"])) {
                  $sq23 = NULL;
                } else {
                    $sq23 = data_input($_POST['sq23']);
                }

                if (empty($_POST["sq24"])) {
                  $sq24 = NULL;
                } else {
                    $sq24 = data_input($_POST['sq24']);
                }

                if (empty($_POST["sq25"])) {
                  $sq25 = NULL;
                } else {
                    $sq25 = data_input($_POST['sq25']);
                }

            if ($hasError === false) {
              global $conn;

              $sql = "INSERT INTO form_brand (idClient, bq1, bq2, bq3, bq4, bq5, bq6, bq7, bq8, bq9, bq10, bq10_2, bq10_3, bq10_4, bq11, bq12, bq12_1, bq13, bq14, bq15, bq16, bq17, bq18, bq19, bq20, bq21, bq22, bq23, bq24, bq25, bq26) 
                      VALUES (:idClient, :bq1, :bq2, :bq3, :bq4, :bq5, :bq6, :bq7, :bq8, :bq9, :bq10, :bq10_2, :bq10_3, :bq10_4, :bq11, :bq12, :bq12_1, :bq13, :bq14, :bq15, :bq16, :bq17, :bq18, :bq19,:bq20, :bq21, :bq22, :bq23, :bq24, :bq25, :bq26)";
              $stmt = $conn->prepare($sql);
              $stmt->bindParam(":idClient", $idClient, PDO::PARAM_INT);
              $stmt->bindParam(":bq1", $bq1, PDO::PARAM_STR);
              $stmt->bindParam(":bq2", $bq2, PDO::PARAM_STR);
              $stmt->bindParam(":bq3", $bq3, PDO::PARAM_STR);
              $stmt->bindParam(":bq4", $bq4, PDO::PARAM_STR);
              $stmt->bindParam(":bq5", $bq5, PDO::PARAM_STR);
              $stmt->bindParam(":bq6", $bq6, PDO::PARAM_STR);
              $stmt->bindParam(":bq7", $bq7, PDO::PARAM_STR);
              $stmt->bindParam(":bq8", $bq8, PDO::PARAM_STR);
              $stmt->bindParam(":bq9", $bq9, PDO::PARAM_STR);
              $stmt->bindParam(":bq10", $bq10, PDO::PARAM_INT);
              $stmt->bindParam(":bq10_2", $bq10_2, PDO::PARAM_STR);
              $stmt->bindParam(":bq10_3", $bq10_3, PDO::PARAM_STR);
              $stmt->bindParam(":bq10_4", $bq10_4, PDO::PARAM_STR);
              $stmt->bindParam(":bq11", $bq11, PDO::PARAM_STR);
              $stmt->bindParam(":bq12", $bq12, PDO::PARAM_INT);
              $stmt->bindParam(":bq12_1", $bq12_1, PDO::PARAM_STR);
              $stmt->bindParam(":bq13", $bq13_string, PDO::PARAM_STR);
              $stmt->bindParam(":bq14", $bq14, PDO::PARAM_INT);
              $stmt->bindParam(":bq15", $bq15, PDO::PARAM_STR);
              $stmt->bindParam(":bq16", $bq16, PDO::PARAM_STR);
              $stmt->bindParam(":bq17", $bq17, PDO::PARAM_STR);
              $stmt->bindParam(":bq18", $bq18, PDO::PARAM_STR);
              $stmt->bindParam(":bq19", $bq19, PDO::PARAM_STR);
              $stmt->bindParam(":bq20", $bq20, PDO::PARAM_STR);
              $stmt->bindParam(":bq21", $bq21, PDO::PARAM_STR);
              $stmt->bindParam(":bq22", $bq22, PDO::PARAM_STR);
              $stmt->bindParam(":bq23", $bq23, PDO::PARAM_INT);
              $stmt->bindParam(":bq24", $bq24, PDO::PARAM_STR);
              $stmt->bindParam(":bq25", $bq25, PDO::PARAM_INT);
              $stmt->bindParam(":bq26", $bq26, PDO::PARAM_STR);

              $stmt->execute();
                // La primera consulta fue exitosa

                $sql2 = "INSERT INTO form_web (idClient, wq1, wq1_1, wq2, wq2_1, wq2_2, wq6, wq8, wq9, wq10, wq11, wq12, wq13, wq14, wq15, wq17, wq18, wq19, wq20, wq20_1, wq21, wq23, wq24, wq25, wq26, wq27) 
                         VALUES (:idClient, :wq1, :wq1_1, :wq2, :wq2_1, :wq2_2, :wq6, :wq8, :wq9, :wq10, :wq11, :wq12, :wq13, :wq14, :wq15, :wq17, :wq18, :wq19, :wq20, :wq20_1, :wq21, :wq23, :wq24, :wq25, :wq26, :wq27)";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bindParam(":idClient", $idClient, PDO::PARAM_INT);
                $stmt2->bindParam(":wq1", $wq1, PDO::PARAM_INT);
                $stmt2->bindParam(":wq1_1", $wq1_1, PDO::PARAM_INT);
                $stmt2->bindParam(":wq2", $wq2, PDO::PARAM_INT);
                $stmt2->bindParam(":wq2_1", $wq2_1, PDO::PARAM_STR);
                $stmt2->bindParam(":wq2_2", $wq2_2, PDO::PARAM_STR);
                $stmt2->bindParam(":wq6", $wq6, PDO::PARAM_STR);
                $stmt2->bindParam(":wq8", $wq8, PDO::PARAM_STR);
                $stmt2->bindParam(":wq9", $wq9, PDO::PARAM_STR);
                $stmt2->bindParam(":wq10", $wq10, PDO::PARAM_STR);
                $stmt2->bindParam(":wq11", $wq11, PDO::PARAM_STR);
                $stmt2->bindParam(":wq12", $wq12, PDO::PARAM_STR);
                $stmt2->bindParam(":wq13", $wq13, PDO::PARAM_STR);
                $stmt2->bindParam(":wq14", $wq14, PDO::PARAM_INT);
                $stmt2->bindParam(":wq15", $wq15, PDO::PARAM_INT);
                $stmt2->bindParam(":wq17", $wq17, PDO::PARAM_INT);
                $stmt2->bindParam(":wq18", $wq18, PDO::PARAM_STR);
                $stmt2->bindParam(":wq19", $wq19, PDO::PARAM_STR);
                $stmt2->bindParam(":wq20", $wq20, PDO::PARAM_INT);
                $stmt2->bindParam(":wq20_1", $wq20_1, PDO::PARAM_STR);
                $stmt2->bindParam(":wq21", $wq21, PDO::PARAM_INT);
                $stmt2->bindParam(":wq23", $wq23, PDO::PARAM_INT);
                $stmt2->bindParam(":wq24", $wq24, PDO::PARAM_INT);
                $stmt2->bindParam(":wq25", $wq25, PDO::PARAM_INT);
                $stmt2->bindParam(":wq26", $wq26, PDO::PARAM_INT);
                $stmt2->bindParam(":wq27", $wq27, PDO::PARAM_STR);        
                $stmt2->execute();

                $sql3 = "INSERT INTO form_social (idClient, sq1, sq1_1, sq2, sq3,sq4, sq5, sq6, sq7, sq8, sq9, sq10, sq11, sq12, sq13, sq14, sq15, sq16, sq17, sq18, sq20, sq22, sq23, sq24, sq25) 
                         VALUES (:idClient, :sq1, :sq1_1, :sq2, :sq3, :sq4, :sq5, :sq6, :sq7, :sq8, :sq9, :sq10, :sq11, :sq12, :sq13, :sq14, :sq15, :sq16, :sq17, :sq18, :sq20, :sq22, :sq23, :sq24, :sq25)";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bindParam(":idClient", $idClient, PDO::PARAM_INT);
                $stmt3->bindParam(":sq1", $sq1, PDO::PARAM_INT);
                $stmt3->bindParam(":sq1_1", $sq1, PDO::PARAM_STR);
                $stmt3->bindParam(":sq2", $sq2, PDO::PARAM_STR);
                $stmt3->bindParam(":sq3", $sq3, PDO::PARAM_STR);
                $stmt3->bindParam(":sq4", $sq4, PDO::PARAM_STR);
                $stmt3->bindParam(":sq5", $sq5, PDO::PARAM_STR);
                $stmt3->bindParam(":sq6", $sq6, PDO::PARAM_STR);
                $stmt3->bindParam(":sq7", $sq7, PDO::PARAM_STR);
                $stmt3->bindParam(":sq8", $sq8, PDO::PARAM_INT);
                $stmt3->bindParam(":sq9", $sq9, PDO::PARAM_INT);
                $stmt3->bindParam(":sq10", $sq10, PDO::PARAM_STR);
                $stmt3->bindParam(":sq11", $sq11, PDO::PARAM_STR);
                $stmt3->bindParam(":sq12", $sq12, PDO::PARAM_STR);
                $stmt3->bindParam(":sq13", $sq13, PDO::PARAM_STR);
                $stmt3->bindParam(":sq14", $sq14, PDO::PARAM_STR);
                $stmt3->bindParam(":sq15", $sq15, PDO::PARAM_STR);
                $stmt3->bindParam(":sq16", $sq16, PDO::PARAM_STR);
                $stmt3->bindParam(":sq17", $sq17, PDO::PARAM_STR);
                $stmt3->bindParam(":sq18", $sq18, PDO::PARAM_STR);
                $stmt3->bindParam(":sq20", $sq20, PDO::PARAM_STR);
                $stmt3->bindParam(":sq22", $sq22, PDO::PARAM_INT);
                $stmt3->bindParam(":sq23", $sq23, PDO::PARAM_STR);
                $stmt3->bindParam(":sq24", $sq24, PDO::PARAM_STR);
                $stmt3->bindParam(":sq25", $sq25, PDO::PARAM_STR);

                $stmt3->execute();

               
                    // Devolver la respuesta con el ID
                    $response = array(
                        "status" => 'success',
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
             } else {
              // Se encontraron errores, enviar los errores como parte de la respuesta JSON
              header('Content-Type: application/json');
              echo json_encode(['status' => 'error', 'message' => 'Validation errors', 'errors' => $errors]);
             }

            
        } else {
          // response output - data error
          $response['status'] = 'error post';
          header('Content-Type: application/json');
          echo json_encode($response);
        }

}
?>
