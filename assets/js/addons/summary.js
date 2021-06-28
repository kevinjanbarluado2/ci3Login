let fetchInfo = () => {
    let data = {};
    $('#info').find('input,select').each(function () {
        data[$(this).attr('name')] = $(this).val();


    });
    return data;
}

$(function () {
    const base_url = $('#base_url').val();
    $(document).ready(function () {
        $('.multiselect').select2({
            placeholder: "All",
            allowClear: true,
            width: '100%',
        });

        $('#smartwizard-summary').smartWizard({
            theme: 'arrows',
            transitionEffect: 'fade',
            justified: true,
            enableURLhash: false,
            toolbarSettings: {
                toolbarPosition: 'both', // none, top, bottom, both
                toolbarButtonPosition: 'right', // left, right, center
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
            },
        });
    });


    $('#generateSummary').on('click', function () {
        data = {};
        data.info = fetchInfo();
        
        $.ajax({
            url: `${base_url}/summary/generate`,
            type: 'post',
            data: { data: data },
            dataType: "json",
            success: function (res) {
                var d = new Date();
                if(res.adviser_str != "") {
                    $('[name="adviser_str"]').val(res.adviser_str);

                    $('#pdfHere').attr('src', res.link + `?v=${d.getTime()}`);
                    $('#viewPdf').attr('disabled', false).removeClass('disabled').text('VIEW PDF');
                    $.notify({
                        icon: "notifications",
                        message: "Generated Summary PDF"
                    }, {
                        type: 'success',
                        timer: 1000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                } else {
                    $.notify({
                        icon: "notifications",
                        message: "No Records Found"
                    }, {
                        type: 'danger',
                        timer: 1000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });  

                    $('#viewPdf').attr('disabled', true).addClass('disabled').text('VIEW PDF');
                }

            },
            beforeSend: function () {
                $('#viewPdf').attr('disabled', true).addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            }

        });
    });

    $("#save-btn").on('click', function (e) {
        data = {};
        data.info = fetchInfo();

        let link = ($('[name="summary_id"]').val() === "") ? "savesummary" : "updatesummary";
        let summary_id = $('[name="summary_id"]').val();
        let adviser_str = $('[name="adviser_str"]').val();

        $.ajax({
            url: `${base_url}/summary/${link}`,
            type: 'post',
            data: {
                data: data,
                summary_id: summary_id,
                adviser_str: adviser_str
            },
            dataType: "json",
            success: function (result) {
                $('#summaryModal').modal('hide');
                $('#save-btn').text("Update changes");

                $('[name="summary_id"]').val(result.summary_id);
                $('#sendPdf').attr('disabled', false).removeClass('disabled').text('Send Pdf');
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

    $('#sendPdf').on('click', function () {
        $.notify({
            icon: "notifications",
            message: "This feature is currently unavailable."

        }, {
            type: 'danger',
            timer: 1000,
            placement: {
                from: 'top',
                align: 'center'
            }
        });
    });

});
