const baseurl = $('#base_url').val();
$(function () {
    $('.select2').select2();
    loadTable();

    //view pdf
    $(document).on('click', '#viewPdfForm', function (e) {
        e.preventDefault();

        me = $(this)
        results_id = me.attr('data-results_id');
        url = me.attr('href');

        $.ajax({
            url: url,
            type: 'post',
            data: {
                results_id: results_id
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

    //view pdf
    $(document).on('click', '#updatePdfForm', function (e) {
         e.preventDefault();

        me = $(this)
        results_id = me.attr('data-results_id');
        url = me.attr('href');

        $.ajax({
            url: url,
            type: 'post',
            data: {
                results_id: results_id
            },
             dataType: "json",
            success: function (res) {
                console.log(res);
                // var d = new Date();
                // var time = d.getTime();
               window.location.replace(`${baseurl}compliance?v=${res.token}`);
            }
        });
    });

    //delete pdf
    $(document).on('click', '#deletePdf', function (e) {
        e.preventDefault();

        me = $(this)
        results_id = me.attr('data-results_id');
        url = me.attr('href');

        content = "Are you sure you want to proceed?";
        if (me.hasClass("deletePdf")) {
            content = "Are you sure you want to delete this PDF?";
        }

        swal({
            text: content,
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        results_id: results_id
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.hasOwnProperty("key")) {
                            switch (result.key) {
                                case 'deletePdf':
                                    loadTable();
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
                                    $('#myModal .modal-body').html('');
                                    $('#myModal').modal('hide');

                                    break;
                            }
                        }
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
            }
        }).catch(swal.noop)

    })

    //Ajax non-forms
    //event triggered upon clicking of send pdf
    //displays send mail form
    $(document).on('click', '#sendEmailForm', function (e) {
        e.preventDefault();

        my = $(this)
        results_id = my.attr('data-results_id');
        url = my.attr('href');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                results_id : results_id
            },
            dataType: "json",
            success: function(result){
                page = my.attr('results_id');
                if(result.hasOwnProperty("key")){
                    switch(result.key){
                        case 'sendEmail':
                            $('#myModal .modal-dialog').attr('class','modal-dialog modal-md');
                            $('#myModal .modal-title').html('System Message');
                            $('#myModal .modal-body').html(result.form);
                            $('#myModal').modal('show');    

                            $.each(my.data(),function(i,v){
                                $('.'+i).val(my.data(i)).change(); 
                            });                 
                            break;
                    }
                }
            },
            error: function(result){
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

    //Ajax non-forms
    //event triggered upon clicking of send pdf (summary)
    //displays send mail form
    $(document).on('click', '#sendSummaryEmailForm', function (e) {
        e.preventDefault();

        my = $(this)
        summary_id = my.attr('data-summary_id');
        url = my.attr('href');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                summary_id : summary_id
            },
            dataType: "json",
            success: function(result){
                page = my.attr('results_id');
                if(result.hasOwnProperty("key")){
                    switch(result.key){
                        case 'sendSummaryEmail':
                            $('#myModal .modal-dialog').attr('class','modal-dialog modal-md');
                            $('#myModal .modal-title').html('System Message');
                            $('#myModal .modal-body').html(result.form);
                            $('#myModal').modal('show');    

                            $.each(my.data(),function(i,v){
                                $('.'+i).val(my.data(i)).change(); 
                            });                 
                            break;
                    }
                }
            },
            error: function(result){
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
    //event triggered upon submitting form
    $(document).on('click', '#sendEmail', function (e) {
        e.preventDefault();
        e.stopPropagation();

        my = $(this);
        url = my.attr('href');

        let data = {};

        data.adviser = $('[name=adviser_id]').val();
        data.filename = $('[name=filename]').val();
        data.includeAdviser = ($('[name=includeAdviser]:checked').val() !== undefined) ? true : false;
        data.complianceOfficer = ($('[name=complianceOfficer]').val() !== "") ? $('[name=complianceOfficer]').val() : "";
        let link = "sendEmail";
        
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            dataType: "json",
            success: function (result) {
                $('#sendEmail').attr('disabled', false).removeClass('disabled').text('Compliance was sent');
                $('input, button').removeAttr('disabled');
                $('#myModal').modal('hide');

                console.log('email sent. (pdf-compliance)');
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
                $('#sendEmail').attr('disabled', true).addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending Email...');
                $('input, button').attr('disabled','disabled');

            },
            error: function (req, err) { 
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
    //event triggered upon submitting form
    $(document).on('click', '#sendSummaryEmail', function (e) {
        e.preventDefault();
        e.stopPropagation();

        my = $(this);
        url = my.attr('href');

        let data = {};

        data.filename = $('[name=filename]').val();
        data.complianceOfficer = ($('[name=complianceOfficer]').val() !== "") ? $('[name=complianceOfficer]').val() : "";
        let link = "sendEmail";
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            dataType: "json",
            success: function (result) {
                $('#sendSummaryEmail').attr('disabled', false).removeClass('disabled').text('Summary was sent');
                $('#myModal').modal('hide');

                console.log('email sent. (pdf-summary)');
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
                $('#sendSummaryEmail').attr('disabled', true).addClass('disabled').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending Email...');
            },
            error: function (req, err) { 
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

    //delete pdf
    $(document).on('click', '#deleteSummary', function (e) {
        e.preventDefault();

        me = $(this)
        summary_id = me.attr('data-summary_id');
        url = me.attr('href');

        content = "Are you sure you want to proceed?";
        if (me.hasClass("deleteSummary")) {
            content = "Are you sure you want to delete this Summary?";
        }

        swal({
            text: content,
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        summary_id: summary_id
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.hasOwnProperty("key")) {
                            switch (result.key) {
                                case 'deleteSummary':
                                    loadTable();
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
                                    $('#myModal .modal-body').html('');
                                    $('#myModal').modal('hide');

                                    break;
                            }
                        }
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
            }
        }).catch(swal.noop)

    })

    //view pdf
    $(document).on('click', '#viewSummaryForm', function (e) {
        e.preventDefault();

        me = $(this)
        summary_id = me.attr('data-summary_id');
        url = me.attr('href');

        $.ajax({
            url: url,
            type: 'post',
            data: {
                summary_id: summary_id
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

    //change filter
    $(document).on('change', '#filter', function (e) {
        var filter = $(this).val();
        if(filter == "summary") {
            $('.compliance-div').hide();
            $('.summary-div').show();
        } else {
            $('.compliance-div').show();
            $('.summary-div').hide();
        }
    });
});

//initialize table to be displayed
function loadTable() {
    var baseurl = $('#base_url').val();

    $('.compliance-div #datatables').DataTable({
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
            $('.compliance-div #search-table').remove();
            var input = $('.compliance-div .dataTables_filter input').unbind(),
                self = this.api(),
                $searchButton = $('<button id="search-table" class="btn btn-primary btn-round btn-xs">')
                    .html('<i class="material-icons">search</i>')
                    .click(function () {

                        if (!$('.compliance-div #search-table').is(':disabled')) {
                            $('.compliance-div #search-table').attr('disabled', true);
                            self.search(input.val()).draw();
                            $('.compliance-div #datatables button').attr('disabled', true);
                            $('.compliance-div .dataTables_filter').append('<div id="search-loader"><br>'
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
            $('.compliance-div .dataTables_filter').append($searchButton).addClass('pull-right');
            $('.compliance-div .dataTables_paginate').addClass('pull-right');
        },
        drawCallback: function (settings) {
            $('.compliance-div #search-loader').remove();
            $('.compliance-div #search-table').removeAttr('disabled');
            $('.compliance-div #datatables button').removeAttr('disabled');
        },
        ajax: {
            url: baseurl + "Pdf/fetchRows",
            type: "POST",
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

    $('.summary-div #datatables-summary').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        order: [],
        columnDefs: [{ orderable: false, targets: -1 }],
        // scroller: {
        //  displayBuffer: 20
        // }
        initComplete: function () {
            $('.summary-div search-table').remove();
            var input = $('.summary-div .dataTables_filter input').unbind(),
                self = this.api(),
                $searchButton = $('<button id="search-table" class="btn btn-primary btn-round btn-xs">')
                    .html('<i class="material-icons">search</i>')
                    .click(function () {

                        if (!$('.summary-div #search-table').is(':disabled')) {
                            $('.summary-div #search-table').attr('disabled', true);
                            self.search(input.val()).draw();
                            $('.summary-div #datatables button').attr('disabled', true);
                            $('.summary-div .dataTables_filter').append('<div id="search-loader"><br>'
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
            $('.summary-div .dataTables_filter').append($searchButton).addClass('pull-right');
            $('.summary-div .dataTables_paginate').addClass('pull-right');
        },
        drawCallback: function (settings) {
            $('.summary-div #search-loader').remove();
            $('.summary-div #search-table').removeAttr('disabled');
            $('.summary-div #datatables button').removeAttr('disabled');
        },
        ajax: {
            url: baseurl + "Summary/fetchRows",
            type: "POST",
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
}