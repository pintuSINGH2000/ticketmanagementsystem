<?php
define('users', 'users');
define('ticket', 'ticket');
define('password', 'password');
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
        $this->db->insert(users,$data);
        return $this->db->insert_id();
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
    public function getUserTicket($id,$limit,$start){
        $this->db->limit($limit, $start);
        $query = $this->db->get_where(ticket, array('userid' => $id), $limit, $start);
        
        return $query->result_array();
    }
    public function authenticatemail($data){
        $sql="select id,name from users where email=?";
        $query=$this->db->query($sql, array($data['Email']));
        return $query->result_array();
    }
    public function passwordupdate($data){
        $sql="Update users set password=? where id=?";
        $query=$this->db->query($sql,array($data['password'],$data['userid'])); 
   }
   public function addpassword($data){
    $sql="select id from password where userid=?";
    $quer=$this->db->query($sql,array($data['userid']));
    $q=$quer->result_array();
    if($q!=null){
      $sq ="SELECT TIMESTAMPDIFF(minute,time,CURRENT_TIMESTAMP) AS DateDiff FROM password where id=?;";
      $quer=$this->db->query($sq,array($q[0]['id']));
      $result=$quer->result_array();
      if($result[0]['DateDiff']<30){
        return true;
      }else{
        $sql="Update password set password=?  where userid=?";
        $query=$this->db->query($sql,array($data['password'],$data['userid'])); 
        return false;
      }
    }else{
        $query=$this->db->insert(password,$data);
        return false;
    }
   }
   public function validateuser($data){
    $sql="select id,userid from password where password=?";
    $query=$this->db->query($sql,array($data['id']));
    $q=$query->result_array();
    if($q!=null){
      $sq ="SELECT TIMESTAMPDIFF(minute,time,CURRENT_TIMESTAMP) AS DateDiff FROM password where id=?;";
      $quer=$this->db->query($sq,array($q[0]['id']));
      $result=$quer->result_array();
      
      if($result[0]['DateDiff']<30){
        $this->deletepassword($q[0]['id']);
        return $q;
      }else{
        $this->deletepassword($q[0]['id']);
      }
    }
   }
   public function deletepassword($id){
    $sql="DELETE from password WHERE id=?";
    $query=$this->db->query($sql,array($id));
   }
   public function updateTime($data){
    $sql="update users set temp=? where id=?";
    $query=$this->db->query($sql,array($data['temp'],$data['userid']));
   
   }
}
?>