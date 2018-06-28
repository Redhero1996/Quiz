@extends('main')

@section('title', '| Topics')

@section('stylesheets')
	{!! Html::style('css/styles.css') !!}
@endsection

@section('content')
	
	@if (Auth::check())
		@if(!empty($data))
			<div class="form-group" style="padding-left: 36px;">
				<h3 id="title-quiz" >
					<strong>Đề thi về {{$topic->name}}</strong>
				</h3>	
				<h3 id="currentQuestionNumberText">Bài thi gồm {{count($data)}} câu hỏi
					<span id="fifteen_min"> (15 phút)</span>
					<button class="btn btn-warning" id="btn-test" style="float: right;">Làm bài thi</button>
					<a href="{{ route('topic', $topic->id) }}" class="btn btn-default" type="submit" id="btn-refresh" style="display: none; float:right; padding: 7px 15px;"> Làm lại </a>

				</h3>
				<hr>
			</div>
			
			<div class="form-group" id="score" style="margin-left: 36px;"></div>
			<div class="form-group" id="check-all">	
				@php
					$i =1;
				@endphp			
				@foreach ($data as $key => $value)
					
					<ol class="questions" style="list-style: none;">

						<li class="title-question">

							<span style="font-size: 18px; vertical-align: top;">Câu {{$i}}. </span>
							<span id="question" style="display: inline-block; margin-top: 3px;">{!! $value['question']->content !!}
							</span>
						</li>								
						<ul style="list-style: none; margin-bottom: 15px;">
							@foreach ($value['answer'] as $key => $answer)
								<li class="container-fluid">
									 <label><input type="checkbox" id="{{$answer->id}}"  name="{{$answer->id}}" value="{{$answer->id}}" style="display: none;"> {{ $alphabet[$key] }}. <strong>{{ $answer->content }}</strong></label>
								</li>
							@endforeach
						</ul>
					</ol>
				@php
					$i++;
				@endphp
				@endforeach

			</div>
			
				
		@else
			không có câu hỏi
		@endif

	@else
		<p class="text-center">Vui lòng <a href="{{ route('login') }}">Đăng nhập</a> để làm bài</p>

	@endif 
	
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('input').prop('disabled', true);
			$('span#timer').hide();
			$('button#btn-test').click(function(){
				$(this).hide();
				$('span#timer').show();
				$('input').removeAttr('disabled', '');
				$('button#btn_submit').show();
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
				    if(minutes == 0 && seconds <= 10){
				    	$('span#timer').css('color', 'red');
				    	$('span#timer').fadeOut(50);
				    	$('span#timer').fadeIn(50);
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
			var topic = {!! $topic->id !!};	
			var dataRequest = {};

			for(i in obj) {
				var answers = obj[i].answer;
				var question_id = obj[i].question.id;
				var answer = [];
				for(j in answers){					
					if($(`input[name="${answers[j].id}"]`).is(':checked')){
						var a = parseInt($(`input[name="${answers[j].id}"]:checked`).val());
						answer.push(a);		
					}
				}
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
					// console.log(questionArr);
					for(var i =0; i< questionArr.length; i++) {
						if(questionArr[i].answer) {
							for (var j = 0; j < questionArr[i].answer_id.length; j++) {									
								$(`input#${questionArr[i].answer_id[j]}`).closest('li').css(
									{'background': '#66ff66', 'border-radius': '3px 4px'}).append(`
										<i class="glyphicon glyphicon-ok text-success"></i>`);
							}	
						} else {
							for (var j = 0; j < questionArr[i].answer_id.length; j++) {								
									if(jQuery.inArray(questionArr[i].answer_id[j], questionArr[i].correct_ans) != -1){
										$(`input#${questionArr[i].answer_id[j]}`).closest('li').css(
											{'color': '#45ba28'});
									}else{									
										$(`input#${questionArr[i].answer_id[j]}`).closest('li').css(
											{'background': '#ffcccc', 'border-radius': '3px 4px'}).append(`
												<i class="glyphicon glyphicon-remove text-danger"></i>`);								
									}
							}
							for (var k = 0; k < questionArr[i].correct_ans.length; k++) {								
								$(`input#${questionArr[i].correct_ans[k]}`).closest('li').css(
									{'color': '#45ba28'});
							}
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
					
					$('button#btn_submit').hide();
					$('a#btn-refresh').css('display', 'inline-block');

					$('span#timer').parent().css('padding-top','7px');	
					$('html, body').animate({scrollTop : 0});							
				}
			});	
		}
	</script>
@stop

	