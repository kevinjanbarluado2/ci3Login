<?php
$json = json_decode(file_get_contents('./assets/questions.json'));
$step1 = $json->step1;
$step2 = $json->step2;
$step3 = $json->step3;
$step4 = $json->step4;
$step5 = $json->step5;
$step6 = $json->step6;
//from edit
$data = ($data !== NULL) ? $data : "";
$editPolicyType = isset($data->policy_type)?explode(",",$data->policy_type):array();
$editProviders = isset($data->providers)?explode(",",$data->providers):array();

$answers = isset($data->answers)?json_decode($data->answers):(object) array();
$editstep1 = isset($answers->step1)?$answers->step1:array();
$editstep2 = isset($answers->step2)?$answers->step2:array();
$editstep3 = isset($answers->step3)?$answers->step3:array();
$editstep4 = isset($answers->step4)?$answers->step4:array();
$editstep5 = isset($answers->step5)?$answers->step5:array();
$editstep6 = isset($answers->step6)?$answers->step6:array();

?>


<!-- Modal -->

<!-- Button trigger modal -->


<!-- Modal -->

<input type="hidden" name="results_id" value="<?=(!empty($data->results_id))?$data->results_id:'';?>" />
<input type="hidden" name="filename" value="<?=(!empty($data->filename))?$data->filename:'';?>" />
<input type="hidden" name="complianceOfficer" value="<?= $_SESSION['name']; ?>">

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
                <iframe id="pdfHere" src="<?= base_url("assets/resources/preview.pdf"); ?>" style="width: 100%;height:100%"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="save-btn" type="button" class="btn btn-primary">Save changes</button>

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
                                <input type="text" name="client" class="form-control" value="<?=(!empty($data->clients))?$data->clients:'';?>">
                            </div>
                            <div class="col">
                                <label for="">Adviser</label>
                                <select name="adviser" id="" class="form-control select2-info">
                                    <option value="" readonly="true"></option>
                                    <?php if (isset($advisers) && sizeof($advisers) >= 1) : ?>
                                        <?php foreach ($advisers as $k => $v) : ?>
                                            <option value="<?php echo $advisers[$k]['idusers']; ?>" <?=(!empty($data->adviser_id)&&$advisers[$k]['idusers']==$data->adviser_id)?"selected":'';?>>
                                                <?php
                                                $full_name = $advisers[$k]['last_name'] . ", " . $advisers[$k]['first_name'] . " " . ((isset($advisers[$k]['middle_name']) && $advisers[$k]['middle_name'] <> "") ? substr($advisers[$k]['middle_name'], 0, 1) . "." : "");
                                                echo $full_name;
                                                ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col">                                
                                <label for="">Policy Type</label>
                                <select name="policyType" class="form-control multiselect" multiple="multiple">
                                    <?php if (isset($policies) && sizeof($policies) >= 1) : ?>
                                        <?php foreach ($policies as $k => $v) : ?>
                                            <option value="<?php echo $policies[$k]['idproduct_category']; ?>" <?=(in_array($policies[$k]['idproduct_category'],$editPolicyType))?'selected':'';?>>
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
                                            <option value="<?php echo $providers[$k]['idcompany_provider']; ?>" <?=(in_array($providers[$k]['idcompany_provider'],$editProviders))?'selected':'';?>>
                                                <?php echo $providers[$k]['company_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">Policy Number</label>
                                <input type="text" name="policyNumber" class="form-control" value="<?=(!empty($data->policy_number))?$data->policy_number:'';?>">
                            </div>
                            <div class="col">
                                <label for="">Replacement of Cover</label>
                                <select name="replacement" id="" class="form-control">
                                    <option value="" <?=(!empty($data->replacement)&&$data->replacement=="")?"selected":'';?> readonly="true"></option>
                                    <option value="Yes" <?=(!empty($data->replacement)&&$data->replacement=="Yes")?"selected":'';?>>Yes</option>
                                    <option value="No" <?=(!empty($data->replacement)&&$data->replacement=="No")?"selected":'';?>>No</option>
                                    <option value="N/A" <?=(!empty($data->replacement)&&$data->replacement=="N/A")?"selected":'';?>>N/A</option>
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
                                    <?php foreach ($step1 as $ind => $x) { ?>
                                        <tr>
                                            <td class="align-top"><?php echo $x->question; ?></td>
                                            <td class="align-top"><?php echo $x->source; ?></td>
                                            <td class="align-top">
                                                <div class="form-group">
                                                    <div class="form-check form-check-radio">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="<?= "s1_$ind"; ?>" value="0" <?=((isset($editstep1[$ind]->value))&&$editstep1[$ind]->value=="0")?'checked':'';?>>
                                                            0 
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-radio">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="<?= "s1_$ind"; ?>" value="1" <?=((isset($editstep1[$ind]->value))&&$editstep1[$ind]->value=="1")?'checked':'';?>>
                                                            1
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-radio">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="<?= "s1_$ind"; ?>" value="2" <?=((isset($editstep1[$ind]->value))&&$editstep1[$ind]->value=="2")?'checked':'';?>>
                                                            2
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                        </div>
                        </td>
                        <td><textarea class="form-control" placeholder="<?php echo $x->comments; ?>" cols="30" rows="10"><?=(isset($editstep1[$ind]->notes))?$editstep1[$ind]->notes:''?></textarea></td>
                        </tr>
                    <?php } ?>
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
                                <?php foreach ($step2 as $ind => $x) { ?>
                                    <tr>
                                        <td class="align-top"><?php echo $x->question; ?></td>
                                        <td class="align-top"><?php echo $x->source; ?></td>
                                        <td class="align-top">
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s2_$ind"; ?>" value="0" <?=((isset($editstep2[$ind]->value))&&$editstep2[$ind]->value=="0")?'checked':'';?>>
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s2_$ind"; ?>" value="1" <?=((isset($editstep2[$ind]->value))&&$editstep2[$ind]->value=="1")?'checked':'';?>>
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s2_$ind"; ?>" value="2" <?=((isset($editstep2[$ind]->value))&&$editstep2[$ind]->value=="2")?'checked':'';?>>
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?php echo $x->comments; ?>" cols="30" rows="10"><?=(isset($editstep2[$ind]->notes))?$editstep2[$ind]->notes:''?></textarea></textarea></td>
                                    </tr>
                                <?php } ?>
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
                                <?php foreach ($step3 as $ind => $x) { ?>
                                    <tr>
                                        <td class="align-top"><?php echo $x->question; ?></td>
                                        <td class="align-top"><?php echo $x->source; ?></td>
                                        <td class="align-top">
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s3_$ind"; ?>" value="0" <?=((isset($editstep3[$ind]->value))&&$editstep3[$ind]->value=="0")?'checked':'';?>>
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s3_$ind"; ?>" value="1" <?=((isset($editstep3[$ind]->value))&&$editstep3[$ind]->value=="1")?'checked':'';?>>
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s3_$ind"; ?>" value="2" <?=((isset($editstep3[$ind]->value))&&$editstep3[$ind]->value=="2")?'checked':'';?>>
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-top relative">
                                            <textarea class="form-control h-100" placeholder="<?php echo $x->comments; ?>" cols="30" rows="10"><?=(isset($editstep3[$ind]->notes))?$editstep3[$ind]->notes:''?></textarea></textarea>
                                        </td>
                                    </tr>
                                <?php } ?>
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
                                <?php foreach ($step4 as $ind => $x) { ?>
                                    <tr>
                                        <td class="align-top"><?php echo $x->question; ?></td>
                                        <td class="align-top"><?php echo $x->source; ?></td>
                                        <td class="align-top">
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s4_$ind"; ?>" value="0" <?=((isset($editstep4[$ind]->value))&&$editstep4[$ind]->value=="0")?'checked':'';?>>
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s4_$ind"; ?>" value="1" <?=((isset($editstep4[$ind]->value))&&$editstep4[$ind]->value=="1")?'checked':'';?>>
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s4_$ind"; ?>" value="2" <?=((isset($editstep4[$ind]->value))&&$editstep4[$ind]->value=="2")?'checked':'';?>>
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?php echo $x->comments; ?>" cols="30" rows="10"><?=(isset($editstep4[$ind]->notes))?$editstep4[$ind]->notes:''?></textarea></textarea></td>
                                    </tr>
                                <?php } ?>
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
                                <?php foreach ($step5 as $ind => $x) { ?>
                                    <tr>
                                        <td class="align-top"><?php echo $x->question; ?></td>
                                        <td class="align-top"><?php echo $x->source; ?></td>
                                        <td class="align-top">
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s5_$ind"; ?>" value="0" <?=((isset($editstep5[$ind]->value))&&$editstep5[$ind]->value=="0")?'checked':'';?>>
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s5_$ind"; ?>" value="1" <?=((isset($editstep5[$ind]->value))&&$editstep5[$ind]->value=="1")?'checked':'';?>>
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s5_$ind"; ?>" value="2" <?=((isset($editstep5[$ind]->value))&&$editstep5[$ind]->value=="2")?'checked':'';?>>
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?php echo $x->comments; ?>" cols="30" rows="10"><?=(isset($editstep5[$ind]->notes))?$editstep5[$ind]->notes:''?></textarea></td>
                                    </tr>
                                <?php } ?>
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
                                <?php foreach ($step6 as $ind => $x) { ?>
                                    <tr>
                                        <td class="align-top"><?php echo $x->question; ?></td>
                                        <td class="align-top"><?php echo $x->source; ?></td>
                                        <td class="align-top">
                                            <div class="form-group">
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s6_$ind"; ?>" value="0" <?=((isset($editstep6[$ind]->value))&&$editstep6[$ind]->value=="0")?'checked':'';?>>
                                                        0
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s6_$ind"; ?>" value="1" <?=((isset($editstep6[$ind]->value))&&$editstep6[$ind]->value=="1")?'checked':'';?>>
                                                        1
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="<?= "s6_$ind"; ?>" value="2" <?=((isset($editstep6[$ind]->value))&&$editstep6[$ind]->value=="2")?'checked':'';?>>
                                                        2
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td><textarea class="form-control" placeholder="<?php echo $x->comments; ?>" cols="30" rows="10"><?=(isset($editstep6[$ind]->notes))?$editstep6[$ind]->notes:''?></textarea></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
                        <p class="card-category">Compliance</p>
                    </div>
                    <!-- <div class="card-body d-flex justify-content-between"> -->
                    <div class="card-body d-flex">
                        <button type="button" class="btn btn-info mx-3 btn-block" id="generateCompliance">
                            Generate Compliance
                        </button>
                        <button id="viewPdf" type="button" class="btn btn-primary disabled mx-3 btn-block" data-toggle="modal" data-target="#complianceModal" disabled>
                            View PDF
                        </button>


                        <button id="sendPdf" type="button" class="btn btn-danger disabled mx-3 btn-block" disabled>
                            Send PDF
                        </button>

                    </div>
                    <div class="card-footer card-footer-info">
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

    #step-3 span.bmd-form-group {
        position: absolute;
        top: 0;
        bottom: 4px;
        left: 0;
        right: 0;
    }
</style> 