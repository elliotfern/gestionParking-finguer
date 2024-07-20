<?php
$id = $params['id'];
?>

<div class="container-fluid">
<h1>Update Client</h1>
<h2 id="clientNameTitle"></h2>

<div class="alert alert-success" id="creaOk" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>New client OK!</strong></h4>
                  <h6>Client updated successfully.</h6>
</div>
          
<div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Error</strong></h4>
                  <h6>Check the fields, some information is not correct.</h6>
</div>

<form action="" method="POST" id="updateClient" >
<div class="row g-4 quadre">
                    <div class="col-6">
                        <label for="client_name">Client Name</label>
                        <input type="text" name="client_name" id="client_name" class="form-control">
                        <div class="invalid-feedback" id="client_name_error" style="display:block!important">
                        * Required
                        </div>
                    </div>

                    <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                    
                    <div class="col-6">
                    <label for="business_name">Business Name</label>
                    <input type="name" name="business_name" id="business_name" class="form-control">
                    <div class="invalid-feedback" id="business_name_error" style="display:block!important">
                    * Required
                        </div>
                    </div>

                    <hr>

                    <div class="col-6">
                    <label for="business_address">Business Address</label>
                    <input type="text" name="business_address" id="business_address" class="form-control">
                    </div>

                    <div class="col-6">
                    <label for="billing_address">Billing Address</label>
                    <input type="text" name="billing_address" id="billing_address" class="form-control">
                    </div>

                    <hr>
                    
                    <div class="col-6">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" class="form-control">
                    <div class="invalid-feedback" id="email_error" style="display:block!important">
                    * Required
                        </div>
                    </div>

                    <div class="col-6">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                    <div class="invalid-feedback" id="phone_error" style="display:block!important">
                    * Required
                    </div>
                    </div>

                    <div class="col-6">
                    <label for="phone">Mobile</label>
                    <input type="text" name="mobile" id="mobile" class="form-control">
                    </div>

                    <hr>

                    <div class="col-6">
                    <label for="vat_number">VAT Number</label>
                    <input type="text" name="vat_number" id="vat_number" class="form-control">
                    </div>

                    <div class="col-6">
                    <label for="po_number">PO Number</label>
                    <input type="text" name="po_number" id="po_number" class="form-control">
                    </div>

                    <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update Client</button>
                    </div>
</div>
    
</form>
</div>

<script>

clientInfo('<?php echo $id; ?>')

function clientInfo(id) {
  let urlAjax = "/api/clients/get/?clientInfo=" + id;
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
        var clientData = data;
        const newContent = "Client: " + clientData.client_name;
        const h2Element = document.getElementById('clientNameTitle');
        h2Element.innerHTML = newContent;

        document.getElementById('client_name').value = clientData.client_name;
        document.getElementById('business_name').value = clientData.business_name;
        document.getElementById('business_address').value = clientData.business_address;
        document.getElementById('billing_address').value = clientData.billing_address;
        document.getElementById('email').value = clientData.email;
        document.getElementById('phone').value = clientData.phone;
        document.getElementById('mobile').value = clientData.mobile;
        document.getElementById('vat_number').value = clientData.vat_number;
        document.getElementById('po_number').value = clientData.po_number;

      } catch (error) {
        console.error('Error al parsear JSON:', error);  // Muestra el error de parsing
      }
    }
  })
}


// llançar ajax per guardar dades

document.getElementById("updateClient").addEventListener("submit", function(event) {
  event.preventDefault();

  const formData = Object.fromEntries(new FormData(this));

  const url = "https://" +  window.location.hostname + "/api/clients/put/?type=updateClient";
  const jsonData = JSON.stringify(formData);

  $.ajax({
    contentType: "application/json",
    type: "PUT",
    url: url,
    dataType: "JSON",
    beforeSend: function (xhr) {
      let token = localStorage.getItem('token');
      xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    },
    data: jsonData,
    success: function (response) {
      if (response.status == "success") {
        $("#creaOk").show();
        $("#creaErr").hide();
        $(".invalid-feedback").text('');
        $("input[type='text']").css("border-color", "");
        $("select").css("border-color", "");
      } else {
        $("#creaErr").show();
        $("#creaOk").hide();

        if (response.errors) {
          $.each(response.errors, function(key, value) {
            $("#" + key + "_error").html('<strong>* ' + value + '</strong>');
            $("#" + key).css("border-color", "red");
          });
        } else {
          alert("Error: " + response.message);
        }
      }
    },
  });
});

</script>
