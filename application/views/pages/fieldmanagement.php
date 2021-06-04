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
					<h4 class="card-title">Field Management</h4>
					<p class="card-category">Manage Dropdowns</p>

				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
                            <label for="">Filter</label>
                            <select name="filter" id="filter" class="form-control filter select2">
                                <option value="" selected disabled="">-- Select dropdown field --</option>
                                <option value="provider">Provider</option>
                                <option value="policy-type-sold">Policy Type Sold</option>
                            </select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="table-div" class="col-md-12" style="display:none">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<a id="addForm" class="addForm"style="text-decoration:none;">
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
								<table id="datatables" class="filter-table table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead class=" text-primary">
										<tr>
											<th>Name</th>
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