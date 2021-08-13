<?php
class ComplianceCollection extends CI_Model {    
    var $select_column = null;
    private $adviceprocess_db = ""; 
    

    public function __construct() {
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
         $rows = array();
         return $rows; 
     }
 
     //set limit in datatable
     function make_datatables($adviserId) { 
 
         $this->make_query($adviserId);  
         if($_POST["length"] != -1) {  
             $this->adviceprocess_db->limit($_POST['length'], $_POST['start']);  
         }  
 
         $query = $this->adviceprocess_db->get();  
         return $query->result();  
 
     } 
     function make_query($adviserId="") {  
        $this->select_column[] = 'JSON_EXTRACT(t.soa_data, "$.clientFirstname")';
        $this->select_column[] = 'JSON_EXTRACT(t.soa_data, "$.clientSurname")';
        $this->select_column[] = 't.title';
        $this->select_column[] = 'DATE_FORMAT(FROM_UNIXTIME(t.timestamp), "%d %M %Y")';

        $this->adviceprocess_db->select('*');  
        $this->adviceprocess_db->from('document d');
        $this->adviceprocess_db->join('transaction t','t.idtransaction = d.transaction_idtransaction');
        $this->adviceprocess_db->join('users u','u.idusers = d.users_idusers');
        $this->adviceprocess_db->where('d.users_idusers',$adviserId);  
        $this->adviceprocess_db->where('t.type','SOA');  
        $this->adviceprocess_db->order_by("iddocument DESC");  
        //$this->adviceprocess_db->where('idusers',$adviserId);

        if(isset($_POST["search"]["value"])) {  
            $this->adviceprocess_db->group_start();

            foreach ($this->select_column as $key => $value) {
                $this->adviceprocess_db->or_like($value, $_POST["search"]["value"]);  
            }
            
            $this->adviceprocess_db->group_end(); 
        }

        // if(isset($_POST["order"])) {    
        //     $this->adviceprocess_db->order_by($this->order_column[$_POST['order']['0']['column']]." ". $_POST['order']['0']['dir']);
        // } else {  
        //     $this->adviceprocess_db->order_by("idusers DESC");  
        // }  
    } 

       //get count of all advisers_tbl
       function get_all_data($adviserId="") {  
        $this->make_query($adviserId); 
        $query = $this->adviceprocess_db->get();  
        return $query->num_fields();
    }  

    //get count of filtered advisers_tbl
    function get_filtered_data($adviserId=""){  
         $this->make_query($adviserId); 
         $query = $this->adviceprocess_db->get();  
         return $query->num_rows();  
    }  

    //insert compliance result
    public function savecompliance($params){

        $total_score = 0;
        for($i = 1; $i <= 6; $i++) :
            foreach ($params['data']['step'.$i] as $ind => $x) :
                $total_score += $x['value'];
            endforeach;
        endfor;

        $params2 = array(
            "providers" => implode(',', $params['data']['info']['providers']),
            "policy_type" => implode(',', $params['data']['info']['policyType']),
            "policy_number" => $params['data']['info']['policyNumber'],
            "adviser_id" => $params['data']['info']['adviser'],
            "clients" => $params['data']['info']['client'],
            "replacement" => $params['data']['info']['replacement'],
            "filename" => $params['data']['info']['filename'],
            "added_by" => $_SESSION['id'],
            "answers" => json_encode($params['data']),
            "score" => $total_score,
            "token" => $params['data']['info']['token']
        );

        $this->db->insert('results_tbl', $params2);
        if($this->db->affected_rows() > 0) {
            $insert_id = $this->db->insert_id();
            return $insert_id;        
        }
        return false;
    }

    //update compliance result
    public function updatecompliance($params){

        $total_score = 0;
        for($i = 1; $i <= 6; $i++) :
            foreach ($params['data']['step'.$i] as $ind => $x) :
                $total_score += $x['value'];
            endforeach;
        endfor;

        $params2 = array(
            "providers" => implode(',', $params['data']['info']['providers']),
            "policy_type" => implode(',', $params['data']['info']['policyType']),
            "policy_number" => $params['data']['info']['policyNumber'],
            "adviser_id" => $params['data']['info']['adviser'],
            "clients" => $params['data']['info']['client'],
            "replacement" => $params['data']['info']['replacement'],
            "filename" => $params['data']['info']['filename'],
            "added_by" => $_SESSION['id'],
            "answers" => json_encode($params['data']),
            "score" => $total_score
        );

        $this->db->where('results_id', $params['results_id']);
        if ($this->db->update('results_tbl', $params2) !== FALSE)
            return true;    
        return false;
    }

    //insert compliance chat/notes
    public function savechat($params){

        $params['user_id'] = $_SESSION['id'];
        $this->db->insert('chat_tbl', $params);
        if($this->db->affected_rows() > 0) 
            return true;        
        return false;
    }

    //get compliance result by id
    public function getComplianceResultsById($results_id){
        $this->db->select('*');
        $this->db->from('results_tbl');
        $this->db->where('results_id', $results_id);
        // $this->db->where('status', 'Active');
        return $this->db->get()->row();
    }

    //get all chat/notes by token
    public function get_chat($token){
        $this->db->select('
            chat_tbl.*,
            user_tbl.name AS user_name
        ');
        $this->db->from('chat_tbl');
        $this->db->join('user_tbl','user_tbl.id = chat_tbl.user_id','left');
        $this->db->where('chat_tbl.results_token', $token);
        $this->db->order_by("chat_tbl.timestamp", "asc");
        
        return $this->db->get()->result_array();
    }
}
?>