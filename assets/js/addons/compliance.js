let fetchInfo = () => {
    let data = {};
    $('#info').find('input,select').each(function () {
        data[$(this).attr('name')] = $(this).val();


    });
    return data;
}

let fetchStep = (stepNum) => {
    let data = {};
    $(`#step-${stepNum}`).find('tbody tr').each(function (x, y) {
        data[x] = {
            'value': ($(this).find('input:checked').val() !== undefined) ? $(this).find('input:checked').val() : "",
            'question': $(this).find('td').eq(0).html(),
            'notes': $(this).find('textarea').val()
        };

    });

    return data;
}


$(function () {
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

        console.log(data, base_url);
        $.ajax({
            url: `${base_url}/compliance/generate`,
            type: 'post',
            data: { data: data },
            dataType:"json",
            success: function (res) {
                console.log(res);
                var d = new Date();
                $('#pdfHere').attr('src',res.link+`?v=${d.getTime()}`);
                $('#viewPdf').attr('disabled',false).removeClass('disabled').text('VIEW PDF');
                
     
            },
            beforeSend:function(){
                $('#viewPdf').attr('disabled',true).addClass('disabled').text('Loading...');
            }

        });
    });

    $(document).on('click', '#save-btn', function (e) {
        data = {};
        data.info = fetchInfo();
        data.step1 = fetchStep(1);
        data.step2 = fetchStep(2);
        data.step3 = fetchStep(3);
        data.step4 = fetchStep(4);
        data.step5 = fetchStep(5);
        data.step6 = fetchStep(6);

        $.ajax({
            url: `${base_url}/compliance/savecompliance`,
            type: 'post',
            data: { data: data },
            dataType:"json",
            success: function (result) {
                $('#complianceModal').modal('hide');

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
    //Ajax Forms
    //event triggered upon submitting users form
    $(document).on('submit', '#addCompliance', function (e) {
        e.preventDefault();
        alert();
        // var form = $(this)
        // content = "Are you sure you want to proceed?";

        // if (form.attr('id') == "addAdvisers") {
        //     content = "Are you sure you want to add this adviser?";
        // }
        // if (form.attr('id') == "updateAdvisers") {
        //     content = "Are you sure you want to update this adviser?";
        // }

        // url = form.attr('action');
        // swal({
        //     text: content,
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonClass: 'btn btn-success',
        //     cancelButtonClass: 'btn btn-danger',
        //     confirmButtonText: 'Yes',
        //     cancelButtonText: 'No',
        //     buttonsStyling: false
        // }).then(function(result) {  
        //     if (result.value) {
        //         $.ajax({
        //             type: "POST",
        //             url: url,
        //             data: new FormData(form[0]),
        //             contentType: false,
        //             processData: false,
        //             dataType: "json",
        //             success: function (result) {
        //                 if (result.hasOwnProperty("key")) {
        //                     switch (result.key) {
        //                         case 'addAdvisers':
        //                         case 'updateAdvisers':    
        //                             loadTable();
        //                             $.notify({
        //                                 icon: "notifications",
        //                                 message: result.message

        //                             }, {
        //                                 type: 'success',
        //                                 timer: 1000,
        //                                 placement: {
        //                                     from: 'top',
        //                                     align: 'center'
        //                                 }
        //                             });
        //                             $('#myModal .modal-body').html('');
        //                             $('#myModal').modal('hide');
                                                    
        //                             break;
        //                     }
        //                 }
        //             },
        //             error: function (result) {
        //                 $.notify({
        //                     icon: "notifications",
        //                     message: "There was an error in the connection. Please contact the administrator for updates."

        //                 }, {
        //                     type: 'danger',
        //                     timer: 1000,
        //                     placement: {
        //                         from: 'top',
        //                         align: 'center'
        //                     }
        //                 });
        //             }
        //         });
        //     }  
        // }).catch(swal.noop)
        
    })

});