<style>
	@media (min-width: 768px) {
	  .modal-xl {
	    width: 90%;
	   max-width:1200px;
	  }
	}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-info">
					<h4 class="card-title">User Profile</h4>
					<p class="card-category">Manage User Profile</p>

				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<a id="addUserProfileForm" style="text-decoration:none;" href="<?php echo base_url().'/UserProfile/addUserProfileForm'; ?>">
	                            <button type="button" class="btn btn-info btn-raised btn-round pull-right">
	                                <i class="material-icons">person_add</i>&nbsp;&nbsp;
	                                <span> Add Record</span>
	                            </button>
	                        </a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive" style="width:100%;overflow-x: hidden;">
								<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead class=" text-primary">
										<tr>
											<th>Name</th>
											<th>Email</th>
											<th>Privileges</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
							

				</div>
			</div>
		</div>
	</div>
</div>