var procTable;

$(function() {
const base_url = $('#base_url').val();


var $m=$('#salesMonth').val();
var $y=$('#salesYear').val();

var procTable = $('#procTable').DataTable( {
     "processing": true,
    // "autoWidth": true,
   //  "serverSide": true,
    "responsive":true,
       "language": {                
            "infoFiltered": "",

      },
     "ajax": {
           'type':'get',
            "url": base_url+"/ProcurementController/procurementJSON"
        },
    "bSort": false
 
});

var productsTable= $('#productsTable').DataTable( {
     "processing": true,
    // "autoWidth": true,
   //  "serverSide": true,
    "responsive":true,
       "language": {                
            "infoFiltered": "",

      },
     "ajax": {
           'type':'get',
            "url": base_url+"/ProductsController/productsJSON"
        },
    "bSort": false
 
});



function salesTable($m,$y){
  var salesTable = $('#salesTable').DataTable( {
     "processing": true,
     "autoWidth": true,
    // "serverSide": true,
     "responsive":true,
       "language": {                
            "infoFiltered": ""
      },
     "ajax": {
           'type':'get',
            "url": base_url+"/SalesController/salesEdittedJSON",
            "data":{'month':$m,'year':$y}
        },
     "columnDefs": [
    { "width": "10%", "targets": 6 }
      ],

    "bSort": false
    });


}
 salesTable($m,$y);


  $('.salesDate').on('change',function(){


    var $m=$('#salesMonth').val();
    var $y=$('#salesYear').val();
    var table = $('#salesTable').DataTable();
    $('#salesTable').DataTable().destroy();
    table.clear().draw();
    salesTable($m,$y);

      //var table = $('#salesTable').DataTable();


  });






function toast($msg){

$.toast({
    heading: 'Alert',
    text: $msg,
    showHideTransition: 'slide',
    icon: 'info'
})
}

$('#products').on('change',function(){

var $selected = $(this).children('option:selected').val();
var $price = $(this).children('option:selected').data('price');
$('#price').val($price).trigger('keyup');
});

/*
$('#qty').on('keyup',function(){
var $total = $('#total');
var $price = $('#price');
var $qty = $(this);
if($price.val()!=''){
var $formula = $price.val()*$qty.val();
$total.val($formula.toFixed(2));
}
});

$('#price').on('keyup',function(){
var $total = $('#total');
var $price = $(this);
var $qty = $('#qty');
if($qty.val()!=''){
var $formula = $price.val()*$qty.val();
$total.val($formula.toFixed(2));
}
});
*/


$('.saleTotalChange').on('change',function(){
var $total = $('#total');
var $qty = $('#qty').val(); 
var $price = $('#price').val(); 
var $af = $('#AFee').val(); 
var formula = parseFloat((parseFloat($qty)*$price)-parseFloat($af));
$total.val(formula.toFixed(2));
});







//add product
$('#addProduct').on('click',function(){

var data={};

data['status'] = $("input[name='status']:checked").val();

$('.fetchMe').each(function(x,y){
data[$(y).attr('name')]=$(y).val();
data['productsId'] = $('#products').children('option:selected').val(); 
data['paymentMethod'] = $('#paymentMethod').children('option:selected').val();
//111620
data['additionalFee'] = $('#AFee').val();

});
//adding product

  //start ajax
  $.ajax({
  url:base_url+'/SalesController/addSales',
  type:"post",
  data:{'data':data},
  
  success:function(data){
  $('#addProduct').attr('disabled',false).html("Add Product");
  $("#addSaleModal").modal('hide');
  toast('Successfully Added');
  $('#salesTable').DataTable().ajax.reload();
           
  
  
  },
  beforeSend:function(){
  $('#addProduct').attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
  
  }
  
  
  
  });
  //end ajax



});//end add product




$('#salesModal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('title'); 
  var action = button.data('action'); 
  var modal = $(this);
  var myId = button.data('myid');
  var button = '';
  var myText = '';
  //var myId = button.data('myId');
  //var mytarget= button.data('mytarget');

  switch(action) {
  case 'view':
    var $ajax = function(){
    var tmp=null;
    $.ajax({
    async:false,
    url:base_url+'/SalesController/viewCustomer',
    type:"post",
    data:{'id':myId},
    success:function(data){
    tmp=data;
    }
    });
      return tmp;
    }();

    button = 'View';
    myText = $ajax;
    modal.find('.modal-title').text(recipient);
    modal.find('.modal-body input').val(recipient);
    modal.find('.modal-body').html(myText);
    modal.find('#repButton').text(button).addClass('viewMe d-none').data('id',myId).removeClass('updateMe').removeClass('deleteMe');
    break;
  case 'edit':

    button = 'Update';
    myText = $('#updateTable').html();
    modal.find('.modal-title').text(recipient);
    modal.find('.modal-body input').val(recipient);
    modal.find('.modal-body').html(myText);
    modal.find('#repButton').text(button).addClass('updateMe').removeClass('d-none').removeClass('viewMe').data('id',myId).removeClass('deleteMe');
    var $salesId=modal.find('#repButton').data('id');

    $.ajax({
    async:false,
    url:base_url+'/SalesController/updateCustomer',
    type:"post",
    dataType:"json",
    data:{'id':myId,'salesId':$salesId},
    success:function(data){
    var $parsed = $.parseJSON(data);
    console.log($parsed);
       $('#salesModal input[name="updateId"]').val($parsed['salesId']);
       $('#salesModal input[name="customer"]').val($parsed['customer']);
       $('#salesModal input[name="address"]').val($parsed['address']);
       $('#salesModal input[name="date"]').val($parsed['date']);
       $('#salesModal select[name="products"]').val($parsed['productsId']);
       $('#salesModal select[name="paymentMethod"]').val($parsed['paymentMethod']);
       $('#salesModal input[name="price"]').val($parsed['price']);
       $('#salesModal input[name="qty"]').val($parsed['qty']);

       //$('#salesModal input[name="status"]').val($parsed['status']);
        $('#salesModal input[name="status"]').each(function(){
          if($(this).val()==$parsed['status']){
            $(this).attr('checked','checked');

          }
      });

       $('#salesModal textarea[name="notes"]').val($parsed['notes']);
       $('#salesModal input[name="orderNumber"]').val($parsed['orderNumber']);
       $('#salesModal input[name="additionalFee"]').val($parsed['additionalFee']);


       var $updateTotal = parseFloat((parseFloat($parsed['price'])*$parsed['qty'])-parseFloat($parsed['additionalFee']));


       $('#salesModal input[name="updatetotal"]').val($updateTotal.toFixed(2));


       $('.UsaleTotalChange').on('change',function(){

        var $total = $('#salesModal #updatetotal');
        var $qty = $('#salesModal #updateqty').val(); 
        var $price = $('#salesModal #updateprice').val(); 
        var $af = $('#salesModal #uAFee').val(); 

        var formula = parseFloat((parseFloat($qty)*$price)-parseFloat($af));
        console.log(formula);
        $total.val(formula.toFixed(2));
        });
        


       /*
       $('#salesModal #updateqty').on('keyup',function(){
        var $total = $('#salesModal #updatetotal');
        var $price = $('#salesModal #updateprice');
        var $qty = $(this);
        if($price.val()!=''){
        var $formula = $price.val()*$qty.val();
        $total.val($formula.toFixed(2));
        }
        });
        
        
        
        
        $('#salesModal #updateprice').on('keyup',function(){
        var $total = $('#salesModal #updatetotal');
        var $price = $(this);
        var $qty = $('#salesModal #updateqty');
        if($qty.val()!=''){
        var $formula = $price.val()*$qty.val();
        $total.val($formula.toFixed(2));
        }
        });

  */

      $('#salesModal #updateProducts').on('change',function(){
      var $selected = $(this).children('option:selected').val();
      var $price = $(this).children('option:selected').data('price');
      $('#salesModal #updateprice').val($price).trigger('keyup');
      });

    }
    });


    break;
  case 'delete':
    button = 'Delete';
    myText = 'Are you sure you want to delete this?';
    modal.find('.modal-title').text(recipient);
    modal.find('.modal-body input').val(recipient);
    modal.find('.modal-body').html(myText);
    modal.find('#repButton').text(button).addClass('deleteMe').removeClass('d-none').data('id',myId).removeClass('updateMe').removeClass('viewMe');
    break;
  default:
    // code block


}

  //if confirm button
  $('#repButton').on('click',function(e){
    e.stopImmediatePropagation();
    e.preventDefault();
    var $button=$(this).html();
    switch($button){
      case 'Update':
      
      var data={};

      data['status'] =  $('#salesModal input[name="status"]:checked').val();
      
      $('.updateModal').each(function(x,y){
      data[$(y).attr('name')]=$(y).val();
      data['productsId'] = $('#salesModal #updateProducts').children('option:selected').val(); 
      data['paymentMethod'] = $('#salesModal #updatepaymentMethod').children('option:selected').val(); 
      });


      var $custId = $('#salesModal .updateThis').val();
      console.log(data);
      $.ajax({
      url:base_url+'/SalesController/updateSales',
      type:"post",
      data:{'data':data,'updateId':$custId},
      
      success:function(data){
      //console.log(data);
      $('.updateMe').attr('disabled',false);
      $("#salesModal").modal('hide');
      toast('Successfully Updated');
      $('#salesTable').DataTable().ajax.reload();
      
      
      },
      beforeSend:function(){
      $('.updateMe').attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
      
      }


     });




      return;
      break;
      case 'Delete':
      var $button = $(this);
      var $targetId = $(this).data('id');
  
  
       $.ajax({
      url:base_url+'/SalesController/deleteSales',
      type:"post",
      data:{'id':$targetId},
      
      
      success:function(data){
      $button.attr('disabled',false);
      modal.modal('hide');
      
      
      toast('Successfully Deleted');
  
      $('#salesTable').DataTable().ajax.reload();
  
  

      
      },
      beforeSend:function(){
      $button.attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
      
      }
        
    });
       return;
      break;


    }

  });






});

//prod Modal
$('#procModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var title = button.data('title'); 
  var action = button.data('action'); 
  var modal = $(this);
  var myId = button.data('myid');

  var button = '';
  var myText = '';
  modal.find('.modal-title').text(title);
  modal.find('.modal-body input').val(title);

  
   

  switch(action) {
    case 'add':
    button="Add Inventory";
    myText = $('#addProcMe').html();
    //console.log(myText);

    break;
    case 'edit':
    //console.log(myId);
    myText = $('#addProcMe').html();
    $.ajax({
    url:base_url+'/ProcurementController/fetchProc',
    type:"post",
    dataType:"json",
    data:{'id':myId},
    success:function(data){
    var $parsed = $.parseJSON(data);
    //console.log($parsed);
    $('#procModal .fetchProcMe').each(function(x,y){
    var $name = $(y).attr('name');
    $(y).attr('name',$name).val($parsed[$name]);
    });
    $('.procTotal').trigger('change');

    }
    });


    button="Update";
   
    
    break;

    case 'delete':
    myText = 'Are you sure you want to delete this?';
    button="Delete";


    break;

    default:
    break;
  
  
  }
 modal.find('.modal-body').html(myText);
 $('#procButton').html(button);
 //$('#procButton').data('id',myId);
$('#procButton').attr('myId',myId);

$('.procTotal').on('change',function(){
var $qty = $('#procQty').val(); 
var $price = $('#procPrice').val(); 
var $sf = $('#procSF').val(); 
var formula = parseFloat((parseFloat($qty)*$price)+parseFloat($sf));
$('#procTotal').val(formula.toFixed(2));

});




$('#procButton').on('click',function(e){
    e.stopImmediatePropagation();
    e.preventDefault();
    var $button=$(this).html();
    var $targetId=$('#procButton').attr('myId');

    switch($button){
    case 'Add Inventory':
    var data={};
    $('#procModal .fetchProcMe').each(function(x,y){
    data[$(y).attr('name')]=$(y).val();
    });

      //start ajax
      $.ajax({
      url:base_url+'/ProcurementController/addProc',
      type:"post",
      data:{'data':data},
      
      success:function(data){
         $('#procButton').attr('disabled',false).html(myText);
               $("#procModal").modal('hide');
               toast('Successfully Added');
               procTable.ajax.reload();
               
      
      
      },
      beforeSend:function(){
      $('#procButton').attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
      
      }
      
      
      
      });
      //end ajax


    //adding product
    ;break;
     case 'Delete':
        $.ajax({
        url:base_url+'/ProcurementController/deleteProc',
        type:"post",
        data:{'id':$targetId},
        
        
        success:function(data){
        $('#procButton').attr('disabled',false).html(myText);
        $("#procModal").modal('hide');
        toast('Successfully Deleted');
        procTable.ajax.reload();

        //procTable();
                 
        
        
        },
        beforeSend:function(){
        $('#procButton').attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
        
        }
          
        });


       return;
      break;

      case 'Update':
      
     var data={};
     $('#procModal .fetchProcMe').each(function(x,y){
     data[$(y).attr('name')]=$(y).val();
     });
     //console.log($targetId);
      //start ajax
      $.ajax({
      url:base_url+'/ProcurementController/updateProc',
      type:"post",
      data:{'id':$targetId,'data':data},
      
      success:function(data){
      $('#procButton').attr('disabled',false).html(myText);
               $("#procModal").modal('hide');
               toast('Successfully Updated');
               procTable.ajax.reload();
               
      
      
      },
      beforeSend:function(){
      $('#procButton').attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
      
      }
      
      
      
      });
      //end ajax
        // procTable.ajax.reload();

      break;

    default:

    ;break;

    }

});



});//End Procurement









