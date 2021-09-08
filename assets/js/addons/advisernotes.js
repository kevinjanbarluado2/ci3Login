const baseurl = $('#base_url').val();
$(function () {
    loadTable();

    //view pdf
    $(document).on('click', '#viewPdfForm', function (e) {
        e.preventDefault();

        me = $(this)
        results_id = me.attr('data-results_id');
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
});

//initialize table to be displayed
function loadTable() {
    var baseurl = $('#base_url').val();

    $('#datatables').DataTable({
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
            url: baseurl + "AdviserNotes/fetchRows",
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