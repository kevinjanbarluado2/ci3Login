<?php
class PolicyTypeSoldCollection extends CI_Model {
    var $select_column = null; 
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $columns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $this->select_column[] = $this->table.'.'.$value;
        }
    }
    
    //set orderable columns in list
    var $table = "product_category";   
    var $order_column = array(
        "code",
        "name",
        ""
    );

    //set searchable parameters in table
    public function getColumns(){
        $rows = array(
            "code",
            "name"
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
    
    //fetch list
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
            $this->db->order_by("idproduct_category DESC");  
        }  
    }

    //get count of all data
    function get_all_data() {  
        $this->db->select($this->table."*");  
        $this->db->from($this->table);
        return $this->db->count_all_results();  
    }  

    //get count of filtered data
    function get_filtered_data(){  
         $this->make_query(); 
         $query = $this->db->get();  
         return $query->num_rows();  
    }  

    //add record
    public function addRows($params){

        $params['status'] = 'Active';
        $params['idproduct_category'] = $params['id'];
        unset($params['id']);
        $this->db->insert($this->table, $params);
        if($this->db->affected_rows() > 0) 
            return true;        
        return false;
    }

    //update record
    public function updateRows($params){
        
        $params['idproduct_category'] = $params['id'];
        unset($params['id']);
        $this->db->where('idproduct_category', $params['idproduct_category']);
        if ($this->db->update($this->table,$params) !== FALSE)
            return true;    
        return false;
    }

    //activate record
    public function activateRows($params){

        $params['status'] = "Active";
        $params['idproduct_category'] = $params['id'];
        unset($params['id']);
        $this->db->where('idproduct_category', $params['idproduct_category']);
        if ($this->db->update($this->table,$params) !== FALSE)
            return true;    
        return false;
    }

    //deactivate record
    public function deactivateRows($params){
        
        $params['status'] = "Inactive";
        $params['idproduct_category'] = $params['id'];
        unset($params['id']);
        $this->db->where('idproduct_category', $params['idproduct_category']);
        if ($this->db->update($this->table,$params) !== FALSE)
            return true;    
        return false;
    }
}
?>