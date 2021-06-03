$(function(){
	loadTable();

	//Ajax non-forms
	//event triggered upon clicking of view, add or update advisers
    //displays advisers form, adviser details will be displayed for viewing and update 
	$(document).on('click', '#addAdvisersForm, .viewAdvisersForm, .updateAdvisersForm', function (e) {
		e.preventDefault();

		my = $(this)
		id = my.attr('data-id');
		url = my.attr('href');
		privileges_str = '';

		$.ajax({
            type: "POST",
            url: url,
            data: {id:id},
            dataType: "json",
            success: function(result){
                page = my.attr('id');
                if(result.hasOwnProperty("key")){
                    switch(result.key){
                        case 'addAdvisers':
                            page="";
                            $('#myModal .modal-dialog').attr('class','modal-dialog modal-sm');
                            $('#myModal .modal-title').html('Register New Adviser');
                            $('#myModal .modal-body').html(result.form);
                            $('#myModal').modal('show');
                            break;
                        case 'viewAdvisers' :
                        case 'updateAdvisers':
                            $('#myModal .modal-dialog').attr('class','modal-dialog modal-sm');
                            $('#myModal .modal-title').html('Adviser Details');
                            $('#myModal .modal-body').html(result.form);
                            $('#myModal').modal('show');    

                            $.each(my.data(),function(i,v){
		                    	$('.'+i).val(my.data(i)).change(); 
		                    });                 
                            break;
                    }

                    if(result.key =="viewAdvisers"){
                        $('form').find('input, textarea, button, select').attr('disabled','disabled');
                        $('form').find('#cancelUpdateForm').removeAttr('disabled');
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
    //event triggered upon submitting users form
    $(document).on('submit', '#addAdvisers, #updateAdvisers', function (e) {
        e.preventDefault();
        var form = $(this)
        content = "Are you sure you want to proceed?";

        if (form.attr('id') == "addAdvisers") {
            content = "Are you sure you want to add this adviser?";
        }
        if (form.attr('id') == "updateAdvisers") {
            content = "Are you sure you want to update this adviser?";
        }

        url = form.attr('action');
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
                    data: new FormData(form[0]),
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        if (result.hasOwnProperty("key")) {
                            switch (result.key) {
                                case 'addAdvisers':
                                case 'updateAdvisers':    
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
            url:baseurl + "Advisers/fetchRows",  
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