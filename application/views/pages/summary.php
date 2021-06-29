<style>
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
</style>

<input type="hidden" name="summary_id" value="" />
<input type="hidden" name="filename" value="" />
<input type="hidden" name="adviser_str" value="" />

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
                <button id="save-btn" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div id="smartwizard-summary">
	<ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#info">
                Fill-up<br>
                <small><i class="material-icons">article</i></small>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#generatePDF">
                Generate<br>
                <small><i class="material-icons">article</i></small>
            </a>
        </li>
    </ul>

    <div class="tab-content">

    	<div id="info" class="tab-pane" role="tabpanel" aria-labelledby="info">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title">Information</h4>
                        <p class="card-category">Kindly fill-up necessary information</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
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
                            <div class="col">
                                <label for="">Replacement of Cover</label>
                                <select name="replacement" id="" class="form-control">
                                    <option value="" readonly="true"></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">                                
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
                            <div class="col">
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

                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="">Date From</label>
                                <input type="date" id="date_from" class="form-control date_from" name="date_from" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                            <div class="col">
                                <label for="">Date Until</label>
                                <input type="date" id="date_until" class="form-control date_until" name="date_until" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="generatePDF" class="tab-pane" role="tabpanel" aria-labelledby="generatePDF">
	        <div class="row">
	            <div class="col-md-12">
	                <div class="card">
	                    <div class="card-header card-header-info">
	                        <h4 class="card-title ">Generate</h4>
	                        <p class="card-category">Summary</p>
	                    </div>
	                    <!-- <div class="card-body d-flex justify-content-between"> -->
	                    <div class="card-body d-flex">
	                        <button type="button" class="btn btn-info mx-3 btn-block" id="generateSummary">
	                            Generate Summary
	                        </button>
	                        <button id="viewPdf" type="button" class="btn btn-primary disabled mx-3 btn-block" data-toggle="modal" data-target="#summaryModal" disabled>
	                            View PDF
	                        </button>


	                        <button id="sendPdf" type="button" class="btn btn-danger disabled mx-3 btn-block" disabled>
	                            Send PDF
	                        </button>

	                    </div>
	                </div>

	            </div>
	        </div>
	    </div>

    </div>
</div>