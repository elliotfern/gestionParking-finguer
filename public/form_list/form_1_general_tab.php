<div id="tab1" style="background-color: white;border:1px solid #dee2e6; border-top:none;display:block!important">
    <div class="container quadre2">
        <div class="row g-4">

          <h5>Business Information:</h5>

              <div class="col-6">
                <label for="client_name" class="form-label bold">Client Name:</label>
                <input type="text" class="form-control" id="client_name" name="client_name" readonly>
              </div>

              <div class="col-6">
                <label for="company_name" class="form-label bold">Business Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" readonly>
              </div>

              <div class="col-12">
                <label for="address" class="form-label bold">Business Address:</label>
                <input type="text" class="form-control" id="address" name="address" readonly>
              </div>

              <div class="col-6">
                <label for="email" class="form-label bold">Email:</label>
                <input type="text" class="form-control" id="email" name="email" readonly>
              </div>

              <div class="col-6">
                <label for="phone" class="form-label bold">Phone number:</label>
                <input type="text" class="form-control" id="phone" name="phone" readonly>
              </div>

              <div class="col-6">
                <label for="vatNumber" class="form-label bold">VAT Number:</label>
                <input type="text" class="form-control" id="vat_number" name="vat_number" readonly>
              </div>

              <div class="col-6">
                <label for="poNumber" class="form-label bold">PO Number:</label>
                <input type="text" class="form-control" id="po_number" name="po_number" readonly>
              </div>

              <hr>
              <h5>Project information:</h5>

              <div class="col-12" style="margin-top:20px;margin-bottom:20px;">
                  <h6 class="bold">Who are the decision makers for this project?</h6>
                  <div class="form-group">
                    <textarea class="form-control" id="cq1" name="cq1" rows="3" value="" readonly></textarea>
                </div>
                  </div>

                  <div class="col-12" id="cq2" style="margin-top:20px;margin-bottom:20px;">
                    <h6 class="bold">Are there any committees/stakeholders that will need to be consulted? </h6>

                    <div class="form-check">
                            <input class="form-check-input" type="radio" name="cq2" id="cq2a" value="1" readonly>
                            <label class="form-check-label" for="cRadio">Yes</label>
                    </div>

                    <div class="form-check">
                            <input class="form-check-input" type="radio" name="cq2" id="cq2b" value="2" readonly>
                            <label class="form-check-label" for="dRadio">No</label>
                    </div>
                  </div>

                  <div class="col-12" style="margin-top:20px;margin-bottom:20px">
                    <h6 class="bold">Who are they?</h6>
                    <div class="form-group">
                      <textarea class="form-control" id="cq2_1" name="cq2_1" rows="3" value="" readonly></textarea>
                    </div>
                  </div>

                  <div class="col-12" style="margin-top:20px;margin-bottom:20px;">
                    <h6 class="bold">Do you have a timeline within which you would like to have your project completed?</h6>
                    <div class="form-group">
                      <textarea class="form-control" id="cq3" name="cq3" rows="3" value="" readonly></textarea>
                    </div>
                  </div>

                  <div class="col-12" style="margin-top:20px;margin-bottom:20px;">
                    <h6 class="bold">What is your budget allocation for this project?</h6>
                    <p>Once we have determined your goals, it is important for us to know what can and cannot be achieved within your allocated budgets. 
                    </p>
                    <div class="form-group">
                      <textarea class="form-control" id="cq4" name="cq4" rows="3" value="" readonly></textarea>
                    </div>
                  </div>

        <!-- BUTTON NEXT / TO TAB2 -->
        <div class="col-3" style="margin-top:25px">
        <button type="button" class="btn btn-primary" id="btnNext">Next</button>
        </div>

    </div>
  </div>
</div>