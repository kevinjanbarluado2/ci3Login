<?php
class PdfCollection extends CI_Model {
    var $select_column = null; 
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $columns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $this->select_column[] = $this->table.'.'.$value;
        }
    }
    
    //set orderable columns in results_tbl list
    var $table = "results_tbl";   
    var $order_column = array(
        "clients",
        "advisers_tbl.first_name",
        "date_added",
        "date_added",
        ""
    );

    //set searchable parameters in results_tbl table
    public function getColumns(){
        $rows = array(
            "clients",
            "date_added",
            "date_added",
        );
        return $rows; 
    }

    //set limit in datatable
    function make_datatables() {  
        $this->make_query();  
        if($_POST["length"] != -1) {  
            $this->db->limit($_POST['length'], $_POST['start']);  
        }  

        $query = $this->db->get();  
        return $query->result();  

    } 
    
    //fetch list of results_tbl
    function make_query() {  
        $this->select_column[] = 'advisers_tbl.last_name';
        $this->select_column[] = 'advisers_tbl.first_name';
        $this->db->select(
            $this->table.'.*,
            advisers_tbl.first_name,
            advisers_tbl.last_name'
        );  
        $this->db->from($this->table);
        $this->db->join("advisers_tbl",$this->table.".adviser_id = advisers_tbl.idusers","left");

        if(isset($_POST["search"]["value"])) {  
            $this->db->group_start();

            foreach ($this->select_column as $key => $value) {
                $this->db->or_like($value, $_POST["search"]["value"]);  
            }
            
            $this->db->group_end(); 
        }

        if(isset($_POST["order"])) {    
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']]." ". $_POST['order']['0']['dir']);
        } else {  
            $this->db->order_by("results_id DESC");  
        }  
    }

    //get count of all results_tbl
    function get_all_data() {  
        $this->db->select($this->table."*");  
        $this->db->from($this->table);
        return $this->db->count_all_results();  
    }  

    //get count of filtered results_tbl
    function get_filtered_data(){  
         $this->make_query(); 
         $query = $this->db->get();  
         return $query->num_rows();  
    }  

    //delete adviser
    public function deleteRows($params){
        $this->db->where('results_id', $params['results_id']);
        if ($this->db->delete($this->table,$params) !== FALSE)
            return true;    
        return false;
    }

}
?>