<style>
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

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header card-header-info">
					<h4 class="card-title">PDF</h4>
					<p class="card-category">Manage PDF Files</p>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
                            <label for="">Filter</label>
                            <select name="filter" id="filter" class="form-control filter select2">
                                <option value="compliance" selected>Compliance PDF</option>
                                <option value="summary">Summary PDF</option>
                            </select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 compliance-div">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive" style="width:100%;overflow-x: hidden;">
								<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead class=" text-primary">
										<tr>
											<th width="20%">Client Name</th>
											<th width="20%">Adviser</th>
											<th>File Name</th>
											<th width="10%">Score</th>
											<th>Date Created</th>
											<th width="15%">Action</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
							

				</div>
			</div>
		</div>

		<div class="col-md-12 summary-div" style="display:none">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive" style="width:100%;overflow-x: hidden;">
								<table id="datatables-summary" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead class=" text-primary">
										<tr>
											<th width="35%">File Name</th>
											<th width="35%">Adviser/s</th>
											<th>Date Created</th>
											<th width="15%">Action</th>
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