<?php
class AdvisersCollection extends CI_Model {
    var $select_column = null; 
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $columns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $this->select_column[] = $this->table.'.'.$value;
        }
    }
    
    //set orderable columns in advisers_tbl list
    var $table = "advisers_tbl";   
    var $order_column = array(
        "last_name",
        "email",
        "fspr_number",
        "address",
        "trading_name",
        "telephone_no",
        ""
    );

    //set searchable parameters in advisers_tbl table
    public function getColumns(){
        $rows = array(
            "last_name",
            "first_name",
            "middle_name",
            "email",
            "fspr_number",
            "address",
            "trading_name",
            "telephone_no",
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
    
    //fetch list of advisers_tbl
    function make_query() {  
        $this->db->select(
            $this->table.'.*'
        );  
        $this->db->from($this->table);

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
            $this->db->order_by("idusers DESC");  
        }  
    }

    //get count of all advisers_tbl
    function get_all_data() {  
        $this->db->select($this->table."*");  
        $this->db->from($this->table);
        return $this->db->count_all_results();  
    }  

    //get count of filtered advisers_tbl
    function get_filtered_data(){  
         $this->make_query(); 
         $query = $this->db->get();  
         return $query->num_rows();  
    }  

    //add adviser
    public function addRows($params){
        $this->db->insert($this->table, $params);
        if($this->db->affected_rows() > 0) 
            return true;        
        return false;
    }

    //update adviser
    public function updateRows($params){        
        $this->db->where('idusers', $params['idusers']);
        if ($this->db->update($this->table,$params) !== FALSE)
            return true;    
        return false;
    }

    //delete adviser
    public function deleteRows($params){
        $this->db->where('idusers', $params['idusers']);
        if ($this->db->delete($this->table,$params) !== FALSE)
            return true;    
        return false;
    }

    //get all active advisers
    public function getActiveAdvisers(){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by("last_name", "asc");
        // $this->db->where('status', 'Active');
        return $this->db->get()->result_array();
    }

    //get advisers by id
    public function getActiveAdvisersById($id){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('idusers', $id);
        // $this->db->where('status', 'Active');
        return $this->db->get()->row();
    }
}
?>