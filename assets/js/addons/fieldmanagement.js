$(function () {
	$('.select2').select2();
	var add_url = '';
	//Ajax non-forms
	//event triggered upon clicking of view, add or update fields
    //displays fields form, fields details will be displayed for viewing and update 
	$(document).on('click', '#addForm, .viewForm, .updateForm', function (e) {
		e.preventDefault();

		my = $(this)
		id = my.attr('data-id');
		url = my.attr('href');
		privileges_str = '';

		if (my.hasClass("addForm")) {
            url = add_url;
        }

		$.ajax({
            type: "POST",
            url: url,
            data: {id:id},
            dataType: "json",
            success: function(result){
                page = my.attr('id');
                if(result.hasOwnProperty("key")){
                    switch(result.key){
                        case 'add':
                            page="";
                            $('#myModal .modal-dialog').attr('class','modal-dialog modal-sm');
                            $('#myModal .modal-title').html('Add Record');
                            $('#myModal .modal-body').html(result.form);
                            $('#myModal').modal('show');
                            break;
                        case 'view' :
                        case 'update':
                            $('#myModal .modal-dialog').attr('class','modal-dialog modal-sm');
                            $('#myModal .modal-title').html('Record Details');
                            $('#myModal .modal-body').html(result.form);
                            $('#myModal').modal('show');  

                            $.each(my.data(),function(i,v){
		                    	$('.'+i).val(my.data(i)).change(); 
		                    });

                            break;
                    }

                    if(result.key =="view"){
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
    //event triggered upon submitting form
    $(document).on('submit', '#add, #update', function (e) {
        e.preventDefault();
        var form = $(this)
        content = "Are you sure you want to proceed?";

        if (form.attr('id') == "add") {
            content = "Are you sure you want to add this record?";
        }
        if (form.attr('id') == "update") {
            content = "Are you sure you want to update this record?";
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
                                case 'add':
                                case 'update':    
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

    //activate/deactive record
    $(document).on('click','#activate, #deactivate', function (e) {
        e.preventDefault();
        
        me = $(this)
        id = me.attr('data-id');
        url = me.attr('href');

        content = "Are you sure you want to proceed?";
        if (me.hasClass("activate")) {
            content = "Are you sure you want to activate this record?";
        }
        if (me.hasClass("deactivate")) {
            content = "Are you sure you want to deactivate this record?";
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
                        id : id
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.hasOwnProperty("key")) {
                            switch (result.key) {
                            	case 'activate':   
                                case 'deactivate':    
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

	//trigger when selecting filter
	//set datatables header and url
    $(document).on('change','#filter', function (e) {
    	var baseurl = $('#base_url').val();
    	var filter = $('#filter').val();

    	switch(filter) {
    		case "provider" :
    			add_url = baseurl + "CompanyProvider/addForm";
    			$('#datatables_wrapper').remove();
	    		$('.table-responsive').html(
	    			'<table id="datatables" class="filter-table table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">'+
		    			'<thead class=" text-primary">' +
				    		'<tr>'+
								'<th>Name</th>'+
								'<th width="20%">Status</th>'+
								'<th width="20%">Action</th>'+
							'</tr>'+
						'</thead>'+
					'</table>'
	    		);
    			break;
    		case "policy-type-sold" :
    			add_url = baseurl + "PolicyTypeSold/addForm";
    			$('#datatables_wrapper').remove();
	    		$('.table-responsive').html(
	    			'<table id="datatables" class="filter-table table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">'+
		    			'<thead class=" text-primary">' +
				    		'<tr>'+
				    			'<th width="20%">Code</th>'+
								'<th>Name</th>'+
								'<th width="20%">Status</th>'+
								'<th width="20%">Action</th>'+
							'</tr>'+
						'</thead>'+
					'</table>'
	    		);
    			break;
    		default :
    			$('#table-div').hide();
    			break;
    	}
    	$('#table-div').show();
    	loadTable();
    	
    });
});

//initialize table to be displayed
function loadTable(){
	var baseurl = $('#base_url').val();
	var filter = $('#filter').val();

	switch(filter) {
		case "provider" :
			url = baseurl + "CompanyProvider/fetchRows";
			break;
		case "policy-type-sold" :
			url = baseurl + "PolicyTypeSold/fetchRows";
			break;
		default :
			//do nothing
			break;
	}

	table = $('#datatables').DataTable({
		destroy:true,
		processing:true,
		serverSide:true,
		responsive:true,
		order:[],
		// columnDefs: [ { orderable: false, targets: -1 } ],
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
            url:url,
            data: {
            	filter : filter
            },
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
	}).clear().draw();
}