<?php
$info = $data['data']['info'];

$client_name = isset($info) ? $info['client'] : "client name";
$adviser_name = "";
$adviser_fsp_no = "";
$adviser_contact_no = "";
$adviser_email_address = "";
$adviser_address = "";
if (isset($adviserInfo) && sizeof($adviserInfo) >= 1) {
	$adviser_name = $adviserInfo->first_name . " " . $adviserInfo->last_name;
	$adviser_fsp_no = $adviserInfo->fspr_number;
	$adviser_contact_no = $adviserInfo->telephone_no;
	$adviser_email_address = $adviserInfo->email;
	$adviser_address = $adviserInfo->address;
}

$total_score = 0;
$total_question = 0;
$max_score = 0;

for ($i = 1; $i <= 6; $i++) :
	foreach ($data['data']['step' . $i] as $ind => $x) :
		$total_score += $x['value'];
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
		echo "<td width=\"350px\">{$num}. {$x['question']}</td>";
		echo "<td  width=\"175px\">";
		echo "<input type=\"radio\" readonly=\"true\" $zero name=\"{$ind}\" id=\"rqa\" value=\"0\"/><span></span> <label style=\"color:black;\" for=\"rqa\">0</label><br />";
		echo "<input type=\"radio\" readonly=\"true\" $one name=\"{$ind}\" id=\"rqa\" value=\"1\"/><span></span> <label style=\"color:black;\" for=\"rqa\">1</label><br />";
		echo "<input type=\"radio\" readonly=\"true\" $two name=\"{$ind}\" id=\"rqb\" value=\"2\"/><span></span>  <label style=\"color:black;\"  for=\"rqb\">2</label><br /></td>";
		echo "</tr>";

	endforeach;
	echo "</table>";
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

<h2 class="sectionn-title" align="center"><?= strtoupper('file review - ' . $client_name . ' - for '. trim($adviser_name," ")); ?></h2>

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

			$providerArr = $info['providers'];
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

			$productArr = $info['policyType'];
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
</table>
<p></p>
<p></p>

<table nobr="true">
	<tr class="kevin">
		<th><b>Step 1 - Establish and define the relationship with the client</b><br></th>
	</tr>
</table>
<?php createTable($data['data']['step1']); ?>

<table nobr="true">
	<tr class="kevin">
		<th><b>Step 2 - Collect client information (Fact Find and Needs Analysis)</b><br></th>
	</tr>
</table>
<?php createTable($data['data']['step2']); ?>
<p></p>
<table nobr="true">
	<tr class="kevin">
		<th><b>Step 3 - Research, analyse and evaluate information</b><br></th>
	</tr>
</table>
<?php createTable($data['data']['step3']); ?>
<p></p>
<table nobr="true">
	<tr class="kevin">
		<th><b>Step 4 - Develop the advice recommendations and present to the client</b><br></th>
	</tr>
</table>
<?php createTable($data['data']['step4']); ?>
<p></p>
<table nobr="true">
	<tr class="kevin">
		<th><b>Step 5 - Implement the recommendations</b><br></th>
	</tr>
</table>
<?php createTable($data['data']['step5']); ?>
<p></p>
<table nobr="true">
	<tr class="kevin">
		<th><b>Step 6 - Review the client’s situation</b><br></th>
	</tr>
</table>
<?php createTable($data['data']['step6']); ?>