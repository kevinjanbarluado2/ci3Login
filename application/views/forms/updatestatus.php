<form id="<?php echo $key; ?>" action="<?php echo base_url().$this->uri->segment(1).'/'.$key; ?>" method="POST" autocomplete="off">    
	<input type="hidden" class="results_id" name="results_id" value="">
    <div class="form-elements-container">
    	<div class="row clearfix">
    		<div class="col-md-12">
                <label for="">Status</label>
                <select name="score_status" id="" class="form-control select2 score_status">
                    <option value="Based on percentage">Based on percentage</option>
                    <option value="Passed">Passed</option>
                    <option value="Failed">Failed</option>
                </select>
            </div>
        </div>      
    </div>


    <div class="text-right" style="width:100%;">
        <button class="btn btn-primary btn-sm waves-effect" type="submit">
            <i class="material-icons">save</i><span> Update</span>
        </button>
        <button id="cancelUpdateForm" class="btn btn-default btn-sm waves-effect" data-dismiss="modal" type="button">
            <i class="material-icons">close</i><span> Close</span>
        </button>
    </div>
</form>