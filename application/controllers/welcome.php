<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$GLOBALS['password'] = '';
$GLOBALS['city'] = '';
class Welcome extends CI_Controller {
	
	private $CI;
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper(array('form', 'url'));
		$this->load->library("pagination");
		$this->load->library('encrypt');
		$this->load->library('form_validation');
		$this->hooks =& load_class('Hooks', 'core');
		$this->CI =& get_instance();
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		$this->load->view('navigation.php');
	}
	public function form(){
		// $obj = json_decode(file_get_contents('php://input'));
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('role');
		$this->session->unset_userdata('city');
		$this->load->database();
		$this->load->helper('email');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|regex_match[/^[a-zA-Z\s]{2,20}$/]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/]');
        $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.Email]');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$data['userid']=0;
		$data['role']=0;
		if ($this->form_validation->run() == FALSE){
			$form_error = array('name' => form_error('name'),
            'password' => form_error('password'),
            'cpassword' => form_error('cpassword'),
            'email' => form_error('email'),
            'city' => form_error('city'));
			$data['err']=$form_error;
			echo json_encode($data);
			// $this->load->view('signup.php',$data);
		}else{
			$user=array(
				'name' => $this->input->post('name'),
				'Email' => $this->input->post('email'),
				'password' =>$this->encrypt->sha1($this->input->post('password')),
                 'role'=>0,
				 'city'=>$this->input->post('city')
			);
			$this->load->model('Data');
			$result=$this->Data->registerData($user);
			$sess_array = array(
				'id'    => $result,
				'city'  => $this->input->post('city')
 			);
			$this->session->set_userdata($sess_array);
			$GLOBALS['password']=$result;
			$GLOBALS['city']=$this->input->post('city');
		 	$this->hooks =& load_class('Hooks', 'core');
		 	$this->hooks->_call_hook('myhook');
			
			echo json_encode($data);
			//$this->db->affected_rows()
			//redirect('/welcome/signin', 'refresh');
		
	  }
	}
	public function authenticateuser(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		$this->load->database();
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/]');
		if ($this->form_validation->run() == FALSE){
			$data['err']=validation_errors();
            echo json_encode($data);
		}else{
		$user=array(
			'Email' => $this->input->post('email'),
			'password'=> $this->encrypt->sha1($this->input->post('password'))
		);
		
		$this->load->model('Data');
		$result['id']=$this->Data->authenticate($user);
		if($result['id']!=null){
			$sess_array = array(
				'id'    =>  $result['id'][0]['id'],
				'role'    =>  $result['id'][0]['role']
			);
			
	        $this->session->set_userdata($sess_array);
			$data['userid']=$this->session->userdata('id');
			$data['role']=$this->session->userdata('role');
			
            echo json_encode($data);
		 }else{
			$data['userid']=0;
			$data['role']=0;
			$data['error']="Invalid Username and Password";
			echo json_encode($data);
		 }
		}
	
	}
	public function upload(){
		$file=$_FILES['file']['name'];
		$filename='';
		if(!empty($file)){
			$location='./uploads/'.$this->session->userdata('id');
			if(!is_dir($location)){
				mkdir($location, 0755);
			  }
			
			$config['upload_path'] = $location."/";
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '20480000';
			$config['max_width']  = '2048';
			$config['max_height']  = '2048';
			$config['remove_spaces']=TRUE;
			$this->load->library('upload');
			$this->upload->initialize($config);
			if(file_exists($location."/".$file)){
				$data['filename']=$location."/".$file;
				echo json_encode($data);
			}elseif (! $this->upload->do_upload('file')) {
				$data['err']=$this->upload->display_errors();
				 echo json_encode($data);
			}else{
			$filea = array('upload_data' => $this->upload->data());
			$filename=$config['upload_path'].$filea['upload_data']['file_name'];
			$data['filename']=$filename;
			echo json_encode($data);
		  }
		}		
	}
	public function ticketValidation(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		$data['err']='';
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('department', 'Department', 'trim|required');
        $this->form_validation->set_rules('category', 'Priority', 'trim|required');
        $this->form_validation->set_rules('description', 'Discription', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$data['err']=validation_errors();
			echo json_encode($data);
		}else{
			$ticket=array(
				'userid'=>$this->session->userdata('id'),
				'subject' => $this->input->post('subject'),
				'department' => $this->input->post('department'),
				'category' =>$this->input->post('category'),
				'description' => $this->input->post('description'),
                 'file' =>$this->input->post('filename'),
				 'status' => 0
			);
			$this->load->model('Data');
			$result=$this->Data->registerTicket($ticket);
			echo json_encode($result);
		}
    }
        public function useraunthitencate(){
	      $data['userid']=$this->session->userdata('id');
		  $data['role']=$this->session->userdata('role');
			if($data['role']==1){	
			$this->load->model('Data');
            $config=array();
			$config["base_url"] = 'admin';
			$config["total_rows"] = $this->Data->get_count();
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;
			 $this->pagination->initialize($config);
			 $page = $this->input->get('page') ? $this->input->get('page') : 0;
			 
             $data["links"] = $this->pagination->create_links();
             $data['tickets'] = $this->Data->getTicket($config["per_page"], $page);		
	         echo json_encode($data);
		  }else{
			$this->load->model('Data');
            $config=array();
			$config["base_url"] = 'users';
			$config["total_rows"] = $this->Data->get_usercount($data['userid']);
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;
            $this->pagination->initialize($config);
			 $page = $this->input->get('page') ? $this->input->get('page') : 0;
			 
             $data["links"] = $this->pagination->create_links();
             $data['tickets'] = $this->Data->getUserTicket($data['userid'],$config["per_page"], $page);		
	         echo json_encode($data);
		}
    }
	public function userprofile(){
		  $data['userid']=$this->session->userdata('id');
		  $data['role']=$this->session->userdata('role');
		$this->load->model('Data');
            $config=array();
			$config["base_url"] = "userprofiles/".$this->input->get('userid');
			$config["total_rows"] = $this->Data->get_usercount($this->input->get('userid'));
			$config["per_page"] = 10;
			$config["uri_segment"] = 4;
			 $this->pagination->initialize($config);
			 $page = $this->input->get('page') ? $this->input->get('page') : 0;
             $data["links"] = $this->pagination->create_links();
             $data['tickets'] = $this->Data->getUserTicket($this->input->get('userid'),$config["per_page"], $page);		
	        echo json_encode($data);
	}
	public function emailaunthitencate(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		$data['err']='';
		$this->load->database();
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == FALSE){
			echo json_encode($data);
		}else{
		$user=array(
			'Email' => $this->input->post('email'),
		);
		$this->load->model('Data');
		$result=$this->Data->authenticatemail($user);
		if($result!=null){
			$sess_array = array(
				'id'    =>  $result[0]['id'],
			);	
	    $this->session->set_userdata($sess_array);
		$data['userid']=$this->session->userdata('id');
		$this->load->library('email');	
		// $config['mailpath'] = '/usr/sbin/sendmail';
		$config = array();
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.gmail.com';
		$config['smtp_user'] = $GLOBALS['email'];
		$config['smtp_pass'] = $GLOBALS['emailpassword'];
		$config['smtp_port'] = 587;
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['_smtp_auth']=true;
		$config['smtp_timeout']=30;
		 $config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = FALSE;
		$config['smtp_crypto']      = 'tls';
        $this->email->initialize($config);
		
		$this->email->set_newline("\r\n");
		$this->email->from('ticketsyste20@gmail.com', 'Pintu Singh');
		$this->email->to($this->input->post('email'));
		// $this->email->cc('');
		// $this->email->bcc('');
		
        $link= "<a href="."http://localhost/ticketmanagementsystem/resetpassword/".$this->encrypt->sha1($this->session->userdata('id')).">Change Password</a>";
		$this->email->subject('Password reset');
		$this->email->message($link);
		 $this->email->send();
		 $password=array(
			'userid'=>$this->session->userdata('id'),
			'password'=>$this->encrypt->sha1($this->session->userdata('id'))
		);
		
		 $this->load->model('Data');
		$result=$this->Data->addpassword($password);
		if(!$result){
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('role');
		      echo json_encode($data);
		}else{
			$data['err']="Email is already sent";
			echo json_encode($data);
		}
		// echo $this->email->print_debugger();		
	}else{
		$data['err']="Email not found";
		echo json_encode($data);
	}
    }
}
	public function resetpassword(){
		$sess_array = array(
				'id'    =>  $this->uri->segment(3)
		);
		$this->load->model('Data');
		$result=$this->Data->validateuser($sess_array);
		echo json_encode($result);
	}
	public function password(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		print_r($_POST);
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/]');
        $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE){
			$form_error = array(
            'password' => form_error('password'),
            'cpassword' => form_error('cpassword')
            );
			$data['err']=$form_error;
			$data['id']=$this->encrypt->sha1($this->session->userdata('id'));
			echo json_encode($data);
		}else{
			$password=array(
				'userid'=>$this->input->post('id'),
				'password' => $this->encrypt->sha1($this->input->post('password')),
			);
           
			$this->load->model('Data');
			$data['result']=$this->Data->passwordupdate($password);
	        echo json_encode($data);
		}
	}
	public function session(){
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		echo json_encode($data);
	}
	public function logout(){
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('role');
		$this->session->unset_userdata('city');
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		echo json_encode($data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
