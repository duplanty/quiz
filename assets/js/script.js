$(document).ready(function(){
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
	var tester_id = 0;
	var values = [];
	var questions = [];
	var answers = {};
	var step = 0;
	var total_questions = 0;
	var hash = '';
	
	var get_questions = function(){
		var params = {};
		params.step = step;
		params.tester_id = tester_id;
		$.ajax({
			url: baseurl + 'welcome/get_questions',
			data: params,
			type: "post",
			dataType: 'json',
			success: function(resp) {
				questions = resp.questions;
				answers = resp.answers;
				build_quizs();
			},
			error: function(err) {
				console.log(err);
			}
		});
	};
	var go_back = function(){
		step--;
		get_questions();
	};
	var go_next = function(){
		$(".question_text").removeClass("question_require");
		var frm = document.getElementById("quiz_frm");
		for(var i = 0; i < questions.length; i++)
		{
			if (frm['val_' + questions[i].id].value == "")
			{
				$("#question_" + questions[i].id).addClass("question_require");
				return;
			}
		}
		step++;
		get_questions();
	};
	var select_val = function(){
		var params = {};
		params.question_id = $(this).attr("qid");
		params.tester_id = tester_id;
		params.value_id = $(this).val();
		$.ajax({
			url: baseurl + 'welcome/set_answer',
			data: params,
			type: "post",
			dataType: 'json',
			success: function(resp) {
			},
			error: function(err) {
				console.log(err);
			}
		});
	};
	var isValidEmail = function(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	};
	var build_quizs = function(){
		var percent = Math.ceil(step * 500 / total_questions);
		if (percent > 98) percent = 98;
		var html = "";
		var progress_html1 = "";
        var progress_html2 = "";

        progress_html1 += "<div class='mobile-progress-div'><div class='progress-percent'><span style='left:calc(" + percent + "% - 20px);'>" + percent + "%</span></div>";
        progress_html1 += "<div class='progress-bar'><div class='progress-bar-highlight' style='width:" + percent + "%;'></div></div>";
        progress_html1 += "</div>";
		if (percent < 98)
		{
            html += "<form id='quiz_frm'>";
			html += "<table width='100%'><thead><tr><td width='50%'></td>";
			for(var i = 0; i < values.length; i++)
			{
				html += "<td width='10%' class='std-value-text'>" + values[i].value_text + "</td>";
			}
			html += "</tr></thead><tbody>";
			for(var j = 0; j < questions.length; j++)
			{
				html += "<tr><td class='std-quiz-text'>" + questions[j].question_text + "</td>";
				html += "<td colspan='5'><table width='100%'><tr class='mobile-quiz-texts'>";
                html += "<td colspan='5' class='mobile-quiz-text'>" + questions[j].question_text + "</td></tr><tr class='mobile-values'>";
				for(var i = 0; i < values.length; i++)
				{
					html += "<td class='mobile-value-text'>" + values[i].value_text + "</td>";
				}
				html += "</tr><tr>";
                for(var i = 0; i < values.length; i++)
                {
                    html += "<td width='20%'><input type='radio' name='val_" + questions[j].id + "' qid='" + questions[j].id + "' value='" + values[i].id + "' class='quiz_val'" + (answers['quiz_' + questions[j].id] == values[i].id ? " checked='checked'" : '') + "></td>";
                }
				html += "</tr></table></td>";
                html += "</tr>";
			}
			html += "</tbody></table></form>";
			html += "<div class='container-fluid'>";
			html += "<div class='row'>";
			html += "<div class='col-sm-12 col-xs-0 col-md-3' style='text-align:center;'></div>";
			html += "<div class=' col-xs-6 col-md-3' style='text-align:center;'>";
			html += "<button type='button' class='back_btn'" + (step == 0 ? " disabled" : "") + ">";
			html += "PREVIOUS";
			html += "</button>";
			html += "</div>";
			html += "<div class='col-xs-6 col-md-3' style='text-align:center;'>";
			if ((step + 1) * 5 >= total_questions)
				html += "<button type='button' class='next_btn submit_btn'>SUBMIT</button>";
			else
				html += "<button type='button' class='next_btn'>NEXT</button>";
			html += "</div>";
			html += "</div>";
		}
        progress_html2 += "<div class='std-progress-div'><div class='progress-percent'><span style='left:calc(" + percent + "% - 20px);'>" + percent + "%</span></div>";
        progress_html2 += "<div class='progress-bar'><div class='progress-bar-highlight' style='width:" + percent + "%;'></div></div>";
        progress_html2 += "</div>";
		if (percent == 98)
		{
			$(".line").hide();
			// $(".text-section-2").hide();
			$(".links-section").hide();
			html += '<div class="row">';
			html += '<div class="col-xs-12">';
			html += '<h1 class="quiz-result">Get instant access to your personalized diagnosis*</h1>';
			html += '<h2 class="quiz-result">Your diagnosis is almost ready, where should we send it?</h2>';
			html += '</div>';
			html += '</div>';
			html += '<div class="row">';
			html += '<div class="col-xs-12 col-sm-9 col-md-8 col-lg-6 aligncenter">';
			html += '<form method="post" action="welcome/sendmail" id="sendmail_frm">';
			html += '<input type="hidden" id="drip-Hash" name="hash" value="' + hash + '">';
			html += '<div class="form-group" id="thakur">';
			html += '<input type="text" class="form-control" id="drip-Name" name="name" placeholder="First Name" required>';
			html += '</div>';
			html += '<div class="form-group">';
			html += '<input type="email" class="form-control" id="drip-email" name="email" placeholder="Email Address" required>';
			html += '</div>';
			html += '<button class="report-btn" id="submit" name="button" type="button" value="Get Your Result">SEND FREE REPORT</button>';
			html += '</form>';
			html += '<p class="confrm-note">*A conformation email will be sent to you with a link you must click on in order to receive your persnalized diagnosis.</p>';
			html += '</div>';
			html += '</div>';
		}
		$("#body").html(html);
        $(".progress-div1").html(progress_html1);
        $(".progress-div1").show();
        $(".progress-div2").html(progress_html2);
        $(".progress-div2").show();
		$(".back_btn").unbind("click");
		$(".next_btn").unbind("click");
		$(".quiz_val").unbind("click");
		$(".back_btn").click(go_back);
		$(".next_btn").click(go_next);
		$(".quiz_val").click(select_val);
		$("#submit").unbind("click");
		$("#submit").click(function(){
			var hashcode = $("#drip-Hash").val();
			var email = $("#drip-email").val().trim();
			var name = $("#drip-Name").val().trim();
			var err = false;
			
			$('#drip-Name').removeClass('err');
			$('#drip-email').removeClass('err');
			if(name == "") {
				$('#drip-Name').addClass('err');
				err = true;
			}
			if(email == "")
			{
				$('#drip-email').addClass('err');
				err = true;
			}
			if( !isValidEmail(email)) {
				$('#drip-email').addClass('err');
				err = true;
			}
			
			if (err) {
				return false;
			}
			
			var dataString ='fields[email]='+ email+'&fields[Name]='+name +'&fields[Hash]='+hashcode;
			$.ajax({
			    url : 'https://www.getdrip.com/forms/11354384/submissions',
			    data: dataString,
			    method: "POST",
				cache: false,
				beforeSend: function(){
					$('#loader').show();
				},
				complete: function() {
					$('#loader').hide();

					document.location.href = baseurl + 'welcome/sendmail?email=' + email + '&hash=' + hashcode + '&name=' + name;
				},
			    success:function(data){
				}
			});
		});
		if ($(window).innerWidth() <= 768) {
            if (percent < 98) {
                $("#top-logo").animate({height: 0, opacity: 0, margin: 0}, 100);
                //$(".mobile-progress-div").show();
                //$(".std-progress-div div").hide();
                $(".counter-row1").show();
                $(".counter-row2").hide();
            } else {
                $("#top-logo").animate({height: "78px", opacity: 1, margin: "20px auto"}, 100);
                //$(".mobile-progress-div").hide();
                //$(".std-progress-div div").show();
            }
            $("html, body").stop().animate({scrollTop: 0}, 100, 'swing', function () {
            });
        }
	};
	$("#create_btn").click(function(){
		if ($("#agree_term").is( ":checked" ) == false)
		{
			$("#agree_term").focus();
			return;
		}
		var params = {};
		params.gender = $("#gender").val();
		params.age_grp = $("#age_grp").val();
		$.ajax({
			url: baseurl + 'welcome/create_test',
			data: params,
			type: "post",
			dataType: 'json',
			success: function(resp) {
				tester_id = resp.tester_id;
				hash = resp.hash;
				values = resp.values;
				total_questions = resp.total_questions;
				questions = resp.questions;
				answers = {};
				$(".counter-row").hide();
                build_quizs();
                $(".question-wrapper").css("padding-bottom", "80px");
			},
			error: function(err) {
				console.log(err);
			}
		});
	});
});