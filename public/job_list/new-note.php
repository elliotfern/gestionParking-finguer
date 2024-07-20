<?php
$idJob = $params['id'];

// ID USER from cookie
$idUser = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;
?>

<div class="container-fluid">
<h1>New Note</h1>
<h2 id="jobTitle"></h2>
<h5 id="jobNumber"></h5>

<div class="alert alert-success" id="creaOk" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>New note create OK!</strong></h4>
                  <h6>New note create successfully.</h6>
                  </div>
          
<div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Error</strong></h4>
                  <h6>Some data is not correct.</h6>
</div>

                <form action="" method="POST" id="newNote" >

                <input type="hidden" id="idJob" name="idJob" value="<?php echo $idJob;?>">
                <input type="hidden" id="idUser" name="idUser" value="<?php echo $idUser;?>">

                <div class="row g-4 quadre">

                <div class="col-12">
                        <label for="note">Note: </label>
                        <input type="hidden" id="note" name="note">
                        <trix-editor input="note"></trix-editor>
                        <div class="invalid-feedback" id="note_error" style="display:block!important">
                        * Required
                        </div>
                    </div>
                
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Create new Note</button>
                        <a class="btn btn-secondary" href="<?php echo APP_SERVER;?>/job-list/view/<?php echo $idJob;?>" role="button">Come back to the Job</a>
                    </div>

                </form>
     </div>
</div>
 <script>
document.addEventListener('DOMContentLoaded', function() {
    initializeTrixEditor();
});

function initializeTrixEditor() {
    var editor = document.querySelector("trix-editor");
    if (editor) {
        editor.addEventListener('trix-change', function(event) {
            var descripcio = editor.editor.getDocument().toString();
            document.getElementById('note').value = editor.innerHTML;
        });
    } else {
        //
    }
}

// llançar ajax per guardar dades
document.getElementById("newNote").addEventListener("submit", function(event) {
  formInsert(event, "newNote", "/api/job/post/?type=newNote");

});

noteInfo('<?php echo $idJob; ?>');

function noteInfo(id) {
    let urlAjax = "https://" + window.location.hostname + "/api/job/get/?type&jobId=" + id;
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
                document.getElementById('jobTitle').innerText = `Job: ${data[0].project_name}`;
                document.getElementById('jobNumber').innerText = `Job Number: ${data[0].job_number}`;
            } catch (error) {
                //
            }
        }
    });
}
</script>
