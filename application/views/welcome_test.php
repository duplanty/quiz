<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Quiz - Test Page</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
		#result_iframe{
			width: 100%;
			min-height: 800px;
			height: 100vh;
		}
		#origin_iframe{
			width: 100%;
			min-height: 800px;
			height: 100vh;
		}
	</style>
	<script>var baseurl = "<?php echo $baseurl; ?>";</script>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
			<form id="testFrm" action="#" method="post" onsubmit="return false">
			<button type="button" class="init_btn">Init</button>
			<button type="button" class="rand_btn">Random</button>
			<button type="button" class="test_btn">Test</button>
			<a href="#" id="view_new_tab" target="_blank">View in new tab</a>
			<table border=1 cellspacing=0>
				<thead style="background:#eee;">
				<tr>
					<td>No</td>
					<td>Question</td>
					<?php foreach($values as $v) { ?>
					<td class="setval" val="<?php echo $v['id']; ?>" style="cursor:pointer;"><?php echo $v['value_text']; ?></td>
					<?php } ?>
				</tr>
				</thead>
				<tbody>
				<?php foreach($questions as $q) { ?>
					<tr>
					<td><?php echo $q['id']; ?></td>
					<td><?php echo $q['question_text']; ?></td>
					<?php foreach($values as $v) { ?>
					<td style="text-align: center;"><input type="radio" name="quiz_<?php echo $q['id']; ?>" id="quiz_<?php echo $q['id']; ?>_<?php echo $v['id']; ?>" qid="<?php echo $q['id']; ?>" class="quiz_val" value="<?php echo $v['id']; ?>"></td>
					<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			</form>
		</div>
		<div class="col-md-8">
			<iframe src="" id="result_iframe"></iframe>
			<iframe src="" id="origin_iframe"></iframe>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/test.js"></script>
</body>
</html>