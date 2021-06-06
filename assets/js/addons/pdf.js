$(function(){
	loadTable();

    //view pdf
    $(document).on('click','#viewPdfForm', function (e) {
        e.preventDefault();

        me = $(this)
        results_id = me.attr('data-results_id');
        url = me.attr('href');

        $.ajax({
            url: url,
            type: 'post',
            data: { 
                results_id : results_id 
            },
            dataType:"json",
            success: function (res) {
                console.log(res);
                var d = new Date();
                $('#pdfHere').attr('src',res.link+`?v=${d.getTime()}`);
                $('#complianceModal').modal('show'); 
        
            }
        });
    });

    //view pdf
    $(document).on('click','#updatePdfForm', function (e) {
        e.preventDefault();

        alert("ONGOING DEVELOPMENT...");
    });

    //delete pdf
    $(document).on('click','#deletePdf', function (e) {
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
        }).then(function(result) {  
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        results_id : results_id
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
});

//initialize table to be displayed
function loadTable(){
	var baseurl = $('#base_url').val();

	table = $('#datatables').DataTable({
		destroy:true,
		processing:true,
		serverSide:true,
		responsive:true,
		order:[],
		columnDefs: [ { orderable: false, targets: -1 } ],
		// scroller: {
		// 	displayBuffer: 20
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
            url:baseurl + "Pdf/fetchRows",  
            type:"POST",
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
}