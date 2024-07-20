<div id="tab1" style="display:block!important">
    <div class="container quadre4">
        <div class="row g-4">

              <div class="col-12">
                <h5><span class="bold section">Business Information</span></h5>
              </div>

              <div class="col-12 col-md-6">
                <h6 class="bold">Client Name<span class="red">*</span></h6>
                <input type="text" class="form-control" id="client_name" name="client_name" autocomplete="name">
                <div class="invalid-feedback" id="client_name_error" style="display:block!important">
                    
                </div>
              </div>

              <div class="col-12 col-md-6">
                <h6 class="bold">Business Name<span class="red">*</span></h6>
                <input type="text" class="form-control" id="company_name" name="company_name">
                <div class="invalid-feedback" id="company_name_error" style="display:block!important">
                   
                </div>
              </div>

              <div class="col-12">
                <h6 class="bold">Business Address<span class="red">*</span></h6>
                <input type="text" class="form-control" id="address" name="address" autocomplete="address-line1">
                <div class="invalid-feedback" id="address_error" style="display:block!important">
                   
                </div>
              </div>

              <div class="col-12 col-md-6">
                <h6 class="bold">Email<span class="red">*</span></h6>
                <input type="text" class="form-control" id="email" name="email" autocomplete="email">
                <div class="invalid-feedback" id="email_error" style="display:block!important">
                   
                </div>
              </div>

              <div class="col-12 col-md-6">
                <h6 class="bold">Phone number<span class="red">*</span></h6>
                <input type="text" class="form-control" id="phone" name="phone" autocomplete="tel">
                <div class="invalid-feedback" id="phone_error" style="display:block!important">
                  
                </div>
              </div>

              <div class="col-12 col-md-6">
                <h6 class="bold">VAT Number</h6>
                <input type="text" class="form-control" id="vat_number" name="vat_number">
              </div>

              <div class="col-12 col-md-6">
                <h6 class="bold">PO Number</h6>
                <input type="text" class="form-control" id="poNumber" name="poNumber">
              </div>

              <div class="col-12">
              <hr>
              </div>

              <div class="col-12">
                <h5><span class="bold section">Project information</span></h5>
              </div>


              <div class="col-12" id="cq1" style="margin-top:20px;margin-bottom:20px;">
                  <h6 class="bold">Who are the decision makers for this project?<span class="red">*</span></h6>
                  <div class="form-group">
                    <textarea class="form-control auto-resize" id="cq1_q" name="cq1" rows="3"></textarea>
                </div>
                <div class="invalid-feedback" id="cq1_error" style="display:block!important">
                    
                     </div>
                  </div>

                  <div class="col-12" id="cq2" style="margin-top:20px;margin-bottom:20px;">
                    <h6 class="bold">Are there any committees/stakeholders that will need to be consulted?<span class="red">*</span></h6>

                    <div class="form-check">
                            <input class="form-check-input" type="radio" name="cq2" id="cq2a" value="1">
                            <label class="form-check-label" for="cq2a">Yes</label>
                    </div>

                    <div class="form-check">
                            <input class="form-check-input" type="radio" name="cq2" id="cq2b" value="2">
                            <label class="form-check-label" for="cq2b">No</label>
                    </div>

                    <div class="invalid-feedback" id="cq2_error" style="display:block!important">
                      
                     </div>
                  </div>

                  <div class="col-12" id="cq2_1" style="margin-top:20px;margin-bottom:20px;display:none">
                    <h6 class="bold">Who are they?<span class="red">*</span></h6>
                    <div class="form-group">
                      <textarea class="form-control auto-resize" id="cq2_1_q" name="cq2_1" rows="3"></textarea>
                    </div>
                    <div class="invalid-feedback" id="cq2_1_error" style="display:block!important">
                      
                    </div>
                  </div>

                  <div class="col-12" id="cq3" style="margin-top:20px;margin-bottom:20px;">
                    <h6 class="bold">Do you have a timeline within which you would like to have your project completed?</h6>
                    <div class="form-group">
                      <textarea class="form-control auto-resize" id="cq3_q" name="cq3" rows="3"></textarea>
                    </div>
                  </div>

                  <div class="col-12" id="cq4" style="margin-top:20px;margin-bottom:20px;">
                    <h6 class="bold">What is your budget allocation for this project?</h6>
                    <p>Once we have determined your goals, it is important for us to know what can and cannot be achieved within your allocated budgets. 
                    </p>
                    <div class="form-group">
                      <textarea class="form-control auto-resize" id="cq4_q" name="cq4" rows="3"></textarea>
                    </div>
                  </div>

          <!-- BUTTON NEXT / TO TAB2 -->
          <div class="col-3" style="margin-top:25px">
          <button type="button" class="btn btn-secondary nextBtn" id="btnNext">Next</button>
          </div>

    </div>
  </div>
</div>