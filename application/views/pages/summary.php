<style>
html{
    height: 100%;
}

body{ 
    margin:0;
    padding:0;
    overflow:hidden;
    height:100%;
}

button:disabled {
  cursor: not-allowed;
  pointer-events: all !important;
}
#summaryModal {
  padding: 0 !important; 
}
#summaryModal .modal-dialog {
  width: 100%;
  max-width: none;
  height: 100%;
  margin: 0;
}
#summaryModal .modal-content {
  height: 100%;
  border: 0;
  border-radius: 0;
}
#summaryModal .modal-body {
  overflow-y: auto;
}
@keyframes spinner-border {
  to { transform: rotate(360deg); }
} 
.spinner-border{
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: .2em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    -webkit-animation: spinner-border .75s linear infinite;
    animation: spinner-border .75s linear infinite;
}
.spinner-border-sm{
    height: 1rem;
    border-width: .2em;
}
.details-control {cursor: pointer;}

.pdf-preview {
  padding: 0 !important; 
}
.pdf-preview .modal-dialog {
  width: 100%;
  max-width: none;
  height: 100%;
  margin: 0;
}
.pdf-preview .modal-content {
  height: 100%;
  border: 0;
  border-radius: 0;
}
.pdf-preview .modal-body {
  overflow-y: auto;
}

.chartdiv {
  width: 100%;
  height: 500px;
}

</style>

<input type="hidden" name="summary_id" value="" />
<input type="hidden" name="filename" value="" />
<input type="hidden" name="adviser_str" value="" />
<input type="hidden" name="result_str" value="" />
<input type="hidden" name="complianceOfficer" value="<?= $_SESSION['name']; ?>">

