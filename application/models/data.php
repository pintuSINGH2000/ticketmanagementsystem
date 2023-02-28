<?php
define('users', 'users');
define('ticket', 'ticket');
define('description', 'discription');
class Data extends CI_Model{
    public function __construct(){
        $this->load->database();
    }
    function getUserData(){
        $query=$this->db->query("select * from users");
        $q=$query->result_array();
        return $q;
    }
    function registerData($data){
        $query=$this->db->insert(users,$data);
        return $query;
    }
    function authenticate($data){
        
        $sql="select id,role from users where email=? && password= ? ";
        $query=$this->db->query($sql, array($data['Email'], $data['password']));
        return $query->result_array();
    }
    function registerTicket($data){
        $query=$this->db->insert(ticket,$data);
        return $query;
    }
    function getTicket($limit,$start){
        $this->db->limit($limit, $start);
        $query = $this->db->get(ticket);

        return $query->result_array();
    }
    public function get_count() {
        return $this->db->count_all(ticket);
    }
    public function get_usercount($data) {
        $sql='SELECT id FROM ticket where userid=? ';
        $query = $this->db->query($sql,$data);
        return $query->num_rows();
    }
    function getUserTicket($id,$limit,$start){
        $this->db->limit($limit, $start);
        $query = $this->db->get_where(ticket, array('userid' => $id), $limit, $start);
        
        return $query->result_array();
    }
    
}
?>