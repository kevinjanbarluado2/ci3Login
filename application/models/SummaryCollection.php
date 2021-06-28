<?php
class SummaryCollection extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function getResultsById($id, $replacement){
        $this->db->select('
            adviser_id,
            advisers_tbl.last_name AS adviser_last_name,
            advisers_tbl.first_name AS adviser_first_name,
            advisers_tbl.middle_name AS adviser_middle_name,
            GROUP_CONCAT(providers) AS providers,
            GROUP_CONCAT(policy_type) AS policy_type,
            policy_number,
            clients,
            replacement,
            score 
            ');
        $this->db->from('results_tbl');
        $this->db->join("advisers_tbl","results_tbl.adviser_id = advisers_tbl.idusers", "left");

        if($id != '')
            $this->db->where('adviser_id', $id);
        if($replacement != '')
            $this->db->where('replacement',$replacement);

        $this->db->group_by('adviser_id'); 

        if($id != '')
            return $this->db->get()->row();
        else 
            return $this->db->get()->result_array();
    }

    //get provider by id
    public function getProvidersNameById($id){
        $this->db->select('*');
        $this->db->from('company_provider');
        $this->db->where('idcompany_provider', $id);
        return $this->db->get()->row()->company_name;
    }

    //get policy by id
    public function getPolicyNameById($id){
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('idproduct_category', $id);
        return $this->db->get()->row()->name;
    }
}
?>