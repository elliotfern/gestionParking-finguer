<div class="container-fluid">
    <h1>New Client</h1>

    <div class="alert alert-success" id="creaClientOk" style="display:none" role="alert">
        <h4 class="alert-heading"><strong>New client OK!</h4></strong>
        <h6>New client create successfully.</h6>
    </div>

    <div class="alert alert-danger" id="creaClientErr" style="display:none" role="alert">
        <h4 class="alert-heading"><strong>Error</h4></strong>
        <h6>Check the fields, some information is not correct.</h6>
    </div>

    <form action="" method="POST" id="newClient">
        <div class="row g-4 quadre">
            <div class="col-6">
                <label for="client_name" class="bold">Client Name:</label>
                <input type="text" name="client_name" id="client_name" class="form-control">
                <div class="invalid-feedback" id="client_name_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <div class="col-6">
                <label for="business_name" class="bold">Business Name:</label>
                <input type="name" name="business_name" id="business_name" class="form-control">
                <div class="invalid-feedback" id="business_name_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <hr>


            <div class="col-6">
                <label for="business_address" class="bold">Business Address:</label>
                <input type="text" name="business_address" id="business_address" class="form-control">
            </div>

            <div class="col-6">
                <label for="billing_address" class="bold">Billing Address:</label>
                <input type="text" name="billing_address" id="billing_address" class="form-control">
            </div>

            <hr>

            <div class="col-6">
                <label for="email" class="bold">E-mail:</label>
                <input type="text" name="email" id="email" class="form-control">
                <div class="invalid-feedback" id="email_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <div class="col-6">
                <label for="phone" class="bold">Phone:</label>
                <input type="text" name="phone" id="phone" class="form-control">
                <div class="invalid-feedback" id="phone_error" style="display:block!important">
                    * Required
                </div>
            </div>

            <div class="col-6">
                <label for="phone" class="bold">Mobile:</label>
                <input type="text" name="mobile" id="mobile" class="form-control">
            </div>

            <hr>

            <div class="col-6">
                <label for="vat_number" class="bold">VAT Number:</label>
                <input type="text" name="vat_number" id="vat_number" class="form-control">
            </div>

            <div class="col-6">
                <label for="po_number" class="bold">PO Number:</label>
                <input type="text" name="po_number" id="po_number" class="form-control">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary" id="newClientBtn">Create new Client</button>
            </div>
        </div>

    </form>
</div>