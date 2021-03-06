<?php

$chat = (isset($chat) && sizeof($chat) >= 1) ? $chat : '';
$info = $data['data']['info'];

$client_name = isset($info) ? $info['client'] : "client name";
$adviser_name = "";
$adviser_fsp_no = "";
$adviser_contact_no = "";
$adviser_email_address = "";
$adviser_address = "";
if (isset($adviserInfo) && count((array)$adviserInfo) >= 1) {
	$adviser_name = $adviserInfo->first_name . " " . $adviserInfo->last_name;
	$adviser_fsp_no = $adviserInfo->fspr_number;
	$adviser_contact_no = $adviserInfo->telephone_no;
	$adviser_email_address = $adviserInfo->email;
	$adviser_address = $adviserInfo->address;
}

$total_score = 0;
$total_question = 0;
$max_score = 0;

$steps = [
	[
		'description' => 'Establish and define the relationship with the client',
	],
	[
		'description' => 'Collect client information (Fact Find and Needs Analysis)',
	],
	[
		'description' => 'Research, analyse and evaluate information',
	],
	[
		'description' => 'Develop the advice recommendations and present to the client',
	],
	[
		'description' => 'Implement the recommendations',
	],
	[
		'description' => 'Review the client’s situation',
	],
];

for ($i = 1; $i <= 6; $i++) :
	foreach ($data['data']['step' . $i] as $ind => $x) :
		$total_score += ($x['value'] == '') ? 0 : $x['value'];

	endforeach;
	$total_question += sizeof($data['data']['step' . $i]);
endfor;

$max_score = $total_question * 2;
$score_percentage = ($total_score / $max_score) * 100;

function createTable($step)
{
	echo "<table width=\"100%\" cellpadding=\"5\">";
	foreach ($step as $ind => $x) :
		$num = $ind + 1;
		echo $trheader = ($ind % 2 == 0) ? "<tr class=\"ff-tbl-alt\">" : "<tr>";
		$zero = ($x['value'] == "0") ? "checked=\"true\"" : "";
		$one = ($x['value'] == "1") ? "checked=\"true\"" : "";
		$two = ($x['value'] == "2") ? "checked=\"true\"" : "";
		$num = $ind + 1;
		echo "<td style=\"text-align: right\" width=\"5%\">{$num}.</td>";
		echo "<td style=\"text-align: justify\" width=\"55%\">{$x['question']}</td>";

		echo "<td  width=\"5%\">";
		echo "<input type=\"radio\" readonly=\"true\" $zero name=\"{$ind}\" id=\"rqa\" value=\"0\"/><span></span> <label style=\"color:black;\" for=\"rqa\">0</label><br />";
		echo "<input type=\"radio\" readonly=\"true\" $one name=\"{$ind}\" id=\"rqa\" value=\"1\"/><span></span> <label style=\"color:black;\" for=\"rqa\">1</label><br />";
		echo "<input type=\"radio\" readonly=\"true\" $two name=\"{$ind}\" id=\"rqb\" value=\"2\"/><span></span>  <label style=\"color:black;\"  for=\"rqb\">2</label><br />";
		echo "</td>";
		if ($x['notes']) {
			echo "<td width=\"35%\">";
			echo $x['notes'];
			echo "</td>";
		} else {
			echo "<td width=\"35%\">&nbsp;</td>";	
		}
		
		echo "</tr>";

	endforeach;
	echo "</table>";
}

function getStepScore($step)
{
	$maxScore = count($step) * 2;

	$scoreValues = array_column($step, 'value');
	$totalScore = array_sum($scoreValues);

	return [
		'value' => $totalScore,
		'max' => $maxScore,
	];
}