<!-- Modal -->
<div class="modal fade pdf-preview" id="complianceModal" tabindex="-1" role="dialog" aria-labelledby="complianceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="complianceModalLabel">Preview Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="pdfHere" src="<?= base_url("assets/resources/preview.pdf"); ?>" style="width: 100%;height:100%"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summaryModalLabel">Preview Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <iframe src="http://docs.google.com/gview?url=<?= base_url("assets/resources/TEST.pdf"); ?>&embedded=true" style="width: 100%;height:100%"></iframe> -->
                <iframe id="pdfHere" src="<?= base_url("assets/resources/preview.pdf"); ?>" style="width: 100%;height:100%"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <!--  <button id="save-btn" type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">

    <div id="info" class="tab-pane" role="tabpanel" aria-labelledby="info">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Information</h4>
                    <p class="card-category">Kindly fill-up necessary information</p>
                </div>
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-md-6">
                            <label for="">Filter by:</label>
                            <select name="filter" id="" class="form-control filter single-select">
                                <option value="1">Show All</option>
                                <option value="2">By Adviser</option>
                            </select>
                        </div>
                    </div>
                    <hr> -->
                    <div class="row not-client-row">
                        <div class="col-md-6">
                            <label for="">Adviser</label>
                            <select name="adviser" id="" class="form-control multiselect" multiple="multiple">
                                <option value="" readonly="true"></option>
                                <?php if (isset($advisers) && sizeof($advisers) >= 1) : ?>
                                    <?php foreach ($advisers as $k => $v) : ?>
                                        <option value="<?php echo $advisers[$k]['idusers']; ?>">
                                            <?php
                                            $full_name = $advisers[$k]['last_name'] . ", " . $advisers[$k]['first_name'] . " " . ((isset($advisers[$k]['middle_name']) && $advisers[$k]['middle_name'] <> "") ? substr($advisers[$k]['middle_name'], 0, 1) . "." : "");
                                            echo $full_name;
                                            ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Replacement of Cover</label>
                            <select name="replacement" id="" class="form-control">
                                <option value="" readonly="true">All</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>

                        <div class="col-md-6">                                
                            <label for="">Policy Type</label>
                            <select name="policyType" class="form-control multiselect" multiple="multiple">
                                <?php if (isset($policies) && sizeof($policies) >= 1) : ?>
                                    <?php foreach ($policies as $k => $v) : ?>
                                        <option value="<?php echo $policies[$k]['idproduct_category']; ?>">
                                            <?php echo $policies[$k]['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Providers</label>
                            <select name="providers" id="" class="form-control multiselect" multiple="multiple">
                                <option value="" readonly="true"></option>
                                <?php if (isset($providers) && sizeof($providers) >= 1) : ?>
                                    <?php foreach ($providers as $k => $v) : ?>
                                        <option value="<?php echo $providers[$k]['idcompany_provider']; ?>">
                                            <?php echo $providers[$k]['company_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>

                        </div>

                        <div class="col-md-6">
                            <label for="">Date From</label>
                            <input type="date" id="date_from" class="form-control date_from" name="date_from" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="">Date Until</label>
                            <input type="date" id="date_until" class="form-control date_until" name="date_until" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                    </div>
                    <div class="row client-row" style="display: none">
                        <div class="col-md-6">
                            <label for="">Client</label>
                            <select name="client" id="" class="form-control multiselect" multiple="multiple">
                                <option value="" readonly="true"></option>
                                <?php if (isset($advisers) && sizeof($advisers) >= 1) : ?>
                                    <?php foreach ($advisers as $k => $v) : ?>
                                        <option value="<?php echo $advisers[$k]['idusers']; ?>">
                                            <?php
                                            $full_name = $advisers[$k]['last_name'] . ", " . $advisers[$k]['first_name'] . " " . ((isset($advisers[$k]['middle_name']) && $advisers[$k]['middle_name'] <> "") ? substr($advisers[$k]['middle_name'], 0, 1) . "." : "");
                                            echo $full_name;
                                            ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button id="summary-filter" class="btn btn-info" style="width:100%">Apply Filter</button>
                        </div>
                        <div class="col-md-6">
                            <button id="summary-printout" class="btn btn-warning" data-toggle="modal" data-target="#summaryModal" style="width:100%" disabled="disabled">
                                Print Summary
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row start-disp">
        <div class="col-md-12 filtered-tbl" style="display:none">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">File Review Report</h4>
                </div>
                <div class="card-body">
                    <div class="row filtered-body">
                        <div class="col-md-12">
                            <div class="table-responsive" style="width:100%;">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                                    <thead class="text-primary">
                                        <tr>
                                            <th></th>
                                            <th>Client name</th>
                                            <th>Step 1</th>
                                            <th>Step 2</th>
                                            <th>Step 3</th>
                                            <th>Step 4</th>
                                            <th>Step 5</th>
                                            <th>Step 6</th>
                                            <th>Total score</th>
                                            <th>Action</th>
    <!--                                         <th>Replacement</th>
                                            <th>Policy type sold</th>
                                            <th>Provider</th>
                                            <th>Action</th> -->
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 tally-tbl" style="display:none">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">File Review Summary</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" style="border-left: 12px solid #5C5CFF;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Score result summary</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th width="30%">Passed</th>
                                        <th width="30%">Failed</th>
                                    </tr>
                                </thead>
                                <tbody class="step-score-body"></tbody>
                            </table>       
                        </div>
                        <div class="col-md-6">
                            <div id="step-chart-div" class="chartdiv"></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 policy-type-div" style="border-left: 12px solid #5C5CFF;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Policy Type</th>
                                    </tr>
                                </thead>
                                <tbody class="policy-type-body"></tbody>
                            </table>       
                        </div>
                        <div class="col-md-6">
                            <div id="policy-chart-div" class="chartdiv"></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6" style="border-left: 12px solid #5C5CFF;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Provider</th>
                                    </tr>
                                </thead>
                                <tbody class="providers-body"></tbody>
                            </table>       
                        </div>
                        <div class="col-md-6">
                            <div id="providers-chart-div" class="chartdiv"></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6" style="border-left: 12px solid #5C5CFF;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Replacement of Cover</th>
                                    </tr>
                                </thead>
                                <tbody class="replacement-body" class="chartdiv"></tbody>
                            </table>       
                        </div>
                        <div class="col-md-6">
                            <div id="replacement-chart-div" class="chartdiv"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>   
</div>