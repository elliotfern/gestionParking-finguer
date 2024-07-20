<?php

if(!isset($_SESSION['user'])){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GestionParking.net - Finguer</title>
        <script
			  src="https://code.jquery.com/jquery-3.7.1.min.js"
			  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
			  crossorigin="anonymous"></script>
    
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
    <style>
    body {
      background-color: #2d2f31!important;
    
    }
    </style>
    </head>
    <body>
    
    <div class="container" style="margin-top:50px">

    <div class="col text-center" style="margin-bottom:20px">
            <img src="<?php echo APP_WEB;?>/public/inc/img/logo.png" alt="Logo" class="logo d-block mx-auto" width="250">
        </div>

    <div class="card mx-auto" style="max-width: 400px;">

        <div class="card-body">
            <div class="container">
                <h1>Entrada al sistema</h1>
                <?php
    echo '<div class="alert alert-success" id="loginMessageOk" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Login OK!</h4></strong>
                  <h6>Acceso autorizado, en unos segundos será redirigido a la página de gestión.</h6>
                  </div>';
          
    echo '<div class="alert alert-danger" id="loginMessageErr" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Error en los datos</h4></strong>
                  <h6>Usuario o contraseña incorrectos.</h6>
                  </div>';
    ?>
    
                <form action="" method="post" class="login">
                    <label for="username">Usuario</label>
                    <input type="text" name="email" id="email" class="form-control">
                    <br>
    
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <br>
                    <button name="login" id="btnLogin" class="btn btn-primary">Login</button>
    
                </form>
                </div>
      </div>
    </div>
    </div>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script>

      // AJAX PROCESS > PHP - LOGIN
$(function () {
  $("#btnLogin").click(function () {
    // check values
    $("#createBookMessageErr").hide();

    // Stop form from submitting normally
    event.preventDefault();
    let url = window.location.hostname;
    let urlAjax = "https://" + url + "/api/auth/login/";

    $.ajax({
      type: "POST",
      url: urlAjax,
      data: {
        email: $("#email").val(),
        password: $("#password").val(),
      },
      success: function (response) {
        if (response.status == "success") {
          localStorage.setItem('token', response.token);

          // Add response in Modal body
          $("#loginMessageOk").show();
          $("#loginMessageErr").hide();
          // redirect page
          setTimeout(function () {
            let url = window.location.hostname;
            window.location = "https://" + url + "/homepage";
          }, 1300);
        } else {
          // show error message
          $("#loginMessageOk").hide();
          $("#loginMessageErr").show();
        }
      },
    });
  });
});

</script>

    </body>
    </html>
    <?php
} else {
  $url_admin = APP_SERVER . '/homepage';
  header('Location: ' . $url_admin);
}