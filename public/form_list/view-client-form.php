<?php
$clientId = $params['clientId'];

// ID USER from cookie
$user_id = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;

// Allowed users
$allowedUserIds = array(1,2); // Caroline and Elliot
?>

<div class="container-fluid">
<h1>Form submission</h1>
<h2 id="clientTitle"></h2>
<h6 id="date"></h6>

<?php
if (in_array($user_id, $allowedUserIds)) {
    echo '<div class="col-3" style="margin-top:20px;margin-bottom:20px">
    </div>';
} ?>



<!-- PAGE CONTENT STARTS HERE -->
<div class="container mt-5 quadre">
  <h1>Questionnaire</h1>
    <p>Designedly Ltd are a Brand Agency, working with many companies to help create, develop, maintain and improve brands. We support your brand, by developing an understanding of your business, clarifying your goals and objectives and communicating this in the right way to the right audience. From this information we help you to provide a strategy to  grow your brand and provide you with the right toolkit to embed your brand purpose, values, promises, positioning, and  identity into your organisation.</p>

  <div class="alert alert-success" id="creaOk" style="display:none" role="alert">
    <h4 class="alert-heading"><strong>New form submit whithout errors!</strong></h4>
    <h6>Thank you for submit to us all the information.</h6>
  </div>
          
  <div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
  <h4 class="alert-heading"><strong>Error</strong></h4>
  <h6>Some data is not correct.</h6>
  </div>

    <!-- Form tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab1-tab">General information</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab2-tab">Your requirements</button>
      </li>
  </ul>


  <!-- TAB CONTENT STARTS HERE -->
  <div class="tab-content" id="myTabContent">

      <!-- TAB 1 - Client data-->
      <?php include APP_ROOT . '/public/form_list/form_1_general_tab.php'; ?>
   
      <!-- TAB 2 - HERE WE SHOW ALL QUESTIONS AND ANSWERS-->
      <div id="tab2" style="border:1px solid #dee2e6; border-top: none;padding:20;display:none">
        <div class="container quadre2">
          <div style="margin-bottom:20px">
            <h3>What do you need?</h3>
              <button type="button" class="btn btn-success btnBrand" id="brandBtn">NEW BRAND</button>
              <button type="button" class="btn btn-success btnWebsite" id="websiteBtn">NEW WEBSITE</button>
              <button type="button" class="btn btn-success btnSocialMedia" id="socialMediaBtn">NEW SOCIAL MEDIA STRATEGY</button>
          </div>

          <!-- TAB 2a) - BRAND QUESTIONNAIRE-->
          <?php include APP_ROOT . '/public/form_list/form_2_brand.php'; ?>

          <!-- TAB 2b) - WEBSITE QUESTIONNAIRE-->
          <?php include APP_ROOT . '/public/form_list/form_3_website.php'; ?>

          <!-- TAB 2c) - SOCIAL MEDIA QUESTIONNAIRE-->
          <?php include APP_ROOT . '/public/form_list/form_4_social.php'; ?>

          <input type="hidden" id="idClient" name="idClient" value="">

          <!-- FORM BUTTONS ACTIONS -->

          <div class="alert alert-success" id="creaOk-2" style="display:none" role="alert">
                    <h4 class="alert-heading"><strong>New form submit whithout errors!</strong></h4>
                    <h6>Thank you for submit to us all the information.</h6>
          </div>
                            
          <div class="alert alert-danger" id="creaErr-2" style="display:none" role="alert">
                    <h4 class="alert-heading"><strong>Error</strong></h4>
                    <h6>Some data is not correct.</h6>
          </div>

          <button type="button" class="btn btn-secondary" id="btnBack">Back</button>
        
        </div>
      </div>
  </div>
</div>

<script>
formClientInfo('<?php echo $clientId; ?>')

