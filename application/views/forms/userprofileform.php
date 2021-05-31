<form id="<?php echo $key; ?>" action="<?php echo base_url().$this->uri->segment(1).'/'.$key; ?>" method="POST" autocomplete="off">    
	<input type="hidden" class="id" name="id" value="">
    <div class="form-elements-container">
    	<div clas="row">
    		<div class="col-md-12">
    			<div class="row">
    				<div class="col-md-6">
	    				<div class="row clearfix">
				            <div class="col-md-12">
								<div class="form-group bmd-form-group">
									<label class="bmd-label-floating">Name</label>
									<input type="text" id="name" name="name" class="form-control name" required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group bmd-form-group">
									<label class="bmd-label-floating">Email address</label>
									<input type="text" id="email" name="email" class="form-control email" required>
								</div>
							</div>
							<?php if($key != "viewUserProfile"): ?>
							<div class="col-md-12">
								<div class="form-group bmd-form-group">
									<label class="bmd-label-floating">Password</label>
									<input type="password" id="password" name="password" class="form-control password" required>
								</div>
							</div>
							<?php endif; ?>
							<div class="col-md-12">
								<div class="form-group bmd-form-group">
									<label class="bmd-label-floating">Privileges</label>
									<input type="text" id="privileges" name="privileges" class="form-control privileges" readonly required>
								</div>
							</div>
				        </div>
		    		</div>
		    		<div class="col-md-6">
		    			<div class="row clearfix">
				        	<div class="col-md-12">
				        		<table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
					        		<thead>
					        			<th colspan="3" style="text-align: center;"><strong>Privileges</strong></th>
					        		</thead>
					        		<tbody>
					        			<?php foreach ($privileges as $k => $v) : ?>
					        				<tr>
					        					<td>
					        						<div class="togglebutton">
														<label>
															<input id="checkbox_<?php echo $privileges[$k]['name'] ?>" type="checkbox" data-value="<?php echo $privileges[$k]['name']; ?>">
															<span class="toggle"></span>
														</label>
													</div>
					        					</td>
					        					<td><?php echo $privileges[$k]['name']; ?></td>
					        					<td><?php echo $privileges[$k]['description']; ?></td>
					        				</tr>
					        			<?php endforeach; ?>
					        		</tbody>
					        	</table>
				        	</div>
				        </div>
		    		</div>
    			</div>
    		</div>	
    	</div>	        
    </div>


    <div class="text-right" style="width:100%;">
    	<?php if($key == "addUserProfile"): ?>
    		<button class="btn btn-primary btn-sm waves-effect" type="submit">
	            <i class="material-icons">add</i><span> Add</span>
	        </button>
    	<?php endif; ?>
    	<?php if($key == "updateUserProfile"): ?>
	        <button class="btn btn-primary btn-sm waves-effect" type="submit">
	            <i class="material-icons">save</i><span> Update</span>
	        </button>
        <?php endif; ?>
        <button id="cancelUpdateForm" class="btn btn-default btn-sm waves-effect" data-dismiss="modal" type="button">
            <i class="material-icons">close</i><span> Close</span>
        </button>
    </div>
</form>

<script>
	function setTwoNumberDecimal(event) {
    	this.value = parseFloat(this.value).toFixed(2);
	}
</script>