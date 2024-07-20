<?php
// ID USER from cookie
$user_id = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : null;

// Allowed users
$allowedUserIds = array(1,4); // Caroline, Tina
?>


<h1>Client list</h1>
<div class="col-3" style="margin-top:20px;margin-bottom:20px">
    <a class="btn btn-primary" href="<?php echo APP_SERVER;?>/client-list/new" role="button">Create new Client</a>
</div>

<?php
if (in_array($user_id, $allowedUserIds)) {
?>
<div class="container-fluid">
<table class="table table-striped datatable" id="clientsListTable">
        <thead class="table-primary">
        <tr>
            <th></th>
            <th>Client Name</th>
            <th>Business Name</th>
            <th>Business Address</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Mobile</th>
            <th>VAT Number</th>
            <th>PO Number</th>
            <th></th>
            <th></th>
    </tr>
    </thead>
    <tbody>
    <tr>
       
    </tr>
 </tbody>
    </table>

    </div>


<?php
} else {
  echo '
  <div class="alert alert-danger" role="alert">

    <p>You do not have access to this page. If you need information about a client write an email to <a href="mailto:caroline@designedly.ie">caroline@designedly.ie.</a></p>

    </div>';
}
?>

</div>