<?php
class SummaryCollection extends CI_Model {
    var $select_column = null;
    var $select_column_v2 = null;
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $columns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $this->select_column[] = $this->table . '.' . $value;
        }

        $columns_v2 = $this->getColumns_v2();
        foreach ($columns_v2 as $key => $value) {
            $this->select_column_v2[] = $this->table . '.' . $value;
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

    //////////////////////////////////
    var $order_column_v2 = array();

    //set searchable parameters in summary_tbl table
    public function getColumns_v2()
    {
        $rows = array();
        return $rows;
    }   

    //set limit in datatable
    function make_datatables_v2()
    {
        $this->make_query_v2();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    //fetch list of summary_tbl
    function make_query_v2()
    {      
        $c_db = $_ENV['db_database'];
        $ap_db = $_ENV['ap_database'];

        $info = isset($_POST['info']) ? $_POST['info'] : '';
        $adviser = array();
        $replacement = '';
        $policyType = array();
        $providers = array();
        $date_from = '';
        $date_until = '';

        if($info != '') {
            $adviser = $info['adviser'];
            $replacement = $info['replacement'];
            $policyType = $info['policyType'];
            $providers = $info['providers'];
            $date_from = $info['date_from = $'];
            $date_until = $info['date_until']; 
        }

        $this->select_column_v2[] = $ap_db.'.users.last_name';
        $this->select_column_v2[] = $ap_db.'.users.first_name';
        $this->select_column_v2[] = $ap_db.'.users.middle_name';
        $this->db->select(
            $c_db.'.results_tbl.results_id AS result_id,'.
            $c_db.'.results_tbl.adviser_id,'.
            $ap_db.'.users.last_name AS adviser_last_name,'.
            $ap_db.'.users.first_name AS adviser_first_name,'.
            $ap_db.'.users.middle_name AS adviser_middle_name,'.
            $c_db.'.results_tbl.providers,'.
            $c_db.'.results_tbl.policy_type,'.
            $c_db.'.results_tbl.policy_number,'.
            $c_db.'.results_tbl.clients,'.
            $c_db.'.results_tbl.replacement,'.
            $c_db.'.results_tbl.score,'. 
            $c_db.'.results_tbl.token,'. 
            $c_db.'.results_tbl.score_status,'. 
            'DATE_FORMAT(DATE('.$c_db.'.results_tbl.date_added), "%d/%m/%Y") AS date_added,'.
            $c_db.'.results_tbl.answers'
        );
        $this->db->from($c_db.'.results_tbl');
        $this->db->join($ap_db.".users","results_tbl.adviser_id = ".$ap_db.".users.idusers", "left");

        if (isset($_POST["search"]["value"])) {
            $this->db->group_start();

            foreach ($this->select_column_v2 as $key => $value) {
                $this->db->or_like($value, $_POST["search"]["value"]);
            }

            $this->db->group_end();
        }

        if(isset($_POST['info']['replacement']) && $_POST['info']['replacement'] != null && $_POST['info']['replacement'] != '') {
            if($_POST['info']['replacement'] == "N/A") {
                $this->db->group_start();
                $this->db->or_where($c_db.'.results_tbl.replacement = "'.$_POST['info']['replacement'].'"');
                $this->db->or_where($c_db.'.results_tbl.replacement = ""');
                $this->db->group_end();
            } else $this->db->where($c_db.'.results_tbl.replacement = "'.$_POST['info']['replacement'].'"');
        }
        if(isset($_POST['info']['date_from']) && $_POST['info']['date_from'] != null) {
            if(isset($_POST['info']['date_until']) && $_POST['info']['date_until'] != null) 
                $this->db->where('DATE('.$c_db.'.results_tbl.date_added) BETWEEN "'.$_POST['info']['date_from'].'" AND "'.$_POST['info']['date_until'].'"');
        }

        if(isset($_POST['info']['policyType']) && sizeof($_POST['info']['policyType']) >= 1) {
            foreach ($_POST['info']['policyType'] as $k => $v) {
                $this->db->group_start();
                $this->db->or_where($c_db.'.results_tbl.policy_type LIKE "%,'.$v.'"');
                $this->db->or_where($c_db.'.results_tbl.policy_type LIKE "%,'.$v.',%"');
                $this->db->or_where($c_db.'.results_tbl.policy_type LIKE "'.$v.',%"');
                $this->db->group_end();
            } 
        }

        if(isset($_POST['info']['providers']) && sizeof($_POST['info']['providers']) >= 1) {
            foreach ($_POST['info']['providers'] as $k => $v) {
                $this->db->group_start();
                $this->db->or_where($c_db.'.results_tbl.providers LIKE "%,'.$v.'"');
                $this->db->or_where($c_db.'.results_tbl.providers LIKE "%,'.$v.',%"');
                $this->db->or_where($c_db.'.results_tbl.providers LIKE "'.$v.',%"');
                $this->db->group_end();
            } 
        }

        if(isset($_POST['info']['adviser']) && sizeof($_POST['info']['adviser']) >= 1) {
            if(is_array($_POST['info']['adviser']) && $_POST['info']['adviser'][0] != '') {
                $array = implode(', ', $_POST['info']['adviser']);
                $this->db->where($c_db.'.results_tbl.adviser_id IN ('.$array.')');
            } elseif($_POST['info']['adviser'][0] != '') 
                $this->db->where($c_db.'.results_tbl.adviser_id = "'.$_POST['info']['adviser'].'"');
                
        }
        
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column_v2[$_POST['order']['0']['column']] . " " . $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by($c_db.".results_tbl.date_modified DESC");
        }
    }

    //get count of all summary_tbl
    function get_all_data_v2()
    {
        $this->db->select("results_tbl.*");
        $this->db->from("results_tbl");
        return $this->db->count_all_results();
    }

    //get count of filtered summary_tbl
    function get_filtered_data_v2()
    {
        $this->make_query_v2();
        $query = $this->db->get();
        return $query->num_rows();
    }
    //////////////////////////////////
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
            $this->db->where_in('results_id', $ids);
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

    public function getFilteredSummary() {
        $c_db = $_ENV['db_database'];
        $ap_db = $_ENV['ap_database'];

        $info = isset($_POST['info']) ? $_POST['info'] : '';
        $adviser = array();
        $replacement = '';
        $policyType = array();
        $providers = array();
        $date_from = '';
        $date_until = '';

        if($info != '') {
            $adviser = $info['adviser'];
            $replacement = $info['replacement'];
            $policyType = $info['policyType'];
            $providers = $info['providers'];
            $date_from = $info['date_from = $'];
            $date_until = $info['date_until']; 
        }

        $this->db->select(
            $c_db.'.results_tbl.results_id AS result_id,'.
            $c_db.'.results_tbl.adviser_id,'.
            $ap_db.'.users.last_name AS adviser_last_name,'.
            $ap_db.'.users.first_name AS adviser_first_name,'.
            $ap_db.'.users.middle_name AS adviser_middle_name,'.
            $c_db.'.results_tbl.providers,'.
            $c_db.'.results_tbl.policy_type,'.
            $c_db.'.results_tbl.policy_number,'.
            $c_db.'.results_tbl.clients,'.
            $c_db.'.results_tbl.replacement,'.
            $c_db.'.results_tbl.score,'. 
            $c_db.'.results_tbl.token,'. 
            'DATE_FORMAT(DATE('.$c_db.'.results_tbl.date_added), "%d/%m/%Y") AS date_added,'.
            $c_db.'.results_tbl.answers'
        );
        $this->db->from($c_db.'.results_tbl');
        $this->db->join($ap_db.".users","results_tbl.adviser_id = ".$ap_db.".users.idusers", "left");

        if(isset($_POST['info']['replacement']) && $_POST['info']['replacement'] != null && $_POST['info']['replacement'] != '') {
            if($_POST['info']['replacement'] == "N/A") {
                $this->db->group_start();
                $this->db->or_where($c_db.'.results_tbl.replacement = "'.$_POST['info']['replacement'].'"');
                $this->db->or_where($c_db.'.results_tbl.replacement = ""');
                $this->db->group_end();
            } else $this->db->where($c_db.'.results_tbl.replacement = "'.$_POST['info']['replacement'].'"');
        }
        if(isset($_POST['info']['date_from']) && $_POST['info']['date_from'] != null) {
            if(isset($_POST['info']['date_until']) && $_POST['info']['date_until'] != null) 
                $this->db->where('DATE('.$c_db.'.results_tbl.date_added) BETWEEN "'.$_POST['info']['date_from'].'" AND "'.$_POST['info']['date_until'].'"');
        }

        if(isset($_POST['info']['policyType']) && sizeof($_POST['info']['policyType']) >= 1) {
            foreach ($_POST['info']['policyType'] as $k => $v) {
                $this->db->group_start();
                $this->db->or_where($c_db.'.results_tbl.policy_type LIKE "%,'.$v.'"');
                $this->db->or_where($c_db.'.results_tbl.policy_type LIKE "%,'.$v.',%"');
                $this->db->or_where($c_db.'.results_tbl.policy_type LIKE "'.$v.',%"');
                $this->db->group_end();
            } 
        }

        if(isset($_POST['info']['providers']) && sizeof($_POST['info']['providers']) >= 1) {
            foreach ($_POST['info']['providers'] as $k => $v) {
                $this->db->group_start();
                $this->db->or_where($c_db.'.results_tbl.providers LIKE "%,'.$v.'"');
                $this->db->or_where($c_db.'.results_tbl.providers LIKE "%,'.$v.',%"');
                $this->db->or_where($c_db.'.results_tbl.providers LIKE "'.$v.',%"');
                $this->db->group_end();
            } 
        }

        if(isset($_POST['info']['adviser']) && sizeof($_POST['info']['adviser']) >= 1) {
            if(is_array($_POST['info']['adviser']) && $_POST['info']['adviser'][0] != '') {
                $array = implode(', ', $_POST['info']['adviser']);
                $this->db->where($c_db.'.results_tbl.adviser_id IN ('.$array.')');
            } elseif($_POST['info']['adviser'][0] != '') 
                $this->db->where($c_db.'.results_tbl.adviser_id = "'.$_POST['info']['adviser'].'"');
                
        }
        

        $this->db->order_by($c_db.".results_tbl.date_modified DESC");   

        $query = $this->db->get();
        return $query->result();
    }
}
?>