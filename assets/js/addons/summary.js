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
        $('.single-select').select2({
            allowClear: true,
            width: '100%',
        });

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

    //view pdf
    $(document).on('click', '#viewPdfForm', function (e) {
        e.preventDefault();

        me = $(this)
        results_id = me.attr('data-result_id');
        results_token = me.attr('data-token');
        url = me.attr('href');

        $.ajax({
            url: url,
            type: 'post',
            data: {
                results_id: results_id,
                results_token: results_token
            },
            dataType: "json",
            success: function (res) {
                console.log(res);
                var d = new Date();
                $('#pdfHere').attr('src', res.link + `?v=${d.getTime()}`);
                $('#complianceModal').modal('show');

            }
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
                if(res.result_str != "") {
                    $('[name="adviser_str"]').val(res.adviser_str);
                    $('[name="result_str"]').val(res.result_str);

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
        let result_str = $('[name="result_str"]').val();

        $.ajax({
            url: `${base_url}/summary/${link}`,
            type: 'post',
            data: {
                data: data,
                summary_id: summary_id,
                adviser_str: adviser_str,
                result_str: result_str
            },
            dataType: "json",
            success: function (result) {
                $('#summaryModal').modal('hide');
                $('#save-btn').text("Update changes");

                $('[name="summary_id"]').val(result.summary_id);
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

    $('#sendPdf').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let data = {};
        info = fetchInfo();

        data.filename = $('[name=filename]').val();
        data.complianceOfficer = ($('[name=complianceOfficer]').val() !== "") ? $('[name=complianceOfficer]').val() : "";
        let link = "sendEmail";
        
        $.ajax({
            url: `${base_url}/summary/${link}`,
            type: 'post',
            data: data,
            dataType: "json",
            success: function (result) {
                $('#sendPdf').attr('disabled', false).removeClass('disabled').text('Compliance was sent');

                console.log('email sent. (summary)');
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


    $('#summary-filter').on('click', function () {
        var filter = $('.filter').val();
        var adviser = $('[name="adviser"]').val();
        if(filter == '2' && adviser == '') {
            $.notify({
                icon: "notifications",
                message: "Failed! Please select an adviser."

            }, {
                type: 'warning',
                timer: 1000,
                placement: {
                    from: 'top',
                    align: 'center'
                }
            });
            $('#summary-printout').attr("disabled","disabled");
        } else {
            loadTable();
            generatePDF();
            $('#summary-printout').removeAttr("disabled");
        }
    });

    $('.filter').on('change', function () {
        var val = $(this).val();

        if(val == '2') 
            $('[name="adviser"]').select2("destroy").removeClass('multiselect').addClass('single-select').removeAttr("multiple").select2({allowClear: true, width: '100%'});
        else 
            $('[name="adviser"]').select2("destroy").removeClass('single-select').addClass('multiselect').attr("multiple","multiple").select2({placeholder: "All",allowClear: true,width: '100%',});

        // $('.tally-tbl').hide();
        $('.filtered-tbl').hide();
        $('.filtered-tble').html('');
        $('#summary-printout').attr("disabled","disabled");
        // $('.main-panel').animate({ scrollTop: 0});
    });
});

//initialize table to be displayed
function loadTable(){
    var baseurl = $('#base_url').val();
    let data = {};
    data.info = fetchInfo();

    table = $('#datatables').DataTable({
        destroy:true,
        processing:true,
        serverSide:true,
        responsive:true,
        ordering: false,
        order:[],
        columns : [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '+',
            },
            { "data": "clients" },
            { "data": "step1" },
            { "data": "step2" },
            { "data": "step3" },
            { "data": "step4" },
            { "data": "step5" },
            { "data": "step6" },
            { "data": "total_score" },
            { "data": "actions" }
        ],
        columnDefs: [ { orderable: false, targets: -1 } ],
        // scroller: {
        //  displayBuffer: 20
        // }
        initComplete : function() {
            $('#search-table').remove();
            var input = $('.dataTables_filter input').unbind(),
            self = this.api(),
            $searchButton = $('<button id="search-table" class="btn btn-primary btn-round btn-xs">')
            .html('<i class="material-icons">search</i>')
            .click(function() {
                
                if(!$('#search-table').is(':disabled')){
                    $('#search-table').attr('disabled',true);
                    self.search(input.val()).draw();
                    $('#datatables button').attr('disabled',true);
                    $('.dataTables_filter').append('<div id="search-loader"><br>' 
                        +'<div class="preloader pl-size-xs">'
                        +    '<div class="spinner-layer pl-red-grey">'
                        +        '<div class="circle-clipper left">'
                        +            '<div class="circle"></div>'
                        +        '</div>'
                        +        '<div class="circle-clipper right">'
                        +            '<div class="circle"></div>'
                        +        '</div>'
                        +    '</div>'
                        +'</div>'
                        +'&emsp;Please Wait..</div>');
                }

            })
            $('.dataTables_filter').append($searchButton).addClass('pull-right');
            $('.dataTables_paginate').addClass('pull-right');
        },
        drawCallback: function( settings ) {
            $('#search-loader').remove();
            $('#search-table').removeAttr('disabled');
            $('#datatables button').removeAttr('disabled');
        },
        ajax : {  
            url:baseurl + "Summary/fetchFilteredRows",  
            type:"POST",
            data: data,
        },
        oLanguage: {sProcessing: '<div class="preloader pl-size-sm">'
                                +'<div class="spinner-layer pl-red-grey">'
                                +    '<div class="circle-clipper left">'
                                +        '<div class="circle"></div>'
                                +    '</div>'
                                +    '<div class="circle-clipper right">'
                                +        '<div class="circle"></div>'
                                +    '</div>'
                                +'</div>'
                                +'</div>'}
    });

    
    //remove existing event 
    $( "#datatables tbody" ).unbind('click');

    // Add event listener for opening and closing details
    $('#datatables tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

    $.ajax({
        url:baseurl + "Summary/fetchSummaryDetails", 
        type: 'post',
        data: data,
        dataType: "json",
        success: function (res) {
            if(res.step1_passed == 0 && res.step1_failed == 0) {
                // $('.tally-tbl').hide();
            } else {
                $('.step-score-body').html('');
                $('.step-score-body').append(
                    '<tr>'+
                        '<td><strong>Step 1:</strong></td>'+
                        '<td>'+res.step1_passed+'</td>'+
                        '<td>'+res.step1_failed+'</td>'+
                    '</tr>'
                    );

                $('.step-score-body').append(
                    '<tr>'+
                        '<td><strong>Step 2:</strong></td>'+
                        '<td>'+res.step2_passed+'</td>'+
                        '<td>'+res.step2_failed+'</td>'+
                    '</tr>'
                    );

                $('.step-score-body').append(
                    '<tr>'+
                        '<td><strong>Step 3:</strong></td>'+
                        '<td>'+res.step3_passed+'</td>'+
                        '<td>'+res.step3_failed+'</td>'+
                    '</tr>'
                    );

                $('.step-score-body').append(
                    '<tr>'+
                        '<td><strong>Step 4:</strong></td>'+
                        '<td>'+res.step4_passed+'</td>'+
                        '<td>'+res.step4_failed+'</td>'+
                    '</tr>'
                    );

                $('.step-score-body').append(
                    '<tr>'+
                        '<td><strong>Step 5:</strong></td>'+
                        '<td>'+res.step5_passed+'</td>'+
                        '<td>'+res.step5_failed+'</td>'+
                    '</tr>'
                    );

                $('.step-score-body').append(
                    '<tr>'+
                        '<td><strong>Step 6:</strong></td>'+
                        '<td>'+res.step6_passed+'</td>'+
                        '<td>'+res.step6_failed+'</td>'+
                    '</tr>'
                    );
                var step_params = [{
                    "step": "Step 1",
                    "passed": res.step1_passed,
                    "failed": res.step1_failed
                }, {
                    "step": "Step 2",
                    "passed": res.step2_passed,
                    "failed": res.step2_failed
                }, {
                    "step": "Step 3",
                    "passed": res.step3_passed,
                    "failed": res.step3_failed
                }, {
                    "step": "Step 4",
                    "passed": res.step4_passed,
                    "failed": res.step4_failed
                }, {
                    "step": "Step 5",
                    "passed": res.step5_passed,
                    "failed": res.step5_failed
                }, {
                    "step": "Step 6",
                    "passed": res.step6_passed,
                    "failed": res.step6_failed
                }];
                load_bar_graph(step_params);


                var policy_params = [];
                $('.policy-type-body').html('');
                $.each(res.policy_type_arr, function(k,v) {
                    var series = {
                        "label" : k,
                        "count" : v
                    }
                    policy_params.push(series);
                    $('.policy-type-body').append(
                        '<tr>'+
                            '<td>'+k+'</td>'+
                            '<td width="10%">'+v+'</td>'+
                        '</tr>'
                        );    
                });
                load_graph('policy',policy_params);

                var providers_params = [];
                $('.providers-body').html('');
                $.each(res.providers_arr, function(k,v) {
                    var series = {
                        "label" : k,
                        "count" : v
                    }
                    providers_params.push(series);
                    $('.providers-body').append(
                        '<tr>'+
                            '<td>'+k+'</td>'+
                            '<td width="10%">'+v+'</td>'+
                        '</tr>'
                        );    
                });
                load_graph('providers',providers_params);

                var replacement_params = [];
                $('.replacement-body').html('');
                $.each(res.replacement_arr, function(k,v) {
                    var series = {
                        "label" : k,
                        "count" : v
                    }
                    replacement_params.push(series);
                    $('.replacement-body').append(
                        '<tr>'+
                            '<td>'+k+'</td>'+
                            '<td width="10%">'+v+'</td>'+
                        '</tr>'
                        );    
                });
                load_graph('replacement',replacement_params);
            }
        }
    });

    function load_graph(key, params) {
        switch(key) {
            case "providers" :
                div = "providers-chart-div"
                break;
            case "policy" :
                div = "policy-chart-div"
                break;
            case "replacement" :
                div = "replacement-chart-div"
                break;
        }


        $('#'+key).html('');
        am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end
        am4core.options.autoDispose = true;
        // Create chart instance
        chart = am4core.create(div, am4charts.PieChart);

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "count";
        pieSeries.dataFields.category = "label";

        // Let's cut a hole in our Pie chart the size of 30% the radius
        chart.innerRadius = am4core.percent(30);

        // Put a thick white border around each Slice
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.slices.template
          // change the cursor on hover to make it apparent the object can be interacted with
          .cursorOverStyle = [
            {
              "property": "cursor",
              "value": "pointer"
            }
          ];

        pieSeries.alignLabels = false;
        pieSeries.labels.template.radius = 3;
        pieSeries.labels.template.padding(0,0,0,0);
        pieSeries.labels.template.maxWidth = 130;
        pieSeries.labels.template.wrap = true;
        pieSeries.labels.template.fontSize = 11;

        pieSeries.ticks.template.disabled = true;

        // Create a base filter effect (as if it's not there) for the hover to return to
        var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
        shadow.opacity = 0;

        // Create hover state
        var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

        // Slightly shift the shadow and make it more prominent on hover
        var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
        hoverShadow.opacity = 0.7;
        hoverShadow.blur = 5;

        // Add a legend
        chart.legend = new am4charts.Legend();

        chart.data = params;

        }); // end am4core.ready()
    }

    function load_bar_graph(params) {
        $('#step-chart-div').html('');
        am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end
        am4core.options.autoDispose = true;

        // Create chart instance
        chart = am4core.create("step-chart-div", am4charts.XYChart);

        // Add data
        chart.data = params;

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "step";
        categoryAxis.title.text = "Compliance Step";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 20;
        categoryAxis.renderer.cellStartLocation = 0.1;
        categoryAxis.renderer.cellEndLocation = 0.9;

        var  valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.min = 0;
        valueAxis.title.text = "Headcount";

        // Create series
        function createSeries(field, name, stacked) {
          var series = chart.series.push(new am4charts.ColumnSeries());
          series.dataFields.valueY = field;
          series.dataFields.categoryX = "step";
          series.name = name;
          series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
          series.stacked = stacked;
          series.columns.template.width = am4core.percent(95);
        }

        createSeries("passed", "Passed", false);
        createSeries("failed", "Failed", true);
        // Add legend
        chart.legend = new am4charts.Legend();

        }); // end am4core.ready()
    }
}

function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width: 100%">'+
        '<tr>'+
            '<td width="10%">Policy type sold: </td>'+
            '<td>'+d.policy_type+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Provider: </td>'+
            '<td>'+d.providers+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Replacement: </td>'+
            '<td>'+d.replacement+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Test Result: </td>'+
            '<td>'+d.score_status+'</td>'+
        '</tr>'+
    '</table>';
}

function generatePDF() {
    var baseurl = $('#base_url').val();

    data = {};
    data.info = fetchInfo();
    
    $.ajax({
        url: baseurl+'/summary/generate',
        type: 'post',
        data: data,
        dataType: "json",
        success: function (res) {
            var d = new Date();
            if(res.count > 0) {
                $('[name="adviser_str"]').val(res.adviser_str);
                $('[name="result_str"]').val(res.result_str);

                $('#summaryModal #pdfHere').attr('src', res.link + `?v=${d.getTime()}`);
                $('#summary-printout').attr('disabled', false).removeClass('disabled').text('Print Summary');
                $('.tally-tbl').show();
                $('.filtered-tbl').show();
                // $('.main-panel').animate({ scrollTop: $(".filtered-tbl").offset().top}, 2000);
            } else {
                $('.tally-tbl').hide();
                $('.filtered-tbl').hide();
                $('#summary-printout').attr('disabled', true).addClass('disabled').text('Print Summary');
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
            }
        },
        beforeSend: function () {
            // $('.tally-tbl').hide();
            // $('.filtered-tbl').hide();
            $('#summary-printout').attr('disabled', true).addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        }

    });
}