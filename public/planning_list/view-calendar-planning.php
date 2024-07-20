<?php
// ID USER from cookie
$year = isset($params['year']) ? intval($params['year']) : null;
$month = isset($params['month']) ? intval($params['month']) : null;
$day = isset($params['day']) ? intval($params['day']) : null;

$month_number = $month;
$day_number = $day;

// Función para obtener el sufijo del día
function getDaySuffix($day) {
    if (!in_array(($day % 100), [11, 12, 13])) {
        switch ($day % 10) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
        }
    }
    return 'th';
}

// Construir la fecha con el sufijo correcto
$daySuffix = getDaySuffix($day);

function monthNumberToName($monthNumber) {
    $monthNames = array(
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    );

    // Verificar si el número de mes está dentro del rango válido
    if ($monthNumber >= 1 && $monthNumber <= 12) {
        return $monthNames[$monthNumber];
    } else {
        return 'Invalid month number';
    }
}
$monthName = monthNumberToName($month);
?>

<h1>Planning tasks</h1>
<h4>Schedule set up</h4>
<h5><?php echo $day . $daySuffix;?> <?php echo $monthName;?> <?php echo $year;?></h5> 

<a href="<?php echo APP_WEB;?>/planning-list/new/" class="btn btn-primary" role="button" aria-disabled="true">Assign task</a>

<div class="container-fluid">
    <!-- Primera fila con 3 tablas -->
    <div class="row g-9 mb-3">
        <div class="col-md-4">
            <table class="table table-striped datatable" id="table-1">
                <thead class="table-secondary">
                <tr>
                    <th colspan="2" class="text-center">Caroline</th>
                </tr>
                <tr class="text-center">
                    <th>Job</th>
                    <th>Hours</th> 
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>
                </tbody>
            </table>
            <a href="<?php echo APP_WEB;?>/planning-list/new/1/<?php echo $year;?>/<?php echo $month_number;?>/<?php echo $day_number;?>" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Assign job to Caroline</a>
        </div>

        <div class="col-md-4">
            <table class="table table-striped datatable" id="table-7">
                <thead class="table-secondary">
                <tr>
                    <th colspan="2" class="text-center">James</th>
                </tr>
                <tr class="text-center">
                    <th>Job</th>
                    <th>Hours</th> 
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>
                </tbody>
            </table>
            <a href="<?php echo APP_WEB;?>/planning-list/new/7/<?php echo $year;?>/<?php echo $month_number;?>/<?php echo $day_number;?>" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Assign job to James</a>
        </div>

        <div class="col-md-4">
            <table class="table table-striped datatable" id="table-3">
                <thead class="table-secondary">
                <tr>
                    <th colspan="2" class="text-center">Geraldine</th>
                </tr>
                <tr class="text-center">
                    <th>Job</th>
                    <th>Hours</th> 
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>
                </tbody>
            </table>
            <a href="<?php echo APP_WEB;?>/planning-list/new/3/<?php echo $year;?>/<?php echo $month_number;?>/<?php echo $day_number;?>" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Assign job to Geraldine</a>
        </div>

    </div>

    <!-- Segunda fila con 3 tablas -->
    <div class="row g-9 mb-3">
         
        <div class="col-md-4">
            <table class="table table-striped datatable" id="table-5">
                <thead class="table-secondary">
                <tr>
                    <th colspan="2" class="text-center">Sarah</th>
                </tr>
                <tr class="text-center">
                        <th>Job</th>
                        <th>Hours</th> 
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>
                </tbody>
            </table>
            <a href="<?php echo APP_WEB;?>/planning-list/new/5/<?php echo $year;?>/<?php echo $month_number;?>/<?php echo $day_number;?>" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Assign job to Sarah</a>
        </div>

        <div class="col-md-4">
            <table class="table table-striped datatable" id="table-6">
                <thead class="table-secondary">
                <tr>
                    <th colspan="2" class="text-center">Olivia</th>
                </tr>
                <tr class="text-center">
                    <th>Job</th>
                    <th>Hours</th> 
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>
                </tbody>
            </table>
            <a href="<?php echo APP_WEB;?>/planning-list/new/6/<?php echo $year;?>/<?php echo $month_number;?>/<?php echo $day_number;?>" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Assign job to Olivia</a>
        </div>

        <div class="col-md-4">
            <table class="table table-striped datatable" id="table-2">
                <thead class="table-secondary">
                <tr>
                    <th colspan="2" class="text-center">Elliot</th>
                </tr>
                <tr class="text-center">
                    <th>Job</th>
                    <th>Hours</th> 
                </tr>
                </thead>
                <tbody>
                <tr>
                </tr>
                </tbody>
            </table>
            <a href="<?php echo APP_WEB;?>/planning-list/new/2/<?php echo $year;?>/<?php echo $month_number;?>/<?php echo $day_number;?>" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Assign job to Elliot</a>
        </div>
    </div>

    <!-- Tercera fila con 1 tabla -->
    <div class="row">
        <div class="col-md-4 offset-md-4">
        <table class="table table-striped datatable" id="table-4">
                <thead class="table-secondary">
                <tr>
                    <th colspan="2" class="text-center">Tina</th>
                </tr>
                <tr class="text-center">
                    <th>Job</th>
                    <th>Hours</th> 
            </tr>
            </thead>
            <tbody>
            <tr>
            </tr>
             </tbody>
        </table>
        <a href="<?php echo APP_WEB;?>/planning-list/new/4/<?php echo $year;?>/<?php echo $month_number;?>/<?php echo $day_number;?>" class="btn btn-secondary btn-sm" role="button" aria-disabled="true">Assign job to Tina</a>
        </div>
    </div>

