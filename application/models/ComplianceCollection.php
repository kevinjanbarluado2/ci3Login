<?php
class ComplianceCollection extends CI_Model {    

    public function __construct() {
        parent::__construct();
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
            "token" =>md5(uniqid(rand(), true))
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

    //get compliance result by id
    public function getComplianceResultsById($results_id){
        $this->db->select('*');
        $this->db->from('results_tbl');
        $this->db->where('results_id', $results_id);
        // $this->db->where('status', 'Active');
        return $this->db->get()->row();
    }
}
?>