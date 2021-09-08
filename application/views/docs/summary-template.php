<style>
	.main-tbl, .main-tbl th, .main-tbl td {
	  border: 1px solid black;
	  border-collapse: collapse; 
	  font-size:9px;
	}

	.section-title {
		padding: 0%;
		margin: 0%;
		color: #205478;
		letter-spacing: 3px;
		font-weight: 300;
		text-transform: uppercase;
		border-bottom: 1px solid #205478;
	}
</style>

<h2 class="section-title" align="center">File Review Report</h2>

<p></p>

<table class="main-tbl" cellpadding="5">
	<thead>
		<tr>
			<th align="center" valign="middle" style="width:14%">Client Name</th>
			<th align="center" valign="middle" style="width:7%">Step 1</th>
			<th align="center" valign="middle" style="width:7%">Step 2</th>
			<th align="center" valign="middle" style="width:7%">Step 3</th>
			<th align="center" valign="middle" style="width:7%">Step 4</th>
			<th align="center" valign="middle" style="width:7%">Step 5</th>
			<th align="center" valign="middle" style="width:7%">Step 6</th>
			<th align="center" valign="middle" style="width:7%">Total Score</th>
			<th align="center" valign="middle" style="width:15%">Policy type sold</th>
			<th align="center" valign="middle" style="width:15%">Provider</th>
			<th align="center" valign="middle" style="width:7%">Replacement</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $k => $v) : ?>
		<tr>
			<td align="left" valign="middle" style="width:14%"><?php echo $data[$k]['clients']; ?></td>
			<td align="center" valign="middle" style="width:7%"><?php echo $data[$k]['step1']; ?></td>
			<td align="center" valign="middle" style="width:7%"><?php echo $data[$k]['step2']; ?></td>
			<td align="center" valign="middle" style="width:7%"><?php echo $data[$k]['step3']; ?></td>
			<td align="center" valign="middle" style="width:7%"><?php echo $data[$k]['step4']; ?></td>
			<td align="center" valign="middle" style="width:7%"><?php echo $data[$k]['step5']; ?></td>
			<td align="center" valign="middle" style="width:7%"><?php echo $data[$k]['step6']; ?></td>
			<td align="center" valign="middle" style="width:7%"><?php echo $data[$k]['total_score']; ?></td>
			<td align="left" valign="middle" style="width:15%">
				<?php 
					echo str_replace(",","<br><br>",$data[$k]['policy_type']); 
				?>
			</td>
			<td align="left" valign="middle" style="width:15%">
				<?php 
					echo str_replace(",","<br><br>",$data[$k]['providers']); 
				?>
			</td>
			<td align="left" valign="middle" style="width:7%"><?php echo $data[$k]['replacement']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
