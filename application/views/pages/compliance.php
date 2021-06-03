<?php
$json = json_decode(file_get_contents('./assets/questions.json'));
$step1 = $json->step1;
$step2 = $json->step2;
$step3 = $json->step3;
$step4 = $json->step4;
$step5 = $json->step5;
$step6 = $json->step6;
$policies = array(
    'Life', 'Trauma', 'Progressive Care', 'Trauma Multi',
    'Major Care', 'MMR', 'IP', "Health", "Business Expenses",
    'Key Person Cover', 'TPD', 'Waiver of Premium'
);
?>


<!-- Modal -->

<!-- Button trigger modal -->


<!-- Modal -->

<div class="modal fade" id="complianceModal" tabindex="-1" role="dialog" aria-labelledby="complianceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="complianceModalLabel">Preview Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <iframe src="http://docs.google.com/gview?url=<?= base_url("assets/resources/TEST.pdf"); ?>&embedded=true" style="width: 100%;height:100%"></iframe> -->
                <iframe src="<?= base_url("assets/resources/TEST.pdf"); ?>" style="width: 100%;height:100%"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div id="smartwizard">

    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#info">
                Fill-up<br>
                <small><i class="material-icons">article</i></small>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-1">
                Step 1<br>
                <small><i class="material-icons">article</i></small>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-2">
                Step 2<br>
                <small><i class="material-icons">article</i></small>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-3">
                Step 3<br>
                <small><i class="material-icons">article</i></small>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-4">
                Step 4<br>
                <small><i class="material-icons">article</i></small>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-5">
                Step 5<br>
                <small><i class="material-icons">article</i></small>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-6">
                Step 6<br>
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

                                <label for="">Client Name</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col">
                                <label for="">Adviser</label>
                                <select name="" id="" class="form-control">
                                    <option value="" readonly="true">--Please Select--</option>
                                    <option value="">Kevin</option>
                                    <option value="">Sam</option>
                                    <option value="">Omar</option>
                                </select>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">Policy Type</label>
                                <select name="policyType[]" class="form-control multiselect" multiple="multiple">
                                    <?php foreach ($policies as $x) : ?>
                                        <option value="<?= $x ?>"><?= $x ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="">Providers</label>
                                <select name="" id="" class="form-control">
                                    <option value="" readonly="true">--Please Select--</option>
                                    <option value="">Kevin</option>
                                    <option value="">Sam</option>
                                    <option value="">Omar</option>
                                </select>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Step 1</h4>
                        <p class="card-category"> Establish and define the relationship with the client</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th width="30%">
                                            Elements of the process
                                        </th>
                                        <th width="30%">
                                            Source of the Requirement
                                        </th>
                                        <th width="20%">
                                            Score
                                        </th>
                                        <th width="20%">
                                            Notes
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($step1 as $ind => $x) : ?>
                                        <tr>
                                            <td><?= $x->question; ?></td>
                                            <td><?= $x->source; ?></td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-check form-check-radio">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="<?= "s1$ind"; ?>" value="0">
                                                            0
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-radio">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="<?= "s1$ind"; ?>" value="1">
                                                            1
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-radio">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="<?= "s1$ind"; ?>" value="2">
                                                            2
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                        </div>
                        </td>
                        <td><textarea class="form-control" placeholder="<?= $x->comments; ?>" cols="30" rows="10"></textarea></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title ">Step 2</h4>
                    <p class="card-category">Collect client information (Fact Find and Needs Analysis)</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th width="30%">
                                        Elements of the process
                                    </th>
                                    <th width="30%">
                                        Source of the Requirement
                                    </th>
                                    <th width="20%">
                                        Score
                                    </th>
                                    <th width="20%">
                                        Notes
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($step2 as $ind => $x) : ?>
                                    <tr>
                                        <td><?= $x->question; ?></td>
                                        <td><?= $x->source; ?></td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s2$ind"; ?>" value="0">
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s2$ind"; ?>" value="1">
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s2$ind"; ?>" value="2">
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?= $x->comments; ?>" cols="30" rows="10"></textarea></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title ">Step 3</h4>
                    <p class="card-category">Research, analyse and evaluate information</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th width="30%">
                                        Elements of the process
                                    </th>
                                    <th width="30%">
                                        Source of the Requirement
                                    </th>
                                    <th width="20%">
                                        Score
                                    </th>
                                    <th width="20%">
                                        Notes
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($step3 as $ind => $x) : ?>
                                    <tr>
                                        <td><?= $x->question; ?></td>
                                        <td><?= $x->source; ?></td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s3$ind"; ?>" value="0">
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s3$ind"; ?>" value="1">
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s3$ind"; ?>" value="2">
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?= $x->comments; ?>" cols="30" rows="10"></textarea></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title ">Step 4</h4>
                    <p class="card-category">Develop the advice recommendations and present to the client</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th width="30%">
                                        Elements of the process
                                    </th>
                                    <th width="30%">
                                        Source of the Requirement
                                    </th>
                                    <th width="20%">
                                        Score
                                    </th>
                                    <th width="20%">
                                        Notes
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($step4 as $ind => $x) : ?>
                                    <tr>
                                        <td><?= $x->question; ?></td>
                                        <td><?= $x->source; ?></td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s4$ind"; ?>" value="0">
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s4$ind"; ?>" value="1">
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s4$ind"; ?>" value="2">
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?= $x->comments; ?>" cols="30" rows="10"></textarea></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title ">Step 5</h4>
                    <p class="card-category">Implement the recommendations</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th width="35%">
                                        Elements of the process
                                    </th>
                                    <th>
                                        Source of the Requirement
                                    </th>
                                    <th>
                                        Score
                                    </th>
                                    <th>
                                        Notes
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($step5 as $ind => $x) : ?>
                                    <tr>
                                        <td><?= $x->question; ?></td>
                                        <td><?= $x->source; ?></td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s5$ind"; ?>" value="0">
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s5$ind"; ?>" value="1">
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s5$ind"; ?>" value="2">
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?= $x->comments; ?>" cols="30" rows="10"></textarea></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title ">Step 6</h4>
                    <p class="card-category">Review the client’s situation</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th width="30%">
                                        Elements of the process
                                    </th>
                                    <th width="30%">
                                        Source of the Requirement
                                    </th>
                                    <th width="20%">
                                        Score
                                    </th>
                                    <th width="20%">
                                        Notes
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($step6 as $x) : ?>
                                    <tr>
                                        <td><?= $x->question; ?></td>
                                        <td><?= $x->source; ?></td>
                                        <td>
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s6$ind"; ?>" value="0">
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s6$ind"; ?>" value="1">
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s6$ind"; ?>" value="2">
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?= $x->comments; ?>" cols="30" rows="10"></textarea></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="generatePDF" class="tab-pane" role="tabpanel" aria-labelledby="generatePDF">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title ">Generate</h4>
                    <p class="card-category">Compliance</p>
                </div>
                <div class="card-body">


                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#complianceModal">
                        View PDF
                    </button>



                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>
</div>
<style>
    .modal {
        padding: 0 !important;
    }

    .modal .modal-dialog {
        width: 100%;
        max-width: none;
        height: 100%;
        margin: 0;
    }

    .modal .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
    }

    .modal .modal-body {
        overflow-y: auto;
    }

	.select2-selection--multiple {
		overflow: hidden !important;
		height: auto !important;
        min-height: 0 !important;
	}
</style>