<form id="<?php echo $key; ?>" action="<?php echo base_url().$this->uri->segment(1).'/'.$key; ?>" method="POST" autocomplete="off">    
	<input type="hidden" class="idusers" name="idusers" value="">
    <div class="form-elements-container">
    	<div class="row clearfix">
            <div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">First Name</label>
					<input type="text" id="first_name" name="first_name" class="form-control first_name" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">Middle Name</label>
					<input type="text" id="middle_name" name="middle_name" class="form-control middle_name">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">Last Name</label>
					<input type="text" id="last_name" name="last_name" class="form-control last_name" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">Email address</label>
					<input type="text" id="email" name="email" class="form-control email" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">FSPR Number</label>
					<input type="text" id="fspr_number" name="fspr_number" class="form-control fspr_number" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">Address</label>
					<input type="text" id="address" name="address" class="form-control address" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">Trading Name</label>
					<input type="text" id="trading_name" name="trading_name" class="form-control trading_name" required>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-floating">Telephone No.</label>
					<input type="text" id="telephone_no" name="telephone_no" class="form-control telephone_no" required>
				</div>
			</div>
        </div>      
    </div>


    <div class="text-right" style="width:100%;">
    	<?php if($key == "addAdvisers"): ?>
    		<button class="btn btn-primary btn-sm waves-effect" type="submit">
	            <i class="material-icons">add</i><span> Add</span>
	        </button>
    	<?php endif; ?>
    	<?php if($key == "updateAdvisers"): ?>
	        <button class="btn btn-primary btn-sm waves-effect" type="submit">
	            <i class="material-icons">save</i><span> Update</span>
	        </button>
        <?php endif; ?>
        <button id="cancelUpdateForm" class="btn btn-default btn-sm waves-effect" data-dismiss="modal" type="button">
            <i class="material-icons">close</i><span> Close</span>
        </button>
    </div>
</form>