<?php
class SummaryCollection extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function getResultsById($id, $replacement){
        $this->db->select('
            adviser_id,
            GROUP_CONCAT(providers) AS providers,
            GROUP_CONCAT(policy_type) AS policy_type,
            policy_number,
            clients,
            replacement,
            score 
            ');
        $this->db->from('results_tbl');
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
}
?>