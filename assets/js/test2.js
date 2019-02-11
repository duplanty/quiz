$(document).ready(function(){
	var setval = function(val){
		var frm = document.getElementById("testFrm");
		for (var i = 1; i < 85; i++)
		{
			frm["quiz_" + i].value = val;
		}
	};
	$(".setval").click(function(){
		var val = $(this).attr("val");
		setval(val);
	});
	$(".test_btn").click(function(){
		var data = {};
		var frm = document.getElementById("testFrm");
		for(var i = 1; i < 85; i++)
		{
			data['q' + i] = frm["quiz_" + i].value;
		}
		$.ajax({
			url: baseurl + 'welcome/test_values',
			data: data,
			type: "post",
			dataType: 'json',
			success: function(resp) {
				var hash = resp.hash;
				console.log(hash);
				$("#result_page").show();
				$("#drip-Hash").val(hash);
			},
			error: function(err) {
				console.log(err);
			},
		});
		/*_dcq.push(["identify", {
			email: "anti.bug@outlook.com",
			first_name: "John",
			custom_fields: { "name": "John" },
			tags: ["Customer"]
		}]);*/
		//_dcq.push(["showForm", { id: "11354384" }]);
	});
	$(".init_btn").click(function(){
		setval(1);
	});
	$(".rand_btn").click(function(){
		var frm = document.getElementById("testFrm");
		for (var i = 1; i < 85; i++)
		{
			var val = Math.ceil(Math.random() * 5);
			if (val < 1) val = 1;
			else if (val > 5) val = 5;
			frm["quiz_" + i].value = val;
		}
	});
	setval(1);
	
	function isValidEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
	
	$("#submit").click(function(){
		var hashcode = $("#drip-Hash").val();
		var email = $("#drip-email").val().trim();
		var name = $("#drip-Name").val().trim();
		var err = false;
		
//		$('#fname').removeClass('err');
//		$('#lname').removeClass('err');
//		$('#email').removeClass('err');
//		if(fname == "") {
//			$('#fname').addClass('err');
//			err = true;
//	}
		/*if(lname == "") {
			$('#lname').addClass('err');
			err = true;
		}*/
//		if(email == "")
//		{
//			$('#email').addClass('err');
//			err = true;
//	}
//		if( !isValidEmail(email)) {
//			$('#email').addClass('err');
//			err = true;
//	}
		
//		if (err) {
//			return false;
//	}
		
		//var dataString ='fields[email]='+ email+'&fields[Name]='+fname+" "+lname;
		var dataString ='fields[email]='+ email+'&fields[Name]='+name +'&fields[Hash]='+hashcode;
	//	alert(dataString);
		$.ajax({
		    url : 'https://www.getdrip.com/forms/11354384/submissions',
		    data: dataString,
		    method: "POST",
			cache: false,
			beforeSend: function(){
				console.log('sending');
//				$('#loader').show();
			},
			complete: function() {
				console.log('sended');
//				$('#loader').hide();

				document.getElementById("sendedmail").src = '/quiz/welcome/sendmail?email=' + email + '&hash=' + hashcode + '&name=' + name;
			},
		    success:function(data){
			}
		});
	});
});