?>
<style type="text/css">
	body {
		font-family: arial;
		margin: auto;
		display: block;
		position: relative
	}

	label {
		display: block;
		color: black !important;
	}

	p,
	li {
		font-size: 1.15em;
	}

	.kevin {
		font-size: 1.15em;
	}

	.inline {
		display: inline !important
	}

	.pagebreak {
		margin-top: 30px;
		margin-bottom: 30px
	}

	.pull-left {
		float: left
	}

	.pull-right {
		float: right
	}

	.width-25 {
		width: 25%
	}

	.width-50 {
		width: 45%
	}

	.width-40 {
		width: 40%
	}

	.width-60 {
		width: 60%
	}

	.width-30 {
		width: 30%
	}

	.width-70 {
		width: 70%
	}

	.width-100 {
		width: 100%
	}

	.clearfix {
		clear: both
	}

	.text-center {
		text-align: center
	}

	.text-left {
		text-align: left
	}

	.text-right {
		text-align: right
	}

	.text-uppercase {
		text-transform: uppercase
	}

	.red {
		color: #347Ab8
	}

	.pale {
		opacity: .5
	}

	label {
		color: #777;
		border-bottom: 1px solid #ddd;
		text-transform: uppercase;
		font-size: .7em;
		margin-bottom: 10px;
		margin-left: 10px;
		margin-right: 10px
	}

	.value {
		display: block;
		margin-top: 5px;
		padding: 10px;
		padding-top: 5px;
		margin-top: 0px;
		font-size: .9em;
		margin-bottom: 20px;
		margin-right: 10px
	}

	.normal-weight {
		font-weight: normal;
		font-size: 1.1em;
	}

	.text-center.normal-weight.red {
		text-align: left
	}

	tr th {
		text-align: left;
		padding: 10px
	}

	tr th label {
		display: block;
		padding: 0px;
		border: none;
		margin-left: 0;
		margin-bottom: 0
	}

	.table .value {
		margin-bottom: 0
	}

	.table.bordered td,
	.table.bordered th {
		border: 1px solid #ddd
	}
</style>
<style>
	.sectionn-title {
		padding: 0%;
		margin: 0%;
		color: #205478;
		letter-spacing: 3px;
		font-weight: 300;
		text-transform: uppercase;
		border-bottom: 1px solid #205478;
	}

	.tbl-title {
		padding: 5px 0px 5px 0px;
	}

	.tbl-title td {
		color: #999;
		font-size: 95%;
		text-transform: uppercase;
	}

	.tbl-value {
		border: 1px solid #999;
		padding: 5px;
		font-size: 95%;
	}

	.ff-table th {
		background-color: #205478;
		color: #fff;
		text-transform: uppercase;
		letter-spacing: 1px;
		font-size: 95%;
	}

	.ff-tbl-alt td {
		background-color: #eee;
	}

	ul>li {
		font-size: 95%;
	}
</style>

<table width="100%" cellspacing="5">
	<tr>
		<td width="100%" align="right">
			<?php

			echo '<img src="' . base_url() . 'assets/img/img.png" style="width: 75px;" />';

			?>
		</td>
	</tr>
</table>

<h2 class="sectionn-title" align="center"><?= strtoupper('file review - ' . $client_name . ' - for ' . trim($adviser_name, " ")); ?></h2>

<p></p>
<table class="table ff-table" style="font-size:115%" cellpadding="5" nobr="true">
	<tr class="ff-tbl-alt">
		<td width="25%">Name of Financial Adviser:</td>
		<td width="25%"><?php echo $adviser_name; ?></td>

		<td width="25%">Financial Advice Provider Name:</td>
		<td width="25%">Eliteinsure Limited trading as Eliteinsure</td>

	</tr>

	<tr>
		<td width="25%">FSP Number:</td>
		<td width="25%"><?php echo $adviser_fsp_no; ?></td>

		<td width="25%">FAP FSP Number:</td>
		<td width="25%">706272</td>
	</tr>
	<tr class="ff-tbl-alt">
		<td width="25%">Contact Number:</td>
		<td width="25%"><?php echo $adviser_contact_no; ?></td>

		<td width="25%">FAP Contact Number:</td>
		<td width="25%">0508 123 467</td>
	</tr>

	<tr>
		<td width="25%">Email Address:</td>
		<td width="25%"><?php echo $adviser_email_address; ?></td>

		<td width="25%">FAP email address:</td>
		<td width="25%">admin@eliteinsure.co.nz</td>
	</tr>


	<tr class="ff-tbl-alt">
		<td width="25%">Physical address:</td>
		<td width="25%"><?php echo $adviser_address; ?></td>

		<td width="25%">Total Score:</td>
		<td width="25%"><?php echo $total_score . "/" . $max_score . " (" . number_format($score_percentage, 2) . "%)"; ?></td>
	</tr>


