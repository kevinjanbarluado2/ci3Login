<?php 
$info = $data['data']['info'];

?>
<!DOCTYPE html>
<html lang="en">
<body>
	<div class="page-header">
		<table class="header">
			<tr width="100px">
				<td class="header-left-box">
					&nbsp;
				</td>
				<td class="header-image"><img src="<?=FCPATH.'assets/img/logo-only.png';?>" height="73" />
				</td>
				<td class="header-title">COMPLIANCE RESULT
				</td>
				<td class="header-right-box">
					&nbsp;
				</td>
			</tr>
		</table>
	</div>
	
	<div class="margin">
		<table class="w-full text-lg text-tblue font-bold mb-8">
			<tbody>
				<tr>
					<td class="w-half">
						Adviser <span class="underline"><?=$info['adviser']?></span>
					</td>
					<td class="w-half">
						Date <span class="underline">3rd June, 2021</span>
					</td>
				</tr>
				<tr>
					<td>
						Client <span class="underline"><?=$info['client']?></span>
					</td>
					<td>
						Score <span class="underline">100</span>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="mt-4">
			<div class="bg-lmara p-4 text-white font-bold">
				<span class="text-lg">Step [N]</span> Insert step [N] desc
			</div>
			<table class="w-full">
				<tr>
					<td class="p-4 w-full">Question 1</td>
					<td class="p-4 nowrap">
						<label>
							0 <input name="answer1" type="radio" checked>
						</label>
						&emsp;
						<label>
							1<input name="answer1" type="radio">
						</label>
						&emsp;
						<label>
							2 <input name="answer1" type="radio">
						</label>
					</td>
				</tr>
			</table>
			<table class="w-full">
				<tr>
					<td class="p-4 w-full">Question 2</td>
					<td class="p-4 nowrap">
						<label>
							0 <input name="answer2" type="radio" checked>
						</label>
						&emsp;
						<label>
							1<input name="answer2" type="radio">
						</label>
						&emsp;
						<label>
							2 <input name="answer2" type="radio">
						</label>
					</td>
				</tr>
			</table>
		</div>

		<div class="mt-4">
			<div class="bg-lmara p-4 text-white font-bold">
				<span class="text-lg">Step [N]</span> Insert step [N] desc
			</div>
			<table class="w-full">
				<tr>
					<td class="p-4 w-full">Question 1</td>
					<td class="p-4 nowrap">
						<label>
							0 <input name="answer3" type="radio" checked>
						</label>
						&emsp;
						<label>
							1<input name="answer3" type="radio">
						</label>
						&emsp;
						<label>
							2 <input name="answer3" type="radio">
						</label>
					</td>
				</tr>
			</table>
			<table class="w-full">
				<tr>
					<td class="p-4 w-full">Question 2</td>
					<td class="p-4 nowrap">
						<label>
							0 <input name="answer4" type="radio" checked>
						</label>
						&emsp;
						<label>
							1<input name="answer4" type="radio">
						</label>
						&emsp;
						<label>
							2 <input name="answer4" type="radio">
						</label>
					</td>
				</tr>
			</table>
		</div>
	</div>


</body>
<style>
	.page-header {
    margin-bottom: 5em;
}

.margin {
    height: 100%;
    margin-left: 0.77in;
    margin-right: 0.77in;
    /* border: 1px dashed black; */
}

.page-break {
    page-break-after: always;
}

.header {
    width: 100%;
}

.header-image {
    padding-left: 5.5pt;
    padding-bottom: 0;
}

.header-title {
    font-family: 'Quattrocento Sans', sans-serif;
    font-size: 18pt;
    font-weight: bold;
    text-align: right;
    white-space: nowrap;
    color: #44546a;
    padding-left: 5.5pt;
    padding-right: 5.5pt;
    padding-bottom: 0;
    vertical-align: bottom;
}

.header-left-box {
    width: 0.68in;
    height: 0.65in;
    background-color: #44546a;
    vertical-align: bottom;
    padding: 0;
}

.header-right-box {
    width: 0.68in;
    height: 0.65in;
    background-color: #2e74b6;
    vertical-align: bottom;
    padding: 0;
}

.table-footer {
    width: 100%;
    padding-left: 0.25in;
    padding-right: 0.25in;
    margin-bottom: 1em;
}

.footer-logo {
    width: 50%;
}

.footer-page {
    width: 50%;
    text-align: right;
    font-family: 'Quattrocento Sans', sans-serif;
    font-size: 11pt;
    color: #5b9bd5;
    vertical-align: bottom;
}

.footer-link {
    text-align: right;
    font-family: 'Quattrocento Sans', sans-serif;
    font-size: 11pt;
    color: #5b9bd5;
    text-decoration: none;
}

body {
    font-family: 'Quattrocento Sans', sans-serif;
    font-size: 11pt;
    font-weight: normal;
    padding: 48px 0;
    margin: 0;
}

table {
    border-collapse: collapse;
}

p {
    margin-top: 1em;
    margin-bottom: 1em;
}

p,
li {
    text-align: justify;
}

ol,
ul,
li {
    margin-top: 0;
    margin-bottom: 0;
}

.bg-shark {
    background-color: #2B3036;
}

.bg-lmara {
    background-color: #0081B8;
}

.bg-tblue {
    background-color: #0F6497;
}

.bg-dsgreen {
    background-color: #0C4664;
}

.text-white {
    color: #ffffff;
}

.text-shark {
    color: #2B3036;
}

.text-lmara {
    color: #0081B8;
}

.text-tblue {
    color: #0F6497;
}

.text-ds-green {
    color: #0C4664;
}

.w-full {
    width: 100%;
}

.w-half {
    width: 50%;
}

.text-lg {
    font-size: 1.25em;
}

.underline {
    text-decoration: underline;
}

.font-bold {
    font-weight: bold;
}

.mt-4 {
    margin-top: 1em;
}

.mb-4 {
    margin-bottom: 1em;
}

.mb-8 {
    margin-bottom: 2em;
}

.p-4 {
    padding: 1em;
}

.flex {
    display: flex;
}

.nowrap {
    white-space: nowrap;
}
</style>

