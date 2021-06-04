let fetchInfo = () => {
    let data = {};
    $('#info').find('input,select').each(function () {
        data[$(this).attr('name')] = $(this).val();


    });
    return data;
}

let fetchStep = (stepNum) => {
    let data = {};
    $(`#step-${stepNum}`).find('input:checked').each(function (x, y) {
        data[$(this).attr('name')] = {
            'value': $(this).val(),
            'question': $(this).parents('tr').find('td').eq(0).html(),
            'notes': $(this).parents('tr').find('textarea').val()
        };

    });

    return data;
}


$(function () {

    $(document).ready(function () {
        $('.multiselect').select2({
            placeholder: "Select Multiple",
            allowClear: true,
            width: '100%',


        });
    });



    $('#generateCompliance').on('click', function () {


    });

});