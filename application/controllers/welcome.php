<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper(array('form', 'url'));
		$this->load->library("pagination");
		$this->load->library('encrypt');
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
		$this->load->view('home.php',$data);
	}
	public function signup(){
		$data['role']=0;
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('role');
		$data['userid']=0;
		$this->load->helper(array('form', 'url'));
		$this->load->view('signup.php',$data);
	}
	public function form(){
		$this->load->database();
		$this->load->helper('email');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|regex_match[/^[a-zA-Z\s]{2,20}$/]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/]');
        $this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.Email]');
		$data['userid']=0;
		$data['role']=0;
		if ($this->form_validation->run() == FALSE){
			$this->load->view('signup.php',$data);
		}else{
			$user=array(
				'name' => $this->input->post('name'),
				'Email' => $this->input->post('email'),
				'password' =>$this->encrypt->sha1($this->input->post('password')),
                 'role'=>0

			);
			$this->load->model('Data');
			$this->Data->registerData($user);
			//$this->db->affected_rows()
			$this->load->view('signin.php',$data);
		}
	  }
	public function signin(){
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('role');
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		$data['err']='';
		$this->load->view('signin.php',$data);
	}
	public function adminlogin(){
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		$this->load->view('adminlogin.php',$data);
	}
	public function authenticateuser(){
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		$this->load->database();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/]');
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
			$this->load->view('home.php',$data);
		 }else{
			$data['err']="Invalid Username and Password";
			$this->load->view('signin.php',$data);
		 }
	
	}
	public function ticket(){
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		if($data['userid']==0){
			redirect('/welcome/signin', 'refresh');
		}else{
			$this->load->view('ticket.php',$data);
		}
	}
	public function ticketValidation(){
		$data['userid']=$this->session->userdata('id');
		$data['role']=$this->session->userdata('role');
		$data['err']='';
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('department', 'Department', 'trim|required');
        $this->form_validation->set_rules('category', 'Priority', 'trim|required');
        $this->form_validation->set_rules('description', 'Discription', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('signup.php',$data);
		}else{
			$file=$_FILES['file']['name'];
			$flag=true;
			$filename='';
			if(empty($file)){
                $flag=true;
			}else{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '20480000';
				$config['max_width']  = '2048';
				$config['max_height']  = '2048';
				$config['remove_spaces']=TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
                   
		         if ( file_exists('uploads/'.$file)||! $this->upload->do_upload('file')) {
					print_r($this->upload->display_errors());
			         $flag=false;
		        }else{
			    $filea = array('upload_data' => $this->upload->data());
				$filename=$config['upload_path'].$filea['upload_data']['file_name'];
			  }
			}
		  if($flag){
			$ticket=array(
				'userid'=>$this->session->userdata('id'),
				'subject' => $this->input->post('subject'),
				'department' => $this->input->post('department'),
				'category' =>$this->input->post('category'),
				'description' => $this->input->post('description'),
                 'file' =>$filename,
				 'status' => 0
			);
			 $this->load->model('Data');
			$result=$this->Data->registerTicket($ticket);
			redirect('/welcome/user', 'refresh');
		}else{
			$data['err']="Please attach valid file";
			$this->load->view('ticket.php',$data);
		}
	}
}
        public function user(){
	      $data['userid']=$this->session->userdata('id');
		  $data['role']=$this->session->userdata('role');
		  
		  if($data['userid']==0){
			redirect('/welcome/signin', 'refresh');
		  }else{
			
			if($data['role']==1){
				
			$this->load->model('Data');
            $config=array();
			$config["base_url"] = site_url('welcome/user');
			$config["total_rows"] = $this->Data->get_count();
			$config["per_page"] = 10;
			$config["uri_segment"] = 5;
			 $this->pagination->initialize($config);
			 $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			 
             $data["links"] = $this->pagination->create_links();
             $data['tickets'] = $this->Data->getTicket($config["per_page"], $page);		
	         $this->load->view('admin.php',$data);
		  }else{
			$this->load->model('Data');
            $config=array();
			$config["base_url"] = site_url('welcome/user');
			$config["total_rows"] = $this->Data->get_usercount($data['userid']);
			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			 $this->pagination->initialize($config);
			 $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			 
             $data["links"] = $this->pagination->create_links();
             $data['tickets'] = $this->Data->getUserTicket($data['userid'],$config["per_page"], $page);		
	         $this->load->view('user.php',$data);
		  }
		}
    }
	public function userprofile(){
		  $data['userid']=$this->session->userdata('id');
		  $data['role']=$this->session->userdata('role');
		$this->load->model('Data');
            $config=array();
			$config["base_url"] = site_url('welcome/userprofile/'.$this->uri->segment(3));
			$config["total_rows"] = $this->Data->get_usercount($this->uri->segment(3));
			$config["per_page"] = 10;
			$config["uri_segment"] = 2;
			 $this->pagination->initialize($config);
			 $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
             $data["userlinks"] = $this->pagination->create_links();
             $data['tickets'] = $this->Data->getUserTicket($this->uri->segment(3),$config["per_page"], $page);		
	         $this->load->view('ticketview.php',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */