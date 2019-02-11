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
	<script>var baseurl = "<?php echo $baseurl; ?>";</script>
</head>
<body>
<div id="top-logo" class="logo">
    <img src="<?php echo $baseurl; ?>assets/images/logo.png">
</div>
<div class="main-container">
    <div class="question-wrapper">
<!--        <div class="progress-div progress-div1"></div>-->
        <div class="row counter-row counter-row1">
            <div class="col-sm-4">
                <p class="counter-title">Total Completed</p>
                <span class="counter"><?php echo $total_completed; ?></span>
            </div>
            <div class="col-sm-4">
                <p class="counter-title">Completed Last 7 Days</p>
                <span class="counter"><?php echo $day7_completed; ?></span>
            </div>
            <div class="col-sm-4">
                <p class="counter-title">Currently In Progress</p>
                <span class="counter"><?php echo $today_count; ?></span>
            </div>
        </div>
		<div id="body">
			<div class="taketxt">
				<h2>Find Your Strength & Weakness Assessment</h2>
			</div>
			<div class="row user-info">
				<div class="col col-sm-3 col-sm-offset-3">
                    <p>Gender</p>
                    <select id="gender"><option value=1>Male</option><option value=0>Female</option></select>
                </div>
                <div class="col col-sm-3">
                    <p>Age</p>
                    <select id="age_grp">
                        <option value=1>18-25</option>
                        <option value=2>26-32</option>
                        <option value=3>33-39</option>
                        <option value=4>40-46</option>
                        <option value=5>47-53</option>
                        <option value=6>54-60</option>
                        <option value=7>61-67</option>
                        <option value=8>68-74</option>
                        <option value=9>75-81</option>
                        <option value=10>82-88</option>
                        <option value=11>89-95</option>
                        <option value=12>96-99</option>
                    </select>
                </div>
			</div>
			<div class="row">
				<div class="col-md-12">
                    <p>
                        <label>
                            <input type="checkbox" id="agree_term" checked> I agree to use this test for personal purposes only. <button type="button" class="btn" data-toggle="modal" data-target="#myModal">Learn More</button>
                        </label>
                    </p>
					<button id="create_btn" class="start_btn" type="button">
						START ASSESSMENT
					</button>
				</div>
			</div>
		</div>
        <div class="row counter-row counter-row2">
            <div class="col-sm-4">
                <p class="counter-title">Total Completed</p>
                <span class="counter"><?php echo $total_completed; ?></span>
            </div>
            <div class="col-sm-4">
                <p class="counter-title">Completed Last 7 Days</p>
                <span class="counter"><?php echo $day7_completed; ?></span>
            </div>
            <div class="col-sm-4">
                <p class="counter-title">Currently In Progress</p>
                <span class="counter"><?php echo $today_count; ?></span>
            </div>
        </div>
        <div class="progress-div progress-div2"></div>
		<!--<div class="links-section">
			<a href="http://stresshelpgroup.com/about/">About</a>
			<a href="http://stresshelpgroup.com/contact/">Contact</a>
			<a href="http://stresshelpgroup.com/terms/">Terms &amp; Conditions</a>
			<a href="http://stresshelpgroup.com/privacy-policy/">Privacy Policy</a>
		</div>-->
        <div class="question_shadow"></div>
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
<div id="loader" style="display: none;">
	<div class="overlay-popup modal-backdrop fade in">
		<div class="center">
			<img src="<?php echo $baseurl; ?>assets/images/loader.gif" style="z-index:1254124854; position:absolute">
		</div>
	</div>
</div>
<script src="https://www.googletagmanager.com/gtag/js?id=UA-107678605-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-107678605-1');
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.counterup.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/script.js"></script>
</body>
</html>