//products Modal
$('#productsModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var title = button.data('title'); 
  var action = button.data('action'); 
  var modal = $(this);
  var myId = button.data('myid');

  var button = '';
  var myText = '';
  modal.find('.modal-title').text(title);
  modal.find('.modal-body input').val(title);

    //alert(action);
   

  switch(action) {
    case 'add':
    button="Add Product";
    myText = $('#addProductsMe').html();
    //console.log(myText);

    break;
    case 'edit':
    //console.log(myId);
    myText = $('#addProductsMe').html();
    $.ajax({
    url:base_url+'/ProductsController/fetchProduct',
    type:"post",
    dataType:"json",
    data:{'id':myId},
    success:function(data){
    var $parsed = $.parseJSON(data);
    //console.log($parsed);
    $('#productsModal .fetchProducts').each(function(x,y){
    var $name = $(y).attr('name');
    $(y).attr('name',$name).val($parsed[$name]);
    });
    //$('.procTotal').trigger('change');

    }
    });


    button="Update";
   
    
    break;

    case 'delete':
    var myText="";
    txt1= 'Are you sure you want to delete this?';
    txt2='<ul><li class="text-danger">Sales Table will be affected</li></ul>';
    myText=txt1.concat(txt2);
    button="Delete";


    break;

    default:
    break;
  
  
  }
  modal.find('.modal-body').html(myText);
 $('#productsButton').html(button);
 //$('#procButton').data('id',myId);
  $('#productsButton').attr('myId',myId);

/*
$('.procTotal').on('change',function(){
var $qty = $('#procQty').val(); 
var $price = $('#procPrice').val(); 
var $sf = $('#procSF').val(); 
var formula = parseFloat((parseFloat($qty)*$price)+parseFloat($sf));
$('#procTotal').val(formula.toFixed(2));

});

*/


$('#productsButton').on('click',function(e){
    e.stopImmediatePropagation();
    e.preventDefault();
    var $button=$(this).html();
    var $targetId=$('#productsButton').attr('myId');

    switch($button){
    case 'Add Product':
    var data={};
    $('#productsModal .fetchProducts').each(function(x,y){
    data[$(y).attr('name')]=$(y).val();
    });

      //start ajax
      $.ajax({
      url:base_url+'/ProductsController/addProduct',
      type:"post",
      data:{'data':data},
      
      success:function(data){
              $('#productsButton').attr('disabled',false).html(myText);
               $('#productsModal').modal('hide');
               toast('Successfully Added');
               productsTable.ajax.reload();
               
      
      
      },
      beforeSend:function(){
      $('#productsButton').attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
      
      }
      
      
      
      });
      //end ajax


    //adding product
    ;break;
     case 'Delete':
      $.ajax({
      url:base_url+'/ProductsController/deleteProduct',
      type:"post",
      data:{'id':$targetId},
      
      
      success:function(data){
           $('#productsButton').attr('disabled',false).html(myText);
               $('#productsModal').modal('hide');
               toast('Successfully Deleted');
               productsTable.ajax.reload();
      //procTable();
               
      
      
      },
      beforeSend:function(){
      $('#productsButton').attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
      
      }
        
      });


       return;
      break;

      case 'Update':
      
     var data={};
     $('#productsModal .fetchProducts').each(function(x,y){
     data[$(y).attr('name')]=$(y).val();
     });
     //console.log($targetId);
      //start ajax
      $.ajax({
      url:base_url+'/ProductsController/updateProduct',
      type:"post",
      data:{'id':$targetId,'data':data},
      
      success:function(data){
      $('#productsButton').attr('disabled',false).html(myText);
               $("#productsModal").modal('hide');
               toast('Successfully Updated');
           productsTable.ajax.reload();
               
      
      
      },
      beforeSend:function(){
      $('#productsButton').attr('disabled',true).html('loading<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
      
      }
      
      
      
      });
      //end ajax
        // procTable.ajax.reload();

      break;

    default:

    ;break;

    }

});



});//End Procurement

