$(document).ready(function(){
	$('input').prop('disabled', true);
	$('span#timer').hide();
	$('div#btn-test').click(function(){
		$(this).hide();
		$('span#timer').show();
		$('input').removeAttr('disabled', '');
		$('div#btn-submit').removeAttr('style');
		$('input').removeAttr('style');
		$('span#fifteen_min').hide();
		// Timer countdown
		var interval = setInterval(function() {
			var timer = $('span#timer').html();
			timer = timer.split(':');
			var minutes = parseInt(timer[0], 10);
			var seconds = parseInt(timer[1], 10);	
			seconds--;
		    if (minutes < 0) return clearInterval(interval);
		    if (minutes < 10) minutes = '0' + minutes;
		    if (seconds < 0 && minutes != 0) {
		        minutes--;
		        seconds = 59;
		    }
		    else if (seconds < 10) seconds = '0' + seconds;
		    $('span#timer').html(minutes + ':' + seconds);
		    
			if (minutes == 0 && seconds == 0){
			    clearInterval(interval);
	    		$.confirm({
	    			icon: 'fa fa-warning',
	    			type: 'red',
	    		    title: 'Oops!',
	    		    content: 'Bạn đã hết thời gian làm bài',
	    		    buttons: {
	    		        ok: function () {
	    		            $('div#check-all').submit();
	    					checkSubmit();
	    		        },
	    		    }
	    		});
			    
			}				    	
		}, 1000);
			
		//===========================================================
		$('button#btn_submit').click(function(){
			clearInterval(interval);
			checkSubmit();			   	
		});
	});

});

function checkSubmit(){
	var obj = @json($data);
						
	var dataRequest = {};
	console.log(obj);
	for(i in obj) {
		var topic = topic.id ;
		var question_id = obj[i].question.id; 
		var answer = $(`input[name="question_${obj[i].question.id}"]:checked`).val();
		one_question = {
			'topic' : topic,
			'question_id': question_id,
			'answer': answer
		}
		dataRequest[i] = one_question; // tao 1 ptu trong obj vs key la i(0 , 1, 2)
										// one_question: gia tri (obj)
		// dataRequest.push(a); // tuong duong mang vs dataRequset = []
	}
	
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
	        // 'accepts': 'application/json',
	    }
	});
	$.ajax({
		url: '/question',
		type: "GET",					
		data: {dataRequest},
		success:function(data){
			questionArr = data.correctAns;
			for(var i =0; i< questionArr.length; i++) {
				if(questionArr[i].answer) {
					$(`input#${questionArr[i].answer_id}`).closest('li').css(
						{'background': '#66ff66', 'border-radius': '3px 4px'}).append(`
							<i class="glyphicon glyphicon-ok text-success"></i>`);

				} else {
					$(`input#${questionArr[i].answer_id}`).closest('li').css(
						{'background': '#ffcccc', 'border-radius': '3px 4px'}).append(`
							<i class="glyphicon glyphicon-remove text-danger"></i>`);
					
					$(`input#${questionArr[i].correct_ans}`).closest('li').css(
						{'color': '#45ba28'});
					}
			}
			$('input').prop("disabled", true).css("cursor", "default");

			$('div#score').addClass("alert alert-success").append(`
				<p style="text-align:center; font-weight:bold; font-family:  Zapf-Chancery, cursive; ">
					Bạn đúng ${data.score}/${questionArr.length}										
				</p>
				<p style="text-align:center; font-weight:bold; font-family:  Zapf-Chancery, cursive; ">
					Tổng điểm: ${data.total}/${questionArr.length*5}
				</p>`);
			
			$('button#btn_submit').css('display', 'none');	
									
		}
	});	
}