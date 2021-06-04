<form id="<?php echo $key; ?>" action="<?php echo base_url().$this->uri->segment(1).'/'.$key; ?>" method="POST" autocomplete="off">    
	<input type="hidden" class="id" name="id" value="">
    <div class="form-elements-container">
    	<div class="row clearfix">
            <div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">Name</label>
					<input type="text" id="company_name" name="company_name" class="form-control company_name" required>
				</div>
			</div>
        </div>      
    </div>


    <div class="text-right" style="width:100%;">
    	<?php if($key == "add"): ?>
    		<button class="btn btn-primary btn-sm waves-effect" type="submit">
	            <i class="material-icons">add</i><span> Add</span>
	        </button>
    	<?php endif; ?>
    	<?php if($key == "update"): ?>
	        <button class="btn btn-primary btn-sm waves-effect" type="submit">
	            <i class="material-icons">save</i><span> Update</span>
	        </button>
        <?php endif; ?>
        <button id="cancelUpdateForm" class="btn btn-default btn-sm waves-effect" data-dismiss="modal" type="button">
            <i class="material-icons">close</i><span> Close</span>
        </button>
    </div>
</form>