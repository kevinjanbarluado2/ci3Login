<?php
	foreach ($result_arr as $k => $v) {
		if($filename == '')
			$filename = $result_arr[$k]['adviser_first_name']." ".$result_arr[$k]['adviser_last_name'];
		else
			$filename .= ', '.$result_arr[$k]['adviser_first_name']." ".$result_arr[$k]['adviser_last_name'];
	}

	$filename = "Summary of ".$filename;
?>

<style>
	.main-tbl,.main-tbl th,.main-tbl td {
	  border: 1px solid black;
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

<h2 class="sectionn-title" align="center"><?= strtoupper(trim($filename," ")); ?></h2>

<p></p>

<table class="main-tbl">
	<thead>
		<tr>
			<th>Adviser</th>
			<th>Policy Type</th>
			<th>Providers</th>
			<th>Replacement Cover</th>
			<th>Compliance Officer</th>
			<th>Score</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result_arr as $k => $v) : ?>
			<tr>
				<td>
					<?php 
						echo $result_arr[$k]['adviser_first_name']." ".$result_arr[$k]['adviser_last_name']; 
					?>
				</td>
				<td>
				<?php
					foreach ($providers_arr[$result_arr[$k]['adviser_id']] as $k1 => $v1) {
						echo $providers_arr[$result_arr[$k]['adviser_id']][$k1]."<br>";
					}
				?>	
				</td>
				<td>
				<?php
					foreach ($policy_arr[$result_arr[$k]['adviser_id']] as $k1 => $v1) {
						echo $policy_arr[$result_arr[$k]['adviser_id']][$k1]."<br>";
					}
				?>		
				</td>
				<td><?php echo $result_arr[$k]['replacement']; ?></td>
				<td><?php echo $added_by; ?></td>
				<td><?php echo $result_arr[$k]['score']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>