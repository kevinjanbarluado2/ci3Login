$(function(){
	setInterval(function(){ 
        updatechat(); 
    }, 3000);
    $(".chat-holder").animate({ scrollTop: $('.chat-holder').prop("scrollHeight")}, 500);

	const base_url = $('#base_url').val();

    $(document).on('click','#sendChat',function(e){
        var results_token = $('[name="token"]').val();
        var adviser_id = ($('[name=adviser_id]').val() !== "") ? $('[name=adviser_id]').val() : "";
        var msg = $('.inputField').val();

        if(msg != '') {
            $.ajax({
                url: `${base_url}/compliance/savechat`,
                type: 'post',
                data: { 
                    adviser_id: adviser_id,
                    results_token: results_token,
                    message: msg,
                    sender: 1 
                },
                dataType: "json",
                success: function (res) {
                    $('.inputField').prop("disabled", false);
                    $(".chat-holder").animate({ scrollTop: $('.chat-holder').prop("scrollHeight")}, 500);
                    $(".inputField").val('');
                },
                beforeSend: function () {
                    $('.inputField').prop("disabled", true);
                }

            });
        }        
    });
})

function updatechat() {
    const base_url = $('#base_url').val();
    var results_token = $('[name="token"]').val();
    var adviser_name = ($('[name=adviser_name]').val() !== "") ? $('[name=adviser_name]').val() : "";
    var timestamp = ($('[name=timestamp]').val() !== "") ? $('[name=timestamp]').val() : "";
    var timestamp_curr = "";
    var sender_name = "";
    var class_name = "";

    $.ajax({
        url: `${base_url}/compliance/get_chat`,
        type: 'post',
        data: { 
            results_token: results_token
        },
        dataType: "json",
        success: function (res) {
            $('.chat-holder').html('');

            $.each(res.data,function(i,v){
                timestamp_curr = v.timestamp;
                sender = v.sender;
                
                if(v.sender == 0) {
                	sender_name = v.user_name;
                    class_name = "darker";
                    alignment = "left";
                } else {
                    sender_name = adviser_name;
                    class_name = "";
                    alignment = "right";
                } 
                	

                $('.chat-holder').append(
                    '<div class="container-chat '+ class_name +'">'+
                        '<p class="p-left">'+ sender_name +'<span class="time-right">'+ moment(v.timestamp).format("DD MMMM YYYY - hh:mm:ss A") +'</span></p>'+
                        '<span class="msg-left" style="float:'+ alignment +'">'+ v.message +'</span>'+
                    '</div>');   
            }); 

            if(timestamp != timestamp_curr) {
            	$('[name=timestamp]').val(timestamp_curr);
            	$(".chat-holder").animate({ scrollTop: $('.chat-holder').prop("scrollHeight")}, 500);     
            }
        }
    });
}