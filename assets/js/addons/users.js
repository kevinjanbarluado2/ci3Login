$(function(){
	var privileges_str = '';
	loadTable();

	//Ajax non-forms
	//event triggered upon clicking of view, add or update users
    //displays users form, users details will be displayed for viewing and update 
	$(document).on('click', '#addUserProfileForm, .viewUserProfileForm, .updateUserProfileForm', function (e) {
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
                        case 'addUserProfile':
                            page="";
                            $('#myModal .modal-dialog').attr('class','modal-dialog modal-xl');
                            $('#myModal .modal-title').html('Register New User Account');
                            $('#myModal .modal-body').html(result.form);
                            $('#myModal').modal('show');
                            break;
                        case 'viewUserProfile' :
                        case 'updateUserProfile':
                            $('#myModal .modal-dialog').attr('class','modal-dialog modal-xl');
                            $('#myModal .modal-title').html('User Details');
                            $('#myModal .modal-body').html(result.form);
                            $('#myModal').modal('show');    

                            $.each(my.data(),function(i,v){
                            	if(i == 'privileges') {
                            		$('input:checkbox').prop('checked', false);

                            		privileges_str = my.data(i);
  									var privileges_arr = privileges_str.split(",");
			                    	
			                    	$.each(privileges_arr, function(k, v) {
								  		$('#checkbox_'+v).prop('checked',true);
									});
			                    } 

		                    	$('.'+i).val(my.data(i)).change(); 
		                    });

		                                         
                            break;
                    }

                    if(result.key =="viewUserProfile"){
                        $('form').find('input, textarea, button, select').attr('disabled','disabled');
                        $('form').find('#cancelUpdateForm').removeAttr('disabled');
                    }


					$('.bootstrap-switch').each(function(){
					    $this = $(this);
					    data_on_label = $this.data('on-label') || '';
					    data_off_label = $this.data('off-label') || '';

					    $this.bootstrapSwitch({
					        onText: data_on_label,
					        offText: data_off_label
					    });
					});
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

    //updates privilege column depending on selected checkbox
	$(document).on('click', 'input:checkbox', function (e) {
		var val = $(this).is(":checked");
		var name = $(this).attr('data-value');
		if(val === true) {
			if(privileges_str == '') 
				privileges_str = name;
			else 
				privileges_str = privileges_str + ','+name;
		} else  {
			var privileges_arr = privileges_str.split(",");
			var index = privileges_arr.indexOf(name);
			if (index >= 0) {
			  privileges_arr.splice( index, 1 );
			}

			privileges_str = '';
			$.each(privileges_arr, function(k, v) {
		  		if(privileges_str == '')
		  			privileges_str = v;
		  		else 
		  			privileges_str = privileges_str + ','+v;
		  		
			});
		}
		$('#privileges').val(privileges_str);
	});

    //Ajax Forms
    //event triggered upon submitting users form
    $(document).on('submit', '#addUserProfile, #updateUserProfile', function (e) {
        e.preventDefault();
        var form = $(this)
        content = "Are you sure you want to proceed?";

        if (form.attr('id') == "addUserProfile") {
            content = "Are you sure you want to add this user?";
        }
        if (form.attr('id') == "updateUserProfile") {
            content = "Are you sure you want to update this user?";
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
                                case 'addUserProfile':
                                case 'updateUserProfile':    
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

    //delete user
    $(document).on('click','#deleteUserProfile', function (e) {
        e.preventDefault();
        
        me = $(this)
        id = me.attr('data-id');
        url = me.attr('href');

        content = "Are you sure you want to proceed?";
        if (me.hasClass("deleteUserProfile")) {
            content = "Are you sure you want to delete this user?";
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
                                case 'deleteUserProfile':    
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
            url:baseurl + "UserProfile/fetchRows",  
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