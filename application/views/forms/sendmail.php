<style>
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
</style>

<input type="hidden" class="adviser_id" name="adviser_id" value="">
<input type="hidden" class="filename" name="filename" value="">
<input type="hidden" name="complianceOfficer" value="<?= $_SESSION['name']; ?>">

<div class="form-elements-container">
	<div class="row clearfix">
        <div class="col-md-12">
			<div class="form-group bmd-form-group">
				Do you want to re-send this email?
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-12">
			<div class="form-group">
	            <div class="form-check form-check-radio">
	                <label class="form-check-label">
	                    Include Adviser in email?
	                    <input class="form-check-input" type="checkbox" name="includeAdviser">
	                    <span class="circle">
	                        <span class="check"></span>
	                    </span>
	                </label>
	            </div>
	        </div>
		</div>
	</div>
</div>

<div class="text-right" style="width:100%;">
    <button id="<?php echo $key; ?>" class="btn btn-primary btn-sm waves-effect" type="button" href="<?php echo base_url().'Compliance/'.$key; ?>">
        <i class="material-icons">mail</i><span> Yes</span>
    </button>
    <button id="cancelUpdateForm" class="btn btn-default btn-sm waves-effect" data-dismiss="modal" type="button">
        <i class="material-icons">close</i><span> No</span>
    </button>
</div>
