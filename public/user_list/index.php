<?php
// ID USER from cookie
$user_id = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;

// Allowed users
$allowedUserIds = array(1,2,3); // Caroline, Geraldine and Elliot
?>

<div class="container-fluid">
    <h1>Intranet users</h1>

<div class="btn-group-toggle" data-toggle="buttons">
  <a href="<?php echo APP_SERVER;?>/user-list/<?php echo $user_id;?>/password" class="btn btn-secondary" role="button">Change my password</a>                        


<?php
if (in_array($user_id, $allowedUserIds)) {
    echo '<a class="btn btn-primary" href="'.APP_SERVER.'/user-list/new" role="button">Create new user</a>';
}
?>
</div>

<div class="table-responsive" style="margin-top:40px;margin-bottom:40px">
    <table class="table table-striped" id="users">
        <thead class="table-primary">
        <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Type of user</th>
        <th>Status</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
</div>

<script>

    function fetch_data(){
            let userId = localStorage.getItem('user_id');
            var urlAjax = "/api/users/get/?type=usersAll";
            $.ajax({
                url:urlAjax,
                method:"GET",
                dataType:"json",
                    beforeSend: function (xhr) {
                    // Obtener el token del localStorage
                    let token = localStorage.getItem('token');

                    // Incluir el token en el encabezado de autorización
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    },

                success:function(data){
                    var html = '';
                    for(var i=0; i<data.length; i++){
                        html += '<tr>';
                        html += '<td><a href="https://' + window.location.hostname + '/job-list/user/' + data[i].id + '">' + data[i].name+'</a>';
                        html += '<td><a href="mailto:' + data[i].email + '">'+data[i].email+'</a></td>';
                        html += '<td>';
                        if (data[i].access == "1") {
                            html += '<button type="button" class="btn btn-sm btn-danger">Managing director</button>';
                        } else if (data[i].access == "2") {
                            html += '<button type="button" class="btn btn-sm btn-dark">Web & Design Development</button>';
                        } else if (data[i].access == "3") {
                            html += '<button type="button" class="btn btn-sm btn-warning">Brand & Design</button>';
                        } else if (data[i].access == "4") {
                            html += '<button type="button" class="btn btn-sm btn-success">Social Media</button>';
                        } else if (data[i].access == "5") {
                            html += '<button type="button" class="btn btn-sm btn-primary">Company Administrator</button>';
                        }
                        html += '</td>';
                        html += '<td>';
                        if (data[i].status == "1") {
                            html += '<button type="button" class="btn btn-sm btn-danger" onclick="changeUserStatus(' + data[i].id + ', 2)">Active</button>';
                        } else if (data[i].status == "2") {
                            html += '<button type="button" class="btn btn-sm btn-dark" onclick="changeUserStatus('+ data[i].id +', 1)">Non active</button>';
                        }
                        html += '</td>';
                        html += '</tr>';
                    }
                    $('#users tbody').html(html);
                }
            });
 }
fetch_data();

function changeUserStatus(userId, option) {

// Obtener los datos del formulario como un objeto JSON
let formData = {
    status: option,
    userId: userId
  };

  let urlAjax = `https://${window.location.hostname}/api/users/put/?type=updateStatus`;

$.ajax({
  contentType: "application/json", // Establecer el tipo de contenido como JSON
  type: "PUT",
  url: urlAjax,
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
      //$("#updateOk").show();
      //$("#updateErr").hide();

    // Recargar la tabla después de actualizar los datos
    fetch_data();
    } else {
      //$("#updateErr").show();
      //$("#updateOk").hide();
    }
  },
});
}
</script>

<?php

# footer
//include_once(APP_ROOT. '/public/01_inici/footer.php');