function formClientInfo(id) {
  let urlAjax = "/api/form/get/?type=clientId&id=" + id;
  $.ajax({
    url: urlAjax,
    method: "GET",
    dataType: "json",
    beforeSend: function (xhr) {
      // Obtener el token del localStorage
      let token = localStorage.getItem('token');

      // Incluir el token en el encabezado de autorización
      xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    },

    success: function (data) {
      try {
        const newContent = data[0].client_name;
        const h2Element = document.getElementById('clientTitle');
        h2Element.innerHTML = "Client " + newContent;

        const date = data[0].date;
        const date_format = moment(date).format("DD MMM YYYY"); 
        const dateElement = document.getElementById('date');
        dateElement.innerHTML = "Date: " + date_format;

        // client form tab
       
        document.getElementById('client_name').value = data[0].client_name;
        document.getElementById('company_name').value = data[0].company_name;
        document.getElementById('address').value = data[0].address;
        document.getElementById('email').value = data[0].email;
        document.getElementById('phone').value = data[0].phone;
        document.getElementById('vat_number').value = data[0].vat_number;
        document.getElementById('po_number').value = data[0].po_number;
        document.getElementById('cq1').value = data[0].cq1;
        document.getElementById('cq1').value = data[0].cq1;
        const checkboxValue = data[0].cq2;
        const checkbox1_1yes = document.getElementById('cq2a');
        const checkbox1_1no = document.getElementById('cq2b');
        if (checkboxValue == 1) {
          checkbox1_1yes.checked = true;
          checkbox1_1no.checked = false; // Corrección aquí
        } else if (checkboxValue == 2) {
          checkbox1_1yes.checked = false;
          checkbox1_1no.checked = true;
        }

        // Deshabilitar los inputs para que no puedan ser modificados
       // Prevenir la modificación
        checkbox1_1yes.addEventListener('click', function(event) {
          event.preventDefault();
        });

        checkbox1_1no.addEventListener('click', function(event) {
          event.preventDefault();
        });

        document.getElementById('cq2_1').value = data[0].cq2_1;
        document.getElementById('cq3').value = data[0].cq3;
        document.getElementById('cq4').value = data[0].cq4;

        // brand form tab
        document.getElementById('bq1').value = data[0].bq1;
        document.getElementById('bq2').value = data[0].bq2;
        document.getElementById('bq3').value = data[0].bq3;
        document.getElementById('bq4').value = data[0].bq4;
        document.getElementById('bq5').value = data[0].bq5;
        document.getElementById('bq6').value = data[0].bq6;
        document.getElementById('bq7').value = data[0].bq7;
        document.getElementById('bq8').value = data[0].bq8;
        document.getElementById('bq9').value = data[0].bq9;
        const checkboxValuebq10 = data[0].bq10;
        const checkboxbq10yes = document.getElementById('bq10a');
        const checkboxbq10no = document.getElementById('bq10b');
        if (checkboxValuebq10 == 1) {
          checkboxbq10yes.checked = true;
          checkboxbq10no.checked = false; // Corrección aquí
        } else if (checkboxValuebq10 == 2) {
          checkboxbq10yes.checked = false;
          checkboxbq10no.checked = true;
        }

         // Deshabilitar los inputs para que no puedan ser modificados
       // Prevenir la modificación
       checkboxbq10yes.addEventListener('click', function(event) {
          event.preventDefault();
        });

        checkboxbq10no.addEventListener('click', function(event) {
          event.preventDefault();
        });


        document.getElementById('bq10_2').value = data[0].bq10_2;
        document.getElementById('bq10_3').value = data[0].bq10_3;
        document.getElementById('bq10_4').value = data[0].bq10_4;
        document.getElementById('bq11').value = data[0].bq11;

        const checkboxValuebq12 = data[0].bq12;
        const checkboxbq12yes = document.getElementById('bq12a');
        const checkboxbq12no = document.getElementById('bq12b');
        if (checkboxValuebq12 == 1) {
          checkboxbq12yes.checked = true;
          checkboxbq12no.checked = false; // Corrección aquí
        } else if (checkboxValuebq12 == 2) {
          checkboxbq12yes.checked = false;
          checkboxbq12no.checked = true;
        }

         // Deshabilitar los inputs para que no puedan ser modificados
       // Prevenir la modificación
       checkboxbq12yes.addEventListener('click', function(event) {
          event.preventDefault();
        });

        checkboxbq12no.addEventListener('click', function(event) {
          event.preventDefault();
        });

        const data2 = data[0].bq13;

        // Verificar si hay datos disponibles
        if (data2 !== null) {
          // Convertir la cadena a un array
          const selectedValues = data2.replace(/{|}/g, '').split(',').map(Number);

          // Iterar sobre los valores seleccionados
          selectedValues.forEach(value => {
            // Seleccionar el checkbox correspondiente al valor
            const checkbox = document.querySelector(`input[name="bq13[]"][value="${value}"]`);
            if (checkbox) {
              // Marcar el checkbox
              checkbox.checked = true;

              // Prevenir la modificación del checkbox
              checkbox.addEventListener('click', function(event) {
                event.preventDefault();
              });
            }
          });

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="bq13[]"]').forEach(checkbox => {
                checkbox.disabled = true;
              });
        }

        const checkboxValuebq14 = data[0].bq14;
        const checkboxbq14_1 = document.getElementById('bq14_1');
        const checkboxbq14_2 = document.getElementById('bq14_2');
        const checkboxbq14_3 = document.getElementById('bq14_3');
        const checkboxbq14_4 = document.getElementById('bq14_4');
        const checkboxbq14_5 = document.getElementById('bq14_5');
        const checkboxbq14_6 = document.getElementById('bq14_6');
        if (checkboxValuebq14 == 1) {
          checkboxbq14_1.checked = true;
        } else if (checkboxValuebq14 == 2) {
          checkboxbq14_2.checked = true;
        } else if (checkboxValuebq14 == 3) {
          checkboxbq14_3.checked = true;
        } else if (checkboxValuebq14 == 4) {
          checkboxbq14_4.checked = true;
        } else if (checkboxValuebq14 == 5) {
          checkboxbq14_5.checked = true;
        } else if (checkboxValuebq14 == 6) {
          checkboxbq14_6.checked = true;
        }

         // Deshabilitar todos los checkboxes de bq19
         document.querySelectorAll('input[name="bq14"]').forEach(checkbox => {
              checkbox.disabled = true;
            });


        document.getElementById('bq15').value = data[0].bq15;
        document.getElementById('bq16').value = data[0].bq16;
        document.getElementById('bq17').value = data[0].bq17;
        document.getElementById('bq18').value = data[0].bq18;

        // Procesamiento de bq19
        const dataString2 = data[0].bq19;
        // Verificar si hay datos disponibles
        if (dataString2 !== null) {
          const selectedValues2 = dataString2.replace(/{|}/g, '').split(',').map(value => parseInt(value.trim()));
            selectedValues2.forEach(value => {
              const checkbox2 = document.querySelector(`input[name="bq19[]"][value="${value}"]`);
              if (checkbox2) {
                checkbox2.checked = true;
                checkbox2.disabled = true; // Deshabilitar todos los checkboxes
              }
            });

            // Deshabilitar todos los checkboxes de bq19
            document.querySelectorAll('input[name="bq19[]"]').forEach(checkbox => {
              checkbox.disabled = true;
            });
        }

        document.getElementById('bq20').value = data[0].bq20;
        document.getElementById('bq21').value = data[0].bq21;
        document.getElementById('bq22').value = data[0].bq22;

        const checkboxValuebq23 = data[0].bq23;
        const checkboxbq23_1 = document.getElementById('bq23_1');
        const checkboxbq23_2 = document.getElementById('bq23_2');
        if (checkboxValuebq23 == 1) {
          checkboxbq23_1.checked = true;
        } else if (checkboxValuebq23 == 2) {
          checkboxbq23_2.checked = true;
        }

         // Deshabilitar todos los checkboxes de bq19
         document.querySelectorAll('input[name="bq23"]').forEach(checkbox => {
              checkbox.disabled = true;
            });

        document.getElementById('bq24').value = data[0].bq24;

        const checkboxValuebq25 = data[0].bq25;
        const checkboxbq25_1 = document.getElementById('bq25_1');
        const checkboxbq25_2 = document.getElementById('bq25_2');
        if (checkboxValuebq25 == 1) {
          checkboxbq25_1.checked = true;
        } else if (checkboxValuebq25 == 2) {
          checkboxbq25_2.checked = true;
        }

         // Deshabilitar todos los checkboxes de bq19
         document.querySelectorAll('input[name="bq25"]').forEach(checkbox => {
              checkbox.disabled = true;
            });

        document.getElementById('bq26').value = data[0].bq26;

        // SOCIAL MEDIA FORM
        document.getElementById('sq1').value = data[0].sq1;
        document.getElementById('sq2').value = data[0].sq2;
        document.getElementById('sq3').value = data[0].sq3;
        document.getElementById('sq4').value = data[0].sq4;
        document.getElementById('sq5').value = data[0].sq7;
        document.getElementById('sq6').value = data[0].sq6;
        document.getElementById('sq7').value = data[0].sq7;

        const checkboxValuesq8 = data[0].sq8;
        const checkboxsq8_1 = document.getElementById('sq8_1');
        const checkboxsq8_2 = document.getElementById('sq8_2');
        if (checkboxValuesq8 == 1) {
          checkboxsq8_1.checked = true;
        } else if (checkboxValuesq8 == 2) {
          checkboxsq8_2.checked = true;
        }

        // Deshabilitar todos los checkboxes de bq19
        document.querySelectorAll('input[name="sq8"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        const checkboxValuessq9 = data[0].sq9;
        const checkboxsq9_1 = document.getElementById('sq9_1');
        const checkboxsq9_2 = document.getElementById('sq9_2');
        if (checkboxValuessq9 == 1) {
          checkboxsq9_1.checked = true;
        } else if (checkboxValuessq9 == 2) {
          checkboxsq2_2.checked = true;
        }

        // Deshabilitar todos los checkboxes de bq19
        document.querySelectorAll('input[name="sq9"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        document.getElementById('sq10').value = data[0].sq10;
        document.getElementById('sq11').value = data[0].sq11;
        document.getElementById('sq12').value = data[0].sq12;
        document.getElementById('sq13').value = data[0].sq13;
        document.getElementById('sq14').value = data[0].sq14;
        document.getElementById('sq15').value = data[0].sq15;
        document.getElementById('sq16').value = data[0].sq16;
        document.getElementById('sq17').value = data[0].sq17;
        document.getElementById('sq18').value = data[0].sq18;
        document.getElementById('sq20').value = data[0].sq20;


        const checkboxValuessq22 = data[0].sq22;
        const checkboxsq22_1 = document.getElementById('sq22_1');
        const checkboxsq22_2 = document.getElementById('sq22_2');
        if (checkboxValuessq22 == 1) {
          checkboxsq22_1.checked = true;
        } else if (checkboxValuessq9 == 2) {
          checkboxsq22_2.checked = true;
        }

        // Deshabilitar todos los checkboxes de bq19
        document.querySelectorAll('input[name="sq22"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        document.getElementById('sq23').value = data[0].sq23;
        document.getElementById('sq24').value = data[0].sq24;
        document.getElementById('sq25').value = data[0].sq25;


        // WEBSITE FORM
        	
        const checkboxValueswq1 = data[0].wq1;
        const checkboxqwq1_1 = document.getElementById('wq1_1');
        const checkboxqwq1_2 = document.getElementById('wq1_2');
        if (checkboxValueswq1 == 1) {
          checkboxqwq1_1.checked = true;
        } else if (checkboxValueswq1 == 2) {
          checkboxqwq1_2.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq1"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        	
        const checkboxValueswq1_1 = data[0].wq1_1;
        const checkboxwq1_1_1 = document.getElementById('wq1_1_1');
        const checkboxwq1_1_2 = document.getElementById('wq1_1_2');
        const checkboxwq1_1_3 = document.getElementById('wq1_1_3');
        const checkboxwq1_1_4 = document.getElementById('wq1_1_4');
        if (checkboxValueswq1_1 == 1) {
          checkboxwq1_1_1.checked = true;
        } else if (checkboxValueswq1_1 == 2) {
          checkboxwq1_1_2.checked = true;
        } else if (checkboxValueswq1_1 == 3) {
          checkboxwq1_1_3.checked = true;
        } else if (checkboxValueswq1_1 == 4) {
          checkboxwq1_1_4.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq1_1"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        const checkboxValueswq2 = data[0].wq2;
        const checkboxqwq2_1 = document.getElementById('wq2_1');
        const checkboxqw2_2 = document.getElementById('wq2_2');
        if (checkboxValueswq2 == 1) {
          checkboxqwq2_1.checked = true;
        } else if (checkboxValueswq2 == 2) {
          checkboxqw2_2.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq2"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        document.getElementById('wq2_1_1').value = data[0].wq2_1;
        document.getElementById('wq2_2_2').value = data[0].wq2_2;
        document.getElementById('wq6').value = data[0].wq6;
        document.getElementById('wq8').value = data[0].wq8;
        document.getElementById('wq9').value = data[0].wq9;
        document.getElementById('wq10').value = data[0].wq10;
        document.getElementById('wq11').value = data[0].wq11;
        document.getElementById('wq12').value = data[0].wq12;

        document.getElementById('wq13').value = data[0].wq13;
        	
        const checkboxValueswq14 = data[0].wq14;
        const checkboxwq14_1 = document.getElementById('wq14_1');
        const checkboxwq14_2 = document.getElementById('wq14_2');
        if (checkboxValueswq14 == 1) {
          checkboxwq14_1.checked = true;
        } else if (checkboxValueswq14 == 2) {
          checkboxwq14_2.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq14"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        const checkboxValueswq15 = data[0].wq15;
        const checkboxwq15_1 = document.getElementById('wq15_1');
        const checkboxwq15_2 = document.getElementById('wq15_2');
        if (checkboxValueswq15 == 1) {
          checkboxwq15_1.checked = true;
        } else if (checkboxValueswq15 == 2) {
          checkboxwq15_2.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq15"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        const checkboxValueswq17 = data[0].wq17;
        const checkboxwq17_1 = document.getElementById('wq17_1');
        const checkboxwq17_2 = document.getElementById('wq17_2');
        if (checkboxValueswq17 == 1) {
          checkboxwq17_1.checked = true;
        } else if (checkboxValueswq17 == 2) {
          checkboxwq17_2.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq17"]').forEach(checkbox => {
                checkbox.disabled = true;
              });


        const checkboxValueswq18 = data[0].wq18;
        const checkboxwq18_1 = document.getElementById('wq18_1');
        const checkboxwq18_2 = document.getElementById('wq18_2');
        const checkboxwq18_3 = document.getElementById('wq18_3');
        const checkboxwq18_4 = document.getElementById('wq18_4');
        if (checkboxValueswq18 == 1) {
          checkboxwq18_1.checked = true;
        } else if (checkboxValueswq18 == 2) {
          checkboxwq18_2.checked = true;
        } else if (checkboxValueswq18 == 3) {
          checkboxwq18_3.checked = true;
        } else if (checkboxValueswq18 == 4) {
          checkboxwq18_4.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq18"]').forEach(checkbox => {
                checkbox.disabled = true;
              });



        
         // Procesamiento de bq19
         const dataStringwq19 = data[0].wq19;
        // Verificar si hay datos disponibles
        if (dataStringwq19 !== null) {
          const selectedValues2 = dataStringwq19.replace(/{|}/g, '').split(',').map(value => parseInt(value.trim()));
            selectedValues2.forEach(value => {
              const checkbox2 = document.querySelector(`input[name="wq19[]"][value="${value}"]`);
              if (checkbox2) {
                checkbox2.checked = true;
                checkbox2.disabled = true; // Deshabilitar todos los checkboxes
              }
            });

            // Deshabilitar todos los checkboxes de bq19
            document.querySelectorAll('input[name="wq19[]"]').forEach(checkbox => {
              checkbox.disabled = true;
            });
        }

        const checkboxValueswq20 = data[0].wq20;
        const checkboxwq20_1 = document.getElementById('wq20_1_1');
        const checkboxwq20_2 = document.getElementById('wq20_2_2');
        if (checkboxValueswq20 == 1) {
          checkboxwq20_1.checked = true;
        } else if (checkboxValueswq20 == 2) {
          checkboxwq20_2.checked = true;
        }

        // Deshabilitar todos los checkboxes de bq19
        document.querySelectorAll('input[name="wq20"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        document.getElementById('wq20_1').value = data[0].wq20_1;

        const checkboxValueswq21 = data[0].wq21;
        const checkboxwq21_1 = document.getElementById('wq21_1');
        const checkboxwq21_2 = document.getElementById('wq21_2');
        if (checkboxValueswq21 == 1) {
          checkboxwq21_1.checked = true;
        } else if (checkboxValueswq21 == 2) {
          checkboxwq21_2.checked = true;
        }

        // Deshabilitar todos los checkboxes de bq19
        document.querySelectorAll('input[name="wq21"]').forEach(checkbox => {
                checkbox.disabled = true;
              });
        
        const checkboxValueswq23 = data[0].wq23;
        const checkboxwq23_1 = document.getElementById('wq23_1');
        const checkboxwq23_2 = document.getElementById('wq23_2');
        const checkboxwq23_3 = document.getElementById('wq23_3');
        const checkboxwq23_4 = document.getElementById('wq23_4');
        if (checkboxValueswq23 == 1) {
          checkboxwq23_1.checked = true;
        } else if (checkboxValueswq23 == 2) {
          checkboxwq23_2.checked = true;
        } else if (checkboxValueswq23 == 3) {
          checkboxwq23_3.checked = true;
        } else if (checkboxValueswq23 == 4) {
          checkboxwq23_4.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq23"]').forEach(checkbox => {
                checkbox.disabled = true;
              });
	
        const checkboxValueswq24 = data[0].wq24;
        const checkboxwq24_1 = document.getElementById('wq24_1');
        const checkboxwq24_2 = document.getElementById('wq24_2');
        if (checkboxValueswq24 == 1) {
          checkboxwq24_1.checked = true;
        } else if (checkboxValueswq24 == 2) {
          checkboxwq24_2.checked = true;
        }

        // Deshabilitar todos los checkboxes de bq19
        document.querySelectorAll('input[name="wq24"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        const checkboxValueswq25 = data[0].wq25;
        const checkboxwq25_1 = document.getElementById('wq25_1');
        const checkboxwq25_2 = document.getElementById('wq25_2');
        const checkboxwq25_3 = document.getElementById('wq25_3');
        if (checkboxValueswq25 == 1) {
          checkboxwq25_1.checked = true;
        } else if (checkboxValueswq25 == 2) {
          checkboxwq25_2.checked = true;
        } else if (checkboxValueswq25 == 3) {
          checkboxwq25_3.checked = true;
        }

          // Deshabilitar todos los checkboxes de bq19
          document.querySelectorAll('input[name="wq25"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        const checkboxValueswq26 = data[0].wq26;
        const checkboxwq26_1 = document.getElementById('wq26_1');
        const checkboxwq26_2 = document.getElementById('wq26_2');
        if (checkboxValueswq26 == 1) {
          checkboxwq26_1.checked = true;
        } else if (checkboxValueswq26 == 2) {
          checkboxwq26_2.checked = true;
        }

        // Deshabilitar todos los checkboxes de bq19
        document.querySelectorAll('input[name="wq26"]').forEach(checkbox => {
                checkbox.disabled = true;
              });

        document.getElementById('wq27').value = data[0].wq27;


      } catch (error) {
        console.error('Error al parsear JSON:', error);  // Muestra el error de parsing
      }
    }
  })
}

// FUNCTION TO SHOW A DIFFERENT TAB
document.getElementById('tab1-tab').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('tab1').style.display = "block"; // Show the selected div
    document.getElementById('tab2').style.display = "none"; // Show the selected div
    document.getElementById('tab1-tab').classList.add('active'); // Add active class to tab1 button
    document.getElementById('tab2-tab').classList.remove('active'); // Remove active class from tab2 button
});

document.getElementById('tab2-tab').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('tab2').style.display = "block"; // Show the selected div
    document.getElementById('tab1').style.display = "none"; // Show the selected div
    document.getElementById('tab1-tab').classList.remove('active'); // Add active class to tab1 button
    document.getElementById('tab2-tab').classList.add('active'); // Remove active class from tab2 button
});

document.getElementById('btnNext').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('tab2').style.display = "block"; // Show the selected div
    document.getElementById('tab1').style.display = "none"; // Show the selected div
    document.getElementById('tab1-tab').classList.remove('active'); // Add active class to tab1 button
    document.getElementById('tab2-tab').classList.add('active'); // Remove active class from tab2 button
});

document.getElementById('btnBack').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('tab2').style.display = "none"; // Show the selected div
    document.getElementById('tab1').style.display = "block"; // Show the selected div
    document.getElementById('tab1-tab').classList.add('active'); // Add active class to tab1 button
    document.getElementById('tab2-tab').classList.remove('active'); // Remove active class from tab2 button
});

document.getElementById('brandBtn').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('brandDiv').style.display = "block"; 
    document.getElementById('websiteDiv').style.display = "none"; 
    document.getElementById('socialMediaDiv').style.display = "none"; 
});

document.getElementById('websiteBtn').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('websiteDiv').style.display = "block"; // Show the selected div
    document.getElementById('brandDiv').style.display = "none"; 
    document.getElementById('socialMediaDiv').style.display = "none"; 
});

document.getElementById('socialMediaBtn').addEventListener('click', function(event) {
    event.preventDefault(); // disallow form action
    document.getElementById('socialMediaDiv').style.display = "block"; // Show the selected div
    document.getElementById('brandDiv').style.display = "none"; 
    document.getElementById('websiteDiv').style.display = "none"; 
});

</script>
