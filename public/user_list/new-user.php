
            <div class="container-fluid">
                <h1>New Intranet User</h1>
                <?php
    echo '<div class="alert alert-success" id="creaOk" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>New user OK!</h4></strong>
                  <h6>New user create successfully.</h6>
                  </div>';
          
    echo '<div class="alert alert-danger" id="creaErr" style="display:none" role="alert">
                  <h4 class="alert-heading"><strong>Error</h4></strong>
                  <h6>Some data is not correct.</h6>
                  </div>';
    ?>

                <form action="" method="POST" id="newUser" >
                <div class="row g-4 quadre">

                <div class="col-6">
                    <label for="name">Name</label>
                    <input type="name" name="name" id="name" class="form-control">
                    <div class="invalid-feedback" id="name_error" style="display:block!important">
                        * Required
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" id="email" class="form-control">
                        <div class="invalid-feedback" id="email_error" style="display:block!important">
                        * Required
                        </div>
                    </div>

                    <div class="col-6">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <div class="invalid-feedback" id="password_error" style="display:block!important">
                        * Required
                        </div>
                    </div>
                    
                    <div class="col-6">
                    <label for="access">Type of user</label>
                    <select class="form-select" name="access" id="access">
                        <option selected value="0">Select an option:</option>
                        <option value="1">Managing Director</option>
                        <option value="2">Web & Design Development</option>
                        <option value="3">Brand & Design</option>
                        <option value="4">Social Media</option>
                    </select>
                    <div class="invalid-feedback" id="access_error" style="display:block!important">
                        * Required
                        </div>
                    </div>

                    <div class="col-3">
                    <button type="submit" class="btn btn-primary">Create new user</button>
                    </div>
                
                </form>
     </div>
</div>
 <script>


// SEND DATA TO API
document.getElementById("newUser").addEventListener("submit", function(event) {
  formInsert(event, "newUser", "/api/users/post/?type=user");
});

</script>
