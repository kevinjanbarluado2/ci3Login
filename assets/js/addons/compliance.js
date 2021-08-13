let fetchInfo = () => {
    let data = {};
    $('#info').find('input,select').each(function () {
        data[$(this).attr('name')] = $(this).val();
       

    });
    data['showstep_1']=($('#showstep_1').is(':checked'))?'true':'false';
    data['showstep_2']=($('#showstep_2').is(':checked'))?'true':'false';
    data['showstep_3']=($('#showstep_3').is(':checked'))?'true':'false';
    data['showstep_4']=($('#showstep_4').is(':checked'))?'true':'false';
    data['showstep_5']=($('#showstep_5').is(':checked'))?'true':'false';
    data['showstep_6']=($('#showstep_6').is(':checked'))?'true':'false';

    data['training_needed_1']=($('#training_needed_1').is(':checked'))?'true':'false';
    data['training_needed_2']=($('#training_needed_2').is(':checked'))?'true':'false';
    data['training_needed_3']=($('#training_needed_3').is(':checked'))?'true':'false';
    data['training_needed_4']=($('#training_needed_4').is(':checked'))?'true':'false';
    data['training_needed_5']=($('#training_needed_5').is(':checked'))?'true':'false';
    data['training_needed_6']=($('#training_needed_6').is(':checked'))?'true':'false';
    return data;
}

let fetchStep = (stepNum) => {
    let data = {};
    $(`#step-${stepNum}`).find('tbody tr').each(function (x, y) {
        data[x] = {
            'value': ($(this).find('input:checked').val() !== undefined) ? $(this).find('input:checked').val() : "",
            'question': $(this).find('td').eq(0).html(),
            'notes': $(this).find('textarea').val().trim()
        };

    });

    // console.log('data:');
    // console.log(data);

    return data;
}


