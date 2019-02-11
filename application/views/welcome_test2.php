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
		#sendedmail{
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
		<div class="col-md-8" id="result_page" style="display:none;">
			<form action="https://www.getdrip.com/forms/352802935/submissions" method="post" data-drip-embedded-form="11354384">
			  <h3 data-drip-attribute="headline">drip</h3>
			  <div data-drip-attribute="description"></div>
			    <div>
			        <label for="drip-email">Email Address</label><br />
			        <input type="email" id="drip-email" name="fields[email]" value="" />
			    </div>
			    <div>
			        <label for="drip-Name">Name</label><br />
			        <input type="text" id="drip-Name" name="fields[Name]" value="" />
			    </div>
			    <div style="display:none;">
			        <label for="drip-Hash">Hash Code</label><br />
			        <input type="hidden" id="drip-Hash" name="fields[Hash]" value="" />
			    </div>
			  <div>
			  	<button class="report-btn" id="submit" name="button" style="width:215px;" type="button" value="Get Your Result">Send free report</button>
			    <!--<input type="button" name="submit" value="Sign Up" data-drip-attribute="sign-up-button" />-->
			  </div>
			</form>
			<iframe id="sendedmail"></iframe>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/test2.js"></script>
</body>
</html>