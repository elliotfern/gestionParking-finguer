// AJAX PROCESS > PHP API : PER ACTUALIZAR FORMULARIS A LA BD
export function btnDeleteClient(id) {
    
    // Obtener los datos del formulario como un objeto JSON
    var formData = {
        id: id
      };
    
    $.ajax({
      contentType: "application/json",
      type: "DELETE",
      url: 'https://' + window.location.hostname + '/api/clients/delete/?type=deleteClient',
      dataType: "JSON",
      beforeSend: function (xhr) {
        // Obtener el token del localStorage
        let token = localStorage.getItem('token');
    
        // Incluir el token en el encabezado de autorización
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
      },
      data: JSON.stringify(formData),
      success: function (response) {
        if (response.status == "success") {
          // Add response in Modal body
          $("#updateOk").show();
          $("#updateErr").hide();
              // Recargar la tabla después de actualizar los datos
              $('#clientsListTable').DataTable().ajax.reload(null, false);
        } else {
          $("#updateErr").show();
          $("#updateOk").hide();
        }
      },
    });
    }
