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
                $('#viewPdf').attr('disabled', true).addClass('disabled').text('Loading...');
            }

        });
    });

    $('#sendPdf').on('click', function () {
        data = {};
        info = fetchInfo();
        console.log(info);
        data.adviser = info.adviser;
        data.filename = $('[name=filename]').val();
        data.includeAdviser = ($('[name=includeAdviser]:checked').val() !== undefined) ? true : false;
        data.complianceOfficer = ($('[name=complianceOfficer]').val() !== "") ? $('[name=complianceOfficer]').val() : "";
        let link = "sendEmail";

        $.ajax({
            url: `${base_url}/compliance/${link}`,
            type: 'post',
            data: data,
            dataType: "json",
            success: function (result) {
                $('#sendPdf').attr('disabled', false).removeClass('disabled').text('Compliance was sent');

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
                $('#sendPdf').attr('disabled', true).addClass('disabled').text('Sending Email...');
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

        let link = ($('[name="results_id"]').val() === "") ? "savecompliance" : "updatecompliance";
        let results_id = $('[name="results_id"]').val();
        let filename = $('[name="filename"]').val();

        $.ajax({
            url: `${base_url}/compliance/${link}`,
            type: 'post',
            data: {
                data: data,
                results_id: results_id,
                filename: filename
            },
            dataType: "json",
            success: function (result) {
                $('#complianceModal').modal('hide');
                $('#save-btn').text("Update changes");

                $('[name="results_id"]').val(result.results_id);
                $('[name="filename"]').val(result.filename);
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
                $('#sendPdf').attr('disabled', true).addClass('disabled').text('Loading...');
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
});