<?php
class AdvisersCollection extends CI_Model {
    var $select_column = null;
    private $adviceprocess_db = ""; 
    
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->adviceprocess_db = $this->load->database('adviceprocess',TRUE);
        $this->adviceprocess_tbl = "users";

        $columns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $this->select_column[] = $this->adviceprocess_tbl.'.'.$value;
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
            $this->adviceprocess_db->limit($_POST['length'], $_POST['start']);  
        }  

        $query = $this->adviceprocess_db->get();  
        return $query->result();  

    } 
    
    //fetch list of advisers_tbl
    function make_query() {  
        
        $this->adviceprocess_db->select('*');  
        $this->adviceprocess_db->from($this->adviceprocess_tbl);

        if(isset($_POST["search"]["value"])) {  
            $this->adviceprocess_db->group_start();

            foreach ($this->select_column as $key => $value) {
                $this->adviceprocess_db->or_like($value, $_POST["search"]["value"]);  
            }
            
            $this->adviceprocess_db->group_end(); 
        }

        if(isset($_POST["order"])) {    
            $this->adviceprocess_db->order_by($this->order_column[$_POST['order']['0']['column']]." ". $_POST['order']['0']['dir']);
        } else {  
            $this->adviceprocess_db->order_by("idusers DESC");  
        }  
    }

    //get count of all advisers_tbl
    function get_all_data() {  
        $this->adviceprocess_db->select("*");  
        $this->adviceprocess_db->from($this->adviceprocess_tbl);
        return $this->adviceprocess_db->count_all_results();  
    }  

    //get count of filtered advisers_tbl
    function get_filtered_data(){  
         $this->make_query(); 
         $query = $this->adviceprocess_db->get();  
         return $query->num_rows();  
    }  

    //add adviser
    public function addRows($params){
        $this->adviceprocess_db->insert($this->adviceprocess_tbl, $params);
        if($this->adviceprocess_db->affected_rows() > 0) 
            return true;        
        return false;
    }

    //update adviser
    public function updateRows($params){        
        $this->adviceprocess_db->where('idusers', $params['idusers']);
        if ($this->adviceprocess_db->update($this->adviceprocess_tbl,$params) !== FALSE)
            return true;    
        return false;
    }

    //delete adviser
    public function deleteRows($params){
        $this->adviceprocess_db->where('idusers', $params['idusers']);
        if ($this->adviceprocess_db->delete($this->adviceprocess_tbl,$params) !== FALSE)
            return true;    
        return false;
    }

    //get all active advisers
    public function getActiveAdvisers(){
        //$this->db->select('*');
        //$this->db->from($this->table);
        //$this->db->order_by("last_name", "asc");
        //return $this->db->get()->result_array();

        //$this->adviceprocess_db = $this->load->database('adviceprocess',TRUE);
        $this->adviceprocess_db->select('*');
        $this->adviceprocess_db->from('users');
        $this->adviceprocess_db->order_by("last_name", "asc");
        
        
        return $this->adviceprocess_db->get()->result_array();
    }

    //get advisers by id
    public function getActiveAdvisersById($id){
        // $this->db->select('*');
        // $this->db->from($this->table);
        // $this->db->where('idusers', $id);
        
        $this->adviceprocess_db->select('*');
        $this->adviceprocess_db->from('users');
        $this->adviceprocess_db->where('idusers', $id);
        
        
        return $this->adviceprocess_db->get()->row();

        // $this->db->where('status', 'Active');
        //return $this->db->get()->row();
    }
}
?>