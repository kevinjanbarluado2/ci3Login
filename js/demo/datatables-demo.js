// Call the dataTables jQuery plugin
$(document).ready(function() {
const base_url = $('#base_url').val();

//console.log(base_url+"/SalesController/salesEdittedJSON");

  $('#dataTable').DataTable({
    "aoColumnDefs": [

        { "bSortable": false, "aTargets": [ 0, 1, 2, 3,4 ] }, 
        //{ "bSearchable": false, "aTargets": [ 0, 1, 2, 3,4 ] }
    ],
    "order": [[ 0, "desc" ]]
});


  



});
