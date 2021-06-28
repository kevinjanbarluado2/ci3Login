<?php
    foreach ($result_arr as $k => $v) {
        if ('' == $filename) {
            $filename = $result_arr[$k]['adviser_first_name'] . ' ' . $result_arr[$k]['adviser_last_name'];
        } else {
            $filename .= ', ' . $result_arr[$k]['adviser_first_name'] . ' ' . $result_arr[$k]['adviser_last_name'];
        }
    }

    $filename = 'Summary of ' . $filename;
?>

<style>
	.main-tbl, .main-tbl th, .main-tbl td {
	  border: 1px solid black;
	  border-collapse: collapse;
	}
</style>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<h2 class="sectionn-title" align="center"><?php echo strtoupper(trim($filename, ' ')); ?></h2>

<p></p>

<table class="main-tbl" cellpadding="5">
	<thead>
		<tr>
			<th align="center">Adviser</th>
			<th align="center">Policy Type</th>
			<th align="center">Providers</th>
			<th align="center">Replacement Cover</th>
			<th align="center">Compliance Officer</th>
			<th align="center">Score</th>
			<th align="center">Percentage</th>
			<th align="center">Date Generated</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($result_arr as $k => $v) { ?>
			<tr>
				<td>
					<?php
                        echo $result_arr[$k]['adviser_first_name'] . ' ' . $result_arr[$k]['adviser_last_name'];
                    ?>
				</td>
				<td>
				<?php
                    foreach ($policy_arr[$result_arr[$k]['adviser_id']] as $k1 => $v1) {
                        echo $policy_arr[$result_arr[$k]['adviser_id']][$k1] . '<br>';
                    }
                ?>		
				</td>
				<td>
				<?php
                    foreach ($providers_arr[$result_arr[$k]['adviser_id']] as $k1 => $v1) {
                        echo $providers_arr[$result_arr[$k]['adviser_id']][$k1] . '<br>';
                    }
                ?>	
				</td>				
				<td><?php echo $result_arr[$k]['replacement']; ?></td>
				<td><?php echo $added_by; ?></td>
				<td><?php echo $result_arr[$k]['score']; ?></td>
				<td><?php echo $result_arr[$k]['percentage'] ?? 'N/A'; ?></td>
				<td><?php echo $result_arr[$k]['created_at'] ?? 'N/A'; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
