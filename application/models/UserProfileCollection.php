<?php
class UserProfileCollection extends CI_Model {
    var $select_column = null; 
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $columns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $this->select_column[] = $this->table.'.'.$value;
        }
    }
    
    //set orderable columns in user_tbl list
    var $table = "user_tbl";   
    var $order_column = array(
        "name",
        "email",
        "privileges",
        ""
    );

    //set searchable parameters in user_tbl table
    public function getColumns(){
        $rows = array(
            "name",
            "email",
            "privileges",
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
    
    //fetch list of user_tbl
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
            $this->db->order_by("id DESC");  
        }  
    }

    //get count of all user_tbl
    function get_all_data() {  
        $this->db->select($this->table."*");  
        $this->db->from($this->table);
        return $this->db->count_all_results();  
    }  

    //get count of filtered user_tbl
    function get_filtered_data(){  
         $this->make_query(); 
         $query = $this->db->get();  
         return $query->num_rows();  
    }  

    //get all active privileges
    public function getPrivileges(){
        $this->db->select('*');
        $this->db->from('privilege_tbl');
        $this->db->order_by("id", "asc");
        return $this->db->get()->result_array();
    }

    //add user
    public function addRows($params){
        $params['password'] = md5($params['password']);
        $params['admin'] = 1;

        $this->db->insert('user_tbl', $params);
        if($this->db->affected_rows() > 0) 
            return true;        
        return false;
    }

    //update user
    public function updateRows($params){
        if(!$this->isSamePassword($params['email'], $params['password']))
            $params['password'] = md5($params['password']);
        
        $this->db->where('id', $params['id']);
        if ($this->db->update('user_tbl',$params) !== FALSE)
            return true;    
        return false;
    }

    //check if password is updated
    public function isSamePassword($email,$password){
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        if($this->db->get()->num_rows() > 0){
            return true;
        }
        return false;
    }

    //delete user
    public function deleteRows($params){
        $this->db->where('id', $params['id']);
        if ($this->db->delete($this->table,$params) !== FALSE)
            return true;    
        return false;
    }
}
?>