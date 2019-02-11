<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Quiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/style.css">
</head>
<body>
<div class="logo">
    <img src="<?php echo $baseurl; ?>assets/images/logo.png">
</div>
<div class="main-container" style="overflow:hidden;">
    <div class="question-wrapper" style="padding-bottom: 0;">
		<div id="body">
			<div class="taketxt">
				<h2 style="border-bottom: 0 none;padding-bottom: 20px;">Your Personalized Assessment Results</h2>
			</div>
			<?php foreach($results as $key => $result) { $percent = round($result['marks'] * 100 / 16); ?>
			<div class="row" style="text-align: left; padding: 10px 0;">
				<div class="col col-md-12">
				<strong><?php echo $result['category']; ?> (<?php echo $percent; ?>%)</strong>
				<?php if ($key < 5 || $key == count($results) - 1) { ?>
				<p><?php echo nl2br($result['description']); ?></p>
				<?php } ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="text-section-2">
    <div class="font_1">
        &copy; All material is Copyright protected 2011-2017
    </div>
    <div class="font_2">
        Disclaimer: All material provided on the website is provided for informational or educational purposes only.
        No content is intended to be a substitute for professional medical advice, diagnosis or treatment.
        Consult your physician regarding the applicability of any opinions or recommendations with respect to your symptoms or medical condition.
    </div>
</div>
</body>
</html>