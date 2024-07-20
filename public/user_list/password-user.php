<?php
$user = $params['user'];
?>

<div class="container-fluid">
<h1>New user Password</h1>
<h2 id="project_nameTitle"></h2>

<div class="alert alert-success" id="creaOk" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Password change successfuly!</strong></h4>
                  <h6>Your new password is change.</h6>
</div>
          
<div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Error</strong></h4>
                  <h6>Check the fields, some information is not correct.</h6>
</div>

<form action="" method="POST" id="updatePassword" >
<div class="row g-4 quadre">
                    <input type="hidden" id="id" name="id" value="<?php echo $user;?>">
                    
                    <div class="col-6">
                    <label for="password">New password:</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <div class="invalid-feedback" id="password_error" style="display:block!important">
                        * Required
                        </div>
                    </div>

                    <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
</div>
    
</form>
</div>

<script>
// llançar ajax per guardar dades
document.getElementById("updatePassword").addEventListener("submit", function(event) {

    event.preventDefault(); // Prevenir el envío por defecto
        // URL a la que se enviarán los datos
        const url = "/api/users/put/?type=updatePassword";

        // Obtener los datos del formulario como un objeto JSON
        const formData = Object.fromEntries(new FormData(this));

        // Convertir el objeto en una cadena JSON
        var jsonData = JSON.stringify(formData);

        // Realizar la solicitud AJAX con los datos del formulario
        $.ajax({
            contentType: "application/json", // Establecer el tipo de contenido como JSON
            type: "PUT",
            url: url,
            dataType: "JSON",
            beforeSend: function (xhr) {
                // Obtener el token del localStorage
                let token = localStorage.getItem('token');
            
                // Incluir el token en el encabezado de autorización
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            data: jsonData,
            success: function (response) {
                if (response.status == "success") {
                    // Add response in Modal body
                    $("#creaOk").show();
                    $("#creaErr").hide();

                        // Limpiar los mensajes de error
                        $(".invalid-feedback").text(''); // Esto limpia todos los mensajes de error

                        // Eliminar el color rojo de los campos de texto
                        $("input[type='text']").css("border-color", ""); // Esto elimina el color rojo del borde de todos los campos de texto
                        $("select").css("border-color", "");

                    } else {
                    $("#creaErr").show();
                    $("#creaOk").hide();
            
                if (response.errors) {
                        // Recorres el objeto de errores y muestras cada mensaje de error
                        $.each(response.errors, function(key, value) {
                        // Aquí puedes mostrar los mensajes de error en el lugar adecuado en tu página web
                        $("#" + key + "_error").html('<strong>* ' + value + '</strong>');
                        $("#" + key).css("border-color", "red");
                        });
                    } else {
                        // Si no hay errores específicos, puedes mostrar un mensaje genérico de error
                        alert("Error: " + response.message);
                    }
        }
      },
    });
});

</script>