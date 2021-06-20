<?php
	print_r($result_arr);
	foreach ($result_arr as $k => $v) {
		if($filename == '')
			$filename = $adviser_arr[$k]->first_name." ".$adviser_arr[$k]->last_name;
		else
			$filename .= ', '.$adviser_arr[$k]->first_name." ".$adviser_arr[$k]->last_name;
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
		<?php foreach ($adviser_arr as $k => $v) : ?>
			<tr>
				<td><?php echo $adviser_arr[$k]->first_name." ".$adviser_arr[$k]->last_name; ?></td>
				<td>test</td>
				<td>test</td>
				<td>test</td>
				<td><?php echo $added_by; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>