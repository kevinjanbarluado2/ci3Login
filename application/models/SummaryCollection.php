<?php
class SummaryCollection extends CI_Model {
    var $select_column = null;
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $columns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $this->select_column[] = $this->table . '.' . $value;
        }
    }

    //set orderable columns in summary_tbl list
    var $table = "summary_tbl";
    var $order_column = array(
        "filename",
        "",
        "date_generated",
        ""
    );

    //set searchable parameters in summary_tbl table
    public function getColumns()
    {
        $rows = array(
            "filename",
            "date_generated",
        );
        return $rows;
    }

    //set limit in datatable
    function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    //fetch list of summary_tbl
    function make_query()
    {
        // $this->select_column[] = 'advisers_tbl.last_name';
        // $this->select_column[] = 'advisers_tbl.first_name';
        $this->db->select(
            $this->table . '.*'
        );
        $this->db->from($this->table);
        // $this->db->join("advisers_tbl", $this->table . ".adviser_id = advisers_tbl.idusers", "left");

        if (isset($_POST["search"]["value"])) {
            $this->db->group_start();

            foreach ($this->select_column as $key => $value) {
                $this->db->or_like($value, $_POST["search"]["value"]);
            }

            $this->db->group_end();
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']] . " " . $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("date_modified DESC");
        }
    }

    //get count of all summary_tbl
    function get_all_data()
    {
        $this->db->select($this->table . "*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    //get count of filtered summary_tbl
    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getResultsById($id, $replacement, $date_from, $date_until){
        $this->db->select('
            results_id AS result_id,
            adviser_id,
            advisers_tbl.last_name AS adviser_last_name,
            advisers_tbl.first_name AS adviser_first_name,
            advisers_tbl.middle_name AS adviser_middle_name,
            providers,
            policy_type,
            policy_number,
            clients,
            replacement,
            score, 
            DATE_FORMAT(DATE(date_added), "%d/%m/%Y") AS date_added,
            answers 
            ');
        $this->db->from('results_tbl');
        $this->db->join("advisers_tbl","results_tbl.adviser_id = advisers_tbl.idusers", "left");

        if($id != '')
            $this->db->where('adviser_id', $id);
        if($replacement != '')
            $this->db->where('replacement',$replacement);

        $this->db->where('DATE(date_added) BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" AND "'. date('Y-m-d', strtotime($date_until)).'"');
        $this->db->group_by('results_id'); 

        return $this->db->get()->result_array();
    }

    public function getResultsByIds($ids, $date_from, $date_until){
        $this->db->select('
            results_id AS result_id,
            adviser_id,
            advisers_tbl.last_name AS adviser_last_name,
            advisers_tbl.first_name AS adviser_first_name,
            advisers_tbl.middle_name AS adviser_middle_name,
            providers,
            policy_type,
            policy_number,
            clients,
            replacement,
            score, 
            DATE_FORMAT(DATE(date_added), "%d/%m/%Y") AS date_added,
            answers 
            ');
        $this->db->from('results_tbl');
        $this->db->join("advisers_tbl","results_tbl.adviser_id = advisers_tbl.idusers", "left");

        if(isset($ids) && sizeof($ids) >= 1)
            $this->db->where_in('adviser_id', $ids);
        $this->db->where('DATE(date_added) BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" AND "'. date('Y-m-d', strtotime($date_until)).'"');
        $this->db->group_by('results_id'); 

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

    //insert summary
    public function savesummary($params){

        $params2 = array(
            "adviser_id" => $params['data']['info']['adviser'],
            "result_id" => $params['data']['info']['result'],
            "filename" => $params['data']['info']['filename'],
            "date_from" => $params['data']['info']['date_from'],
            "date_until" => $params['data']['info']['date_until']
        );

        $this->db->insert('summary_tbl', $params2);
        if($this->db->affected_rows() > 0) {
            $insert_id = $this->db->insert_id();
            return $insert_id;        
        }
        return false;
    }

    //update summary
    public function updatesummary($params){

        $params2 = array(
            "adviser_id" => $params['data']['info']['adviser'],
            "result_id" => $params['data']['info']['result'],
            "filename" => $params['data']['info']['filename'],
            "date_from" => $params['data']['info']['date_from'],
            "date_until" => $params['data']['info']['date_until']
        );

        $this->db->where('summary_id', $params['summary_id']);
        if ($this->db->update('summary_tbl', $params2) !== FALSE)
            return true;    
        return false;
    }

    //delete summary
    public function deleteRows($params)
    {
        $this->db->where('summary_id', $params['summary_id']);
        if ($this->db->delete($this->table, $params) !== FALSE)
            return true;
        return false;
    }

    //get summary result by id
    public function getSummaryById($id){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('summary_id', $id);
        // $this->db->where('status', 'Active');
        return $this->db->get()->row();
    }
}
?>