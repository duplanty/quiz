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
				var url = resp.url;
				$("#view_new_tab").attr("href", url);
				document.getElementById("result_iframe").src = url;
				
				$.ajax({
					url: 'http://richardstep.com/rswatest/strengthstest_results.php',
					data: data,
					type: "post",
					dataType: 'text',
					success: function(resp) {
						var ifrm = document.getElementById('origin_iframe');
						ifrm = ifrm.contentWindow || ifrm.contentDocument.document || ifrm.contentDocument;
						ifrm.document.open();
						ifrm.document.write(resp);
						ifrm.document.close();
					},
					error: function(err) {
						console.log(err);
					},
				});
			},
			error: function(err) {
				console.log(err);
			},
		});
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
});