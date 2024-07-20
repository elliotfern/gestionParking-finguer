<?php
$id = $params['id'];

// ID USER from cookie
$idUser = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;
?>

<div class="container-fluid">
    <h1>Update Note</h1>
    <h2 id="jobTitle"></h2>
    <h5 id="jobNumber"></h5>

    <div class="alert alert-success" id="creaOk" style="display:none" role="alert">
        <h4 class="alert-heading"><strong>Note update OK!</strong></h4>
        <h6>Note update successfully.</h6>
    </div>

    <div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
        <h4 class="alert-heading"><strong>Error</strong></h4>
        <h6>Some data is not correct.</h6>
    </div>

    <form action="" method="POST" id="updateNote">
        <input type="hidden" id="idUser" name="idUser" value="<?php echo $idUser; ?>">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

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
                <button type="submit" class="btn btn-primary" id="btnEditNote">Edit Note</button>
                <a class="btn btn-secondary" href="" role="button" id="btnComeBack">Come back to the Job</a>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    noteInfo('<?php echo $id; ?>');

    document.getElementById('updateNote').addEventListener('submit', function(event) {
        updateNote(event);
    });

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
        console.error('No se encontró el editor Trix en el documento.');
    }
}

function noteInfo(id) {
    let urlAjax = "https://" + window.location.hostname + "/api/job/get/?type=noteInfo&noteId=" + id;
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
                document.getElementById('note').value = data[0].note;
                document.querySelector("trix-editor").editor.loadHTML(data[0].note);

                let jobId = data[0].idJob;
                let comeBackButton = document.getElementById('btnComeBack');
                comeBackButton.href = `https://${window.location.hostname}/job-list/view/${jobId}`;

                document.getElementById('jobTitle').innerText = data[0].project_name;
                document.getElementById('jobNumber').innerText = data[0].job_number;
            } catch (error) {
                console.error('Error al parsear JSON:', error);  // Muestra el error de parsing
            }
        }
    });
}

function updateNote(event) {
    event.preventDefault();
    const url = `https://${window.location.hostname}/api/job/put/?type=updateNote`;
    const formData = new FormData(document.getElementById('updateNote'));
    const jsonData = JSON.stringify(Object.fromEntries(formData));

    $.ajax({
        contentType: "application/json",
        type: "PUT",
        url: url,
        dataType: "JSON",
        data: jsonData,
        beforeSend: function (xhr) {
            let token = localStorage.getItem('token');
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        },
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
                }
            }
        }
    });
}
</script>
