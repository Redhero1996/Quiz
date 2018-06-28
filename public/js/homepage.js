 $(document).ready(function() {
        $('ul.check > li').on('click', function(){
            var category_id = $(this).val();
            var li_current = $(this).parents().find('li');

            if(li_current.hasClass('active')){
                  li_current.removeClass('active').removeAttr('style');
                  $(this).addClass('active').css('background-color', '#c2c2a3');
            }

            $.ajax({
               url: 'category/'+category_id,
               method: "GET",
              datatype: "json",
              success: function(data){
                console.log(data);
                $('.topics').empty();
                $.each(data, function(key, topic){

                  $('.topics').append(
                      `<a href="topics/`+topic.id+`">
                          <div class="col-sm-4" id="topic_id">
                            <div class="well" style="height: 110px; padding: 19px 19px 0px 19px;">
                              <h4 style="height: 35px;">`+topic.name+`</h4>
                              <span style="float: right; font-weight: bold; color: #333; margin-top: 10px;">
                                  Ngày tạo: ` + topic.created_at + `
                              </span>
                            </div>
                          </div>
                        </a>`
                    );
                  
                });
                $('div.text-center').remove();
              }
            });
        });
      });