$(function () {
    setInterval(function(){ 
        updatechat(); 
    }, 3000);
    

    let apbutton = $('#fetchAdviceProcess');
    ($('[name=adviser]').val()=="")?apbutton.prop('disabled', true):"";
    $('[name=adviser]').on('change', function () {
        if($(this).val()!==''){
            apbutton.prop('disabled',false);
        }
    });
    apbutton.on('click', function (e) {
        e.preventDefault();
        $('#adviserModal').modal('show');
        loadTable();
    });


    const base_url = $('#base_url').val();
    $(document).ready(function () {
        $('.multiselect').select2({
            placeholder: "Select Multiple",
            allowClear: true,
            width: '100%',


        });
        $('.select2-info').select2();
    });


    $('#generateCompliance').on('click', function () {
        data = {};
        data.info = fetchInfo();
        data.step1 = fetchStep(1);
        data.step2 = fetchStep(2);
        data.step3 = fetchStep(3);
        data.step4 = fetchStep(4);
        data.step5 = fetchStep(5);
        data.step6 = fetchStep(6);

        let token = $('[name="token"]').val();

        //console.log(data, base_url);
        $.ajax({
            url: `${base_url}/compliance/generate`,
            type: 'post',
            data: { 
                data: data,
                results_token: token 
            },
            dataType: "json",
            success: function (res) {
                var d = new Date();
                $('#pdfHere').attr('src', res.link + `?v=${d.getTime()}`);
                $('#viewPdf').attr('disabled', false).removeClass('disabled').text('VIEW PDF');
                $.notify({
                    icon: "notifications",
                    message: "Generated Compliance PDF"
                }, {
                    type: 'success',
                    timer: 1000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });

            },
            beforeSend: function () {
                $('#viewPdf').attr('disabled', true).addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            }

        });
    });

    $('#sendPdf').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let data = {};
        info = fetchInfo();

        data.adviser = info.adviser;
        data.filename = $('[name=filename]').val();
        data.includeAdviser = ($('[name=includeAdviser]:checked').val() !== undefined) ? true : false;
        data.complianceOfficer = ($('[name=complianceOfficer]').val() !== "") ? $('[name=complianceOfficer]').val() : "";
        data.results_token = $('[name="token"]').val();
        
        let link = "sendEmail";
        //console.log(data.includeAdviser);

        $.ajax({
            url: `${base_url}/compliance/${link}`,
            type: 'post',
            data: data,
            dataType: "json",
            success: function (result) {
                $('#sendPdf').attr('disabled', false).removeClass('disabled').text('Compliance was sent');

                //console.log('email sent. (compliance)');
                $.notify({
                    icon: "notifications",
                    message: "Success! Email Sent"

                }, {
                    type: 'success',
                    timer: 1000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });
            },
            beforeSend: function () {
                $('#sendPdf').attr('disabled', true).addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending Email...');
            },
            error: function (req, err) { console.log('my message' + err); }

        });





    });

    $("#save-btn").on('click', function (e) {
        data = {};
        data.info = fetchInfo();
        data.step1 = fetchStep(1);
        data.step2 = fetchStep(2);
        data.step3 = fetchStep(3);
        data.step4 = fetchStep(4);
        data.step5 = fetchStep(5);
        data.step6 = fetchStep(6);
        // console.log(data);
        let link = ($('[name="results_id"]').val() === "") ? "savecompliance" : "updatecompliance";
        let results_id = $('[name="results_id"]').val();
        let filename = $('[name="filename"]').val();
        let token = $('[name="token"]').val();

        $.ajax({
            url: `${base_url}/compliance/${link}`,
            type: 'post',
            data: {
                data: data,
                results_id: results_id,
                filename: filename,
                token: token
            },
            dataType: "json",
            success: function (result) {
                $('#complianceModal').modal('hide');
                $('#save-btn').text("Update changes");

                $('[name="results_id"]').val(result.results_id);
                $('[name="filename"]').val(result.filename);
                $('[name="token"]').val(result.token);
                $('#sendPdf').attr('disabled', false).removeClass('disabled').text('Send Pdf');

                $('.inputField').prop("disabled", false);
                $.notify({
                    icon: "notifications",
                    message: result.message

                }, {
                    type: 'success',
                    timer: 1000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });
            },
            beforeSend: function () {
                $('#sendPdf').attr('disabled', true).addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            },
            error: function (result) {
                $.notify({
                    icon: "notifications",
                    message: "There was an error in the connection. Please contact the administrator for updates."

                }, {
                    type: 'danger',
                    timer: 1000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });
            }
        });
    });


    function loadTable() {
        var baseurl = $('#base_url').val();

        table = $('#datatables').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            order: [],
            columnDefs: [{ orderable: false, targets: -1 }],
            // scroller: {
            // 	displayBuffer: 20
            // }
            initComplete: function () {
                $('#search-table').remove();
                var input = $('.dataTables_filter input').unbind(),
                    self = this.api(),
                    $searchButton = $('<button id="search-table" class="btn btn-primary btn-round btn-xs">')
                        .html('<i class="material-icons">search</i>')
                        .click(function () {

                            if (!$('#search-table').is(':disabled')) {
                                $('#search-table').attr('disabled', true);
                                self.search(input.val()).draw();
                                $('#datatables button').attr('disabled', true);
                                $('.dataTables_filter').append('<div id="search-loader"><br>'
                                    + '<div class="preloader pl-size-xs">'
                                    + '<div class="spinner-layer pl-red-grey">'
                                    + '<div class="circle-clipper left">'
                                    + '<div class="circle"></div>'
                                    + '</div>'
                                    + '<div class="circle-clipper right">'
                                    + '<div class="circle"></div>'
                                    + '</div>'
                                    + '</div>'
                                    + '</div>'
                                    + '&emsp;Please Wait..</div>');
                            }

                        })
                $('.dataTables_filter').append($searchButton).addClass('pull-right');
                $('.dataTables_paginate').addClass('pull-right');
            },
            drawCallback: function (settings) {
                $('#search-loader').remove();
                $('#search-table').removeAttr('disabled');
                $('#datatables button').removeAttr('disabled');
            },
            ajax: {
                url: baseurl + "Compliance/fetchRows",
                type: "POST",
                data:{'adviserId': $('[name=adviser]').val()},
            },
            oLanguage: {
                sProcessing: '<div class="preloader pl-size-sm">'
                    + '<div class="spinner-layer pl-red-grey">'
                    + '<div class="circle-clipper left">'
                    + '<div class="circle"></div>'
                    + '</div>'
                    + '<div class="circle-clipper right">'
                    + '<div class="circle"></div>'
                    + '</div>'
                    + '</div>'
                    + '</div>'
            }
        });
        //table.ajax.reload();
    }
    $(document).on('click','#fetchPlan',function(){

        $('input[name=client]').val($(this).attr('data-clientName'));
        providerArr = $(this).attr('data-provider').split(',');
        policyArr =  $(this).attr('data-policyType').split(',');
        $('[name=providers]').val(providerArr).trigger('change');
        $('[name=policyType]').val(policyArr).trigger('change');
        $('[name=replacement]').val($(this).attr('data-replacementOfCover'));
        $('#adviserModal').modal('hide');

    });

    $(document).on('keyup','.inputField',function(e){
        if (e.keyCode === 13) {
            $("#sendChat").click();
        }
    });

    $(document).on('click','#sendChat',function(e){
        data = {};
        data.info = fetchInfo();
        var adviser_id = data.info.adviser;
        var results_token = $('[name="token"]').val();

        var msg = $('.inputField').val();
        var complianceOfficer = ($('[name=complianceOfficer]').val() !== "") ? $('[name=complianceOfficer]').val() : "";
        var currentTime = moment().format("DD MMMM YYYY - hh:mm A");
        if(msg != '') {
            $.ajax({
                url: `${base_url}/compliance/savechat`,
                type: 'post',
                data: { 
                    adviser_id: adviser_id,
                    results_token: results_token,
                    message: msg 
                },
                dataType: "json",
                success: function (res) {
                    $('.inputField').prop("disabled", false);
                    // $('.chat-holder').append(
                    //     '<div class="container-chat">'+
                    //         '<p class="p-left">'+ complianceOfficer +'<span class="time-right">'+ currentTime +'</span></p>'+
                    //         '<span class="msg-left">'+ msg +'</span>'+
                    //     '</div>')

                    $(".chat-holder").animate({ scrollTop: $('.chat-holder').prop("scrollHeight")}, 500);
                    $(".inputField").val('');
                },
                beforeSend: function () {
                    $('.inputField').prop("disabled", true);
                }

            });
        }        
    });
});

function updatechat() {
    const base_url = $('#base_url').val();
    var results_token = $('[name="token"]').val();
    var adviser_name = ($('[name=adviser]').val() !== "") ? $.trim($('[name=adviser] option:selected').text()) : "";
    var timestamp = ($('[name=timestamp]').val() !== "") ? $('[name=timestamp]').val() : "";
    var complianceId = ($('[name=complianceId]').val() !== "") ? $('[name=complianceId]').val() : "";

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
                class_name = "";

                if(v.sender == 0) {
                    sender_name = v.user_name;
                    if(complianceId == v.user_id) {
                        class_name = "";
                        alignment = "right";
                    } else {
                        class_name = "darker";
                        alignment = "left";
                    }     
                } else {
                    sender_name = adviser_name;
                    class_name = "darker";
                    alignment = "left";
                } 

                $('.chat-holder').append(
                    '<div class="container-chat '+ class_name +'">'+
                        '<p class="p-left">'+ sender_name +'<span class="time-right">'+ moment(v.timestamp).format("DD MMMM YYYY - hh:mm A") +'</span></p>'+
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
