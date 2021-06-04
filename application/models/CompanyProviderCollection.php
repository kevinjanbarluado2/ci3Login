<?php
class CompanyProviderCollection extends CI_Model {
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
    var $table = "company_provider";   
    var $order_column = array(
        "company_name",
        "status",
        ""
    );

    //set searchable parameters in table
    public function getColumns(){
        $rows = array(
            "company_name",
            "status"
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
            $this->db->order_by("idcompany_provider DESC");  
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
        $params['idcompany_provider'] = $params['id'];
        unset($params['id']);
        $this->db->insert($this->table, $params);
        if($this->db->affected_rows() > 0) 
            return true;        
        return false;
    }

    //update record
    public function updateRows($params){

        $params['idcompany_provider'] = $params['id'];
        unset($params['id']);
        $this->db->where('idcompany_provider', $params['idcompany_provider']);
        if ($this->db->update($this->table,$params) !== FALSE)
            return true;    
        return false;
    }

    //activate record
    public function activateRows($params){

        $params['status'] = "Active";
        $params['idcompany_provider'] = $params['id'];
        unset($params['id']);
        $this->db->where('idcompany_provider', $params['idcompany_provider']);
        if ($this->db->update($this->table,$params) !== FALSE)
            return true;    
        return false;
    }

    //deactivate record
    public function deactivateRows($params){

        $params['status'] = "Inactive";
        $params['idcompany_provider'] = $params['id'];
        unset($params['id']);
        $this->db->where('idcompany_provider', $params['idcompany_provider']);
        if ($this->db->update($this->table,$params) !== FALSE)
            return true;    
        return false;
    }

    //get all active providers
    public function getActiveProviders(){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by("company_name", "asc");
        $this->db->where('status', 'Active');
        return $this->db->get()->result_array();
    }
}
?>