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
            'value': ($(this).find('input:checked').val()!==undefined)?$(this).find('input:checked').val():"",
            'question': $(this).find('td').eq(0).html(),
            'notes': $(this).find('textarea').val()
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
        data={};
        data.info=fetchInfo();
        data.step1=fetchStep(1);
        data.step2=fetchStep(2);
        data.step3=fetchStep(3);
        data.step4=fetchStep(4);
        data.step5=fetchStep(5);
        data.step6=fetchStep(6);

        console.log(data);

    });

});