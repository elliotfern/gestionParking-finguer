import * as file2 from "../globals.js"; // Importar el archivo globals.js
import { loadDropdownData } from "../load-api/api-get.js";

export function addClient() {
  // AJAX EVENT
  // Escuchar el evento submit del formulario
  document.addEventListener("DOMContentLoaded", function () {
    $("#newClientBtn").click(function (event) {
      event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
      let dataForm = $("#newClient").serialize();
      $.ajax({
        url:
          "https://" +
          window.location.hostname +
          "/api/clients/post/?type=client",
        method: "POST",
        dataType: "json",
        beforeSend: file2.setAuthorizationHeader,
        data: dataForm, // Serializar el formulario
        success: function (response) {
          if (response.status == "success") {
            let clientId = response.clientId;
            $("#creaClientOk").show();
            $("#creaClientErr").hide();

            // Limpiar los campos del formulario
            $("#newClient")[0].reset();

            // Limpiar los mensajes de error
            $(".invalid-feedback").hide();

            // Eliminar el color rojo de los campos de texto
            $("input[type='text'], select").css("border-color", "");

            // Llamar a loadDropdownData con el nuevo clientId
            if (typeof loadDropdownData === "function") {
              loadDropdownData(clientId);
              $("#creaOk2").show();
              $("#creaErr2").hide();

              // Cerrar el modal automáticamente después de 3 segundos
              setTimeout(function () {
                $("#modalNewClient").modal("hide");
              }, 3000);
            } else {
              $("#creaClientOk").show();
              $("#creaClientErr").hide();
            }
          } else {
              $("#creaClientOk").hide();
              $("#creaClientErr").show();
            // Recorres el objeto de errores y muestras cada mensaje de error
            $.each(response.errors, function (key, value) {
              // Aquí puedes mostrar los mensajes de error en el lugar adecuado en tu página web
              $("#" + key + "_error")
                .html("<strong>* " + value + "</strong>")
                .show();
              $("#" + key).css("border-color", "red");
            });
          }
        },
        error: function (response) {
          // nothing
        },
      });
    });
  });
}