</div>


<hr>
<h4>Select another day</h4>
<div class="row">
        <div class="col-md-4 offset-md-4">
             <label for="jobId" class="bold">Select a Day: </label>
                        <select class="form-select" id="daySelect" name="daySelect">
                       <option value='' unselected>Open the dropdown</option>";
                        <?php 
                global $conn;
                $sql = "SELECT 
                    DATE_FORMAT(date, '%d') AS day, 
                    DATE_FORMAT(date, '%m') AS month, 
                    DATE_FORMAT(date, '%Y') AS year,
                    date
                    FROM 
                        planning_tasks
                    GROUP BY 
                        date
                    ORDER BY 
                    date";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Mostrar los nombres como opciones en el select
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='". APP_WEB . "/planning-list/view/". $row['year'] . "/". $row['month'] . "/". $row['day'] . "/'>" . $row['day'] . "/" . $row['month'] . "/" . $row['year'] . "</option>";
                }
?>
                       </select>
            </div>
            </div>

<style>
    table.dataTable.display tbody tr.status-1.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.status-1.even > .sorting_1
{
    background-color: transparent;
}

table.dataTable.display tbody tr.total.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.total.odd > .sorting_1
 {
    background-color: transparent;
}

    .total {
        font-weight: bold;
        background-color: #f2f2f2; /* Cambia el color de fondo según tu preferencia */
    }
</style>

<script>

document.getElementById('daySelect').addEventListener('change', function() {
            var selectedValue = this.value;
            if (selectedValue) {
                window.location.href = selectedValue;
            }
        });

$(document).ready(function () {
    // Llama a la función para cargar los datos en todas las tablas
    loadTableData('1');
    loadTableData('2');
    loadTableData('3');
    loadTableData('4');
    loadTableData('5');
    loadTableData('6');
    loadTableData('7');

});

function loadTableData(tableNumber) {
    $.fn.dataTableExt.errMode = 'ignore';

    // Construye la URL para la petición AJAX
    let server = window.location.hostname;
    let urlAjax = "https://" + server + "/api/planning/get/?type=planningDate&user=" + tableNumber + "&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>";


    // Selecciona el ID de la tabla correspondiente
    let tableId = "#table-" + tableNumber;

    // Inicializa la tabla DataTable
    $(tableId).DataTable({
        searching: false, // Para deshabilitar la función de búsqueda
        lengthChange: false, // Para deshabilitar la opción de "Entries per page"
        paging: false, // Para deshabilitar la paginación
        info: false, // Para deshabilitar el texto de información sobre las entradas
        keys: true,
        stateSave: true, // Habilitar el guardado del estado
        ajax: {
            url: urlAjax,
            type: "GET",
            dataSrc: "",
            dataType: "json",
            beforeSend: function (xhr) {
                // Obtener el token del localStorage
                let token = localStorage.getItem('token');

                // Incluir el token en el encabezado de autorización
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
        },
        columns: [
            { data: "job_info" },
            { data: "hours" }
        ],

        columnDefs: [
            {
            orderable: false,
            targets: [0, 1],
            },
        ],

        // Otras opciones de configuración de la tabla
        drawCallback: function(settings) {
            // Modificar el estilo de la fila que contiene "Total Hours"
            $(tableId + ' tbody tr').each(function () {
                if ($(this).find('td:first').text().trim() === 'Total Hours') {
                    $(this).addClass('total');
                }
            });

            // Agregar manualmente una fila para "Total Hours" si no existe en los datos de la tabla
            if (!$(tableId + ' tbody tr:contains("Total Hours")').length) {
                let totalRow = '<tr class="total"><td>Total Hours</td><td>0</td></tr>';
                $(tableId + ' tbody').append(totalRow);
            }
        }
    });
}
</script>