//start report

$('#generateReport').on('click',function(){

var data={};
data['reportsFrom'] = $('#reportsFrom').val();
data['reportsUntil'] = $('#reportsUntil').val();
$('#reportsTable').removeClass('d-none');
var d = new Date('2020-08-01');

  $.ajax({
      url:base_url+'/ReportsController/generateReport',
      type:"post",
      data:{data:data},
      dataType:'json',
      success:function(data){
        console.log(data);
        $('#reportsTbody').html(data['html']);
        $('#hiddenButtons').show();
  
          $('#printReport').on('click',function(){
          $('#printMe').printThis({
          importCSS: true,
          header: "<h1>Reports Summary </h1><h3>"+data['dateFrom']+"-"+data['dateUntil']+"</h3>"


          });
    });


      }

  })


});
//to CSV
$('#toCSV').on('click',function(){
jQuery('#reportsTable').tableHTMLExport({

  // csv, txt, json, pdf
  type:'csv',

  // default file name
  filename: 'reportSales.csv',

  // for csv
  separator: ',',
  newline: '\r\n',
  trimContent: true,
  quoteFields: true,

  // CSS selector(s)
  ignoreColumns: '',
  ignoreRows: '',
                
  // your html table has html content?
  htmlContent: false,
  
  // debug
  consoleLog: false,        

});

});

//to PDF





//end report




});