</table>
<p></p>
<br><br>
<table nobr="true">
	<tr class="kevin">
		<th><b>Client Information </b><br></th>
	</tr>

</table>
<table nobr="true" style="font-size:115%;" cellpadding="5px">

	<tr style="background-color: #eee;">

		<th>Product Providers</th>
		<th style="color: #205478">
			<?php

			$providerArr = isset($info['providers']) ? $info['providers'] : array();
			$provderStr = array();
			foreach ($providerArr as $x) {
				$query = $this->db->query('SELECT * FROM company_provider WHERE idcompany_provider="' . $x . '"');
				if ($query->num_rows() > 0) {
					$result = $query->result();
					foreach ($result as $elem) {
						array_push($provderStr, $elem->company_name);
					}
				}
			}

			echo implode(', ', $provderStr);
			?>
		</th>
	</tr>
	<tr>
		<th>Products Involved</th>
		<!-- <th style="color: #205478"><?= implode(",", $info['policyType']); ?></th> -->
		<th style="color: #205478">
			<?php

			$productArr = isset($info['policyType']) ? $info['policyType'] : array();
			$productStr = array();
			foreach ($productArr as $x) {
				$query = $this->db->query('SELECT * FROM product_category WHERE idproduct_category="' . $x . '"');
				if ($query->num_rows() > 0) {
					$result = $query->result();
					foreach ($result as $elem) {
						array_push($productStr, $elem->name);
					}
				}
			}
			echo implode(', ', $productStr);
			?>
		</th>

	</tr>
	<tr style="background-color: #eee;">
		<th>Compliance officer checking</th>
		<th style="color: #205478"><?= $added_by; ?></th>
	</tr>
	<tr>
		<th>Policy Number</th>
		<th style="color: #205478"><?= $info['policyNumber']; ?></th>
	</tr>
	<tr style="background-color: #eee;">
		<th>Replacement of Cover</th>
		<th style="color: #205478"><?= $info['replacement']; ?></th>
	</tr>
</table>


<p></p>
<p></p>

<?php
foreach ($steps as $index => $step) {

	$stepNum = $index + 1;
	$score = getStepScore($data['data']['step' . ($stepNum)]);


?>
	<table nobr="true">
		<tr class="kevin">
			<th width="85%">
				<b>Step <?php echo ($stepNum); ?> - <?php echo $step['description'] ?> </b>
				<i><?php echo ($info["training_needed_{$stepNum}"]) == "true" ? "<span color=\"red\">(Training is needed)</span>" : "" ?></i>
				<br>
			</th>
			<th width="15%"><b>Score: <?php echo $score['value'] . '/' . $score['max'] ?></b></th>
		</tr>
	</table>
	<?php
	if ($info["showstep_{$stepNum}"] == "true") :
		createTable($data['data']['step' . ($stepNum)]);
	else :
		echo "<table width=\"100%\" cellpadding=\"5\">";
		echo "<tr class=\"ff-tbl-alt\"><td style=\"color:red\"><strong>Results currently pending. </strong> </td></tr>";
		echo "</table>";
	endif;
	?>
	<br><br>
<?php
}

?>

<?php if($chat != '') : ?>
	<table nobr="true">
		<thead>
			<tr class="kevin">
				<th><b>Notes:</b></th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($chat as $k => $v) : 
				$datetime = date_format(date_create($chat[$k]['timestamp']),"d F Y - h:i:s A"); 
				$sender_name = $chat[$k]['sender'] == 0 ? $chat[$k]['user_name'] : $adviser_name;
		?>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td><?php echo $sender_name." (".$datetime.") "; ?></td>
			</tr>
			<tr>
				<td style="text-align:justify;"><?php echo "- ".$chat[$k]['message']; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>   