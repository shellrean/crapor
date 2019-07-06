<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
  private $filename = 'user_import';
  
  /**
   * Make Construct method for load parent 
   * and call library can will use
   * 
   * @return view 
   */
  public function __construct()
  {
    parent::__construct();

    $this->_cekLogin();

    $this->load->library('excel');
    $this->load->library('form_validation');
    $this->load->model('M_user');
  } 

  /**
   * Show our dashboard 
   * 
   * @return view
   */
  public function index()
  {
    $this->_isadmin();
    $data['users'] = $this->db->get_where('user',['role_id' => 2])->result();
    $this->template->load('template', 'user/index', $data);
  }
  
  
  /**
   * Show Activity user
   */
  public function activity($slug)
  {
    if($slug != $this->session->userdata('slug')) {
      redirect('errors/denied');
    }
    $query = $this->db->order_by('time', 'DESC');
    $query->where('user',$this->session->userdata('username'));
    $query->limit(50);
    $data['activity'] = $this->db->get('log')->result();
    $this->template->load('template','user/activity',$data);
  }
  /**
   * Get data from url and destroy some data
   * 
   * @return boolean
   */
  public function delete($id) 
  {
    $user = $this->db->get_where('user',['id' => $id])->row();

    if($user->username == $this->session->userdata('username')) {
      alerterror('message','Tidak bisa menghapus diri sendiri');
      redirect('user');
    }
    $this->_isadmin();
    $this->db->delete('user', ['id' => $id]);

    helper_log(uniqid(),'Menghapus user');

    $data['title'] = 'Sukses';
    $data['text'] = 'Data berhasil dihapus';
    $data['type'] = 'success';
    
    echo json_encode($data);
  }

  /**
   * Create and strore some data to database
   * 
   * @return view database
   */
  public function create()
  {
    $this->_isadmin();
    $this->form_validation->set_rules('username','Username','trim|required|is_unique[user.username]');
    $this->form_validation->set_rules('name','Name','required');
    $this->form_validation->set_rules('password1','Password','trim|required|matches[password2]|min_length[3]');
    $this->form_validation->set_rules('password2','Password confirm','trim|required|matches[password1]');
    $this->form_validation->set_rules('nip','Nip','required|trim');

    if($this->form_validation->run() == false) {
      $this->template->load('template','user/create');
    } else {
      $data = [
        'username'  => $this->input->post('username'),
        'name'      => $this->input->post('name'),
        'nip'       => $this->input->post('nip'),
        'password'  => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
        'role_id'   => 2,
        'is_active' => 1,
        'slug'      => uniqid().generateRandomString(20),
      ];
      $this->db->insert('user',$data);
      helper_log("add", "Menambahkan data user");
      alertsuccess('message','Data berhasil ditambahkan');
      redirect('user');
    }
  }

  /**
   * Change data in database with newes updated 
   * get id from url 
   * 
   * @return boolean
   */
  public function edit($id)
  {
    $this->_isadmin();
    $this->form_validation->set_rules('username','Username','trim|required');
    $this->form_validation->set_rules('name','Name','required');
    $this->form_validation->set_rules('nip','Nip','required|trim');
    
    if($this->form_validation->run() == false){
      $data['users'] = $this->db->get_where('user',['id'=>$id])->row();
      $this->template->load('template','user/edit',$data);
    } else {
      $data = [
        'username'  => $this->input->post('username'),
        'name'      => $this->input->post('name'),
        'nip'       => $this->input->post('nip'),
        'is_active' => $this->input->post('is_active'),
      ];
      $this->db->where('id',$id);
      $this->db->update('user',$data);
      helper_log("edit", "Mengubah data user");
      alertsuccess('message','Data berhasil diubah');
      redirect('user');
    }
  }

  /**
   * Handle a request from user upload
   * 
   * @return view
   */
  public function upload()
  {
    $this->_isadmin();
    $this->template->load('template','user/upload');
  }

  /**
   * Get file from excel
   */
  public function form(){
		$data = array(); 
              
		$upload = $this->M_user->upload_file($this->filename);
			
			if($upload['result'] == "success"){
				
				include APPPATH.'third_party/PHPExcel.php';

				$excelreader = new PHPExcel_Reader_Excel2007();

				$loadexcel = $excelreader->load('uploads/'.$this->filename.'.xlsx'); 
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        
        $data['sheet'] = $sheet; 
			}else{ 
				$data['upload_error'] = $upload['error']; 
			}
		
    $this->template->load('template', 'user/preview', $data);
  }

  /**
   * Import from excel execute
   * 
   * 
   * @return boolean
   */
  public function import()
  {
    $this->_isadmin();
    /* Load plugin PHPExcel */
    include APPPATH.'third_party/PHPExcel.php';
    
    $excelreader = new PHPExcel_Reader_Excel2007();
    $loadexcel = $excelreader->load('uploads/'.$this->filename.'.xlsx'); 
    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
     
    $data = array();
    
    $numrow = 1;
    foreach($sheet as $row){

    /* ----------------------------------------------
     * Cek $numrow apakah lebih dari 1
     * Artinya karena baris pertama adalah nama-nama kolom
     * Jadi dilewat saja, tidak usah diimport
     * ----------------------------------------------
     */

    if($numrow > 1){

        array_push($data, array(
        'username'            =>$row['A'],
        'name'                =>$row['B'],
        'nip'                 =>$row['C'],
        'password'            =>password_hash($row['D'],PASSWORD_DEFAULT),
        'role_id'             =>2,
        'is_active'           =>1,
        'slug'                =>uniqid().generateRandomString(20),
        ));
    }
    
    $numrow++;
    }

    $this->db->insert_batch('user', $data);
    helper_log("upload", "Mengupload data user");
    alertsuccess('message','Data berhasil diimport');
     
  }
  public function import2()
  {
    $jumlah_guru = $this->db->get_where('user')->num_rows();
    
    $status=array(); 
    
		$importdata = $_REQUEST['data'];
		$date   = new DateTime;
    
    $fileName = $_FILES['import']['name'];
		$config['upload_path'] = './uploads/files/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'xls|xlsx';
		$config['overwrite'] = TRUE; 
    $this->load->library('upload');
    
    $this->upload->initialize($config);
		if(!$this->upload->do_upload('import')){
			$status['type'] = 'error';
			$status['text'] = $this->upload->display_errors();
			$status['title'] = 'Upload file error!';
			echo json_encode($status);
			exit();
    }
    
		$inputFileName = './uploads/files/'.$fileName;
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle = $worksheet->getTitle();
			$highestRow = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    }
    
		$nrColumns = ord($highestColumn) - 64;
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$status['highestColumn'] = $highestColumn;
		$status['highestRow'] = $highestRow;
		$status['sheet'] = $sheet;
    $status['nrColumns'] = $nrColumns;
    
		if($highestColumn == 'C') { // Import data guru
			$row = $objPHPExcel->getActiveSheet()->getRowIterator(1)->current();
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);
			foreach ($cellIterator as $k=>$cell) {
				$key[] = $cell->getValue();
			}
			for ($row = 2; $row <= $highestRow; ++ $row) {
				$val = array();
				for ($col = 0; $col < $highestColumnIndex; ++ $col) {
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val[] = $cell->getValue();
				}
				$i=0;
				foreach($val as $k=>$v){
					$InsertData[] = array(
						"$key[$i]"=> $v
						);
					$i++;
				}
				$flat = call_user_func_array('array_merge', $InsertData);
        $slug = array("slug" => uniqid().generateRandomString(20));
				$password	= array("password"=>12345678);
				$masukkan[] = array_merge($flat,$slug,$password);
			}
			$jumlah_data_import = count($masukkan);
			$sum=0;
			$data_sudah_ada = array();
      $gagal_insert_user = array();
      
		foreach($masukkan as $k=>$v){
      $a = $this->db->get_where('user',['username' => $v['username']])->result();
      $sum+=count($a);
      
			if(!$a){
				$username 	= $v['username'];
        $password 	= $v['password'];
        $name =   $v['name'];
        $this->db->insert('user',[
          'username'  => $username,
          'name'      => $name,
          'password'   => password_hash($password,PASSWORD_DEFAULT),
        ]);
			} else {
				$data_sudah_ada[] .= 'Data sudah ada';
			}
		}
		$jml_data_sudah_ada = count($data_sudah_ada);
		$kolom = ($highestRow - 1);
		$disimpan = ($kolom - $sum);
		$ditolak = ($kolom - $jml_data_sudah_ada);
		$status['text']	= '<table width="100%" class="table table-bordered">
				<tr>
					<td class="text-center">Jumlah data</td>
					<td class="text-center">Status</td>
				</tr>
				<tr>
					<td>'.$disimpan.'</td>
					<td><span class="badge badge-success">sukses disimpan</span></td>
				<tr>
					<td>'.$jml_data_sudah_ada.'</td>
					<td><span class="badge badge-danger">data sudah ada</span></td>
				</tr>
				</table>';
      $status['type'] = 'success';
      $status['title'] = 'Import data sukses!';
    } else {
      $status['type'] = 'error';
      $status['text'] = 'Format Import tidak sesuai. Silahkan download template yang telah disediakan.';
      $status['title'] = 'Import Data Gagal!';
    }
    unlink($inputFileName);
	echo json_encode($status);
  }
  /**
   * Show profile page
   * 
   * 
   */
  public function profile()
  {
    if(! empty($_FILES['image']['name'])) {
      $this->_uploadImage();
      redirect('user/profile');
    } else {
      $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row();
      $this->template->load('template','user/profile',$data);
    }
  }
  /**
   * Change password
   * 
   * 
   */
  public function ubahpass()
  {
    $this->form_validation->set_rules('password1','Password','required|trim|matches[password2]|min_length[6]');
    $this->form_validation->set_rules('password2','Password confirm','required|trim|matches[password1]');
    
    if($this->form_validation->run() == false) {
      $data['user'] = $this->db->get_where('user',['username' => $this->session->userdata('username')])->row();
      $this->template->load('template','user/profile',$data);

    } else {
      $data = [
        'password' => password_hash($this->input->post('password1',true),PASSWORD_DEFAULT)
      ];
      $this->db->where('username',$this->session->userdata('username'));
      $this->db->update('user',$data);
      helper_log("edit", "Anda mengubah password anda");
      alertsuccess('message','Password berhasil diubah');
      redirect('user/profile');
    }
  }
  /**
   * Upload file image
   */
  private function _uploadImage()
  {
    $config['upload_path']          = './assets/img/profile/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['file_name']            = time().uniqid();
    $config['overwrite']			      = true;
    $config['max_size']             = 1024; // 1MB

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) { 
      $filename =  $this->upload->data("file_name");
    } else {
      $filename = 'default.png';
    }
    $data = [
      'image' => $filename,
    ];

    $this->db->where('username', $this->session->userdata('username'));
    $this->db->update('user', $data);
  }
  /**
   * Get nama guru from ajax request
   * 
   * 
   * 
   */
  public function guru()
  {
    $data_guru = $this->db->get_where('user',['role_id' => 2])->result();
    foreach($data_guru as $guru){
      $status = array();
      $status['id'] = $guru->id;
      $status['text'] = $guru->name;
      $output[] = $status;
    }
    echo json_encode($output);
  }
  /**
   * Check what its user have a session's name username
   * 
   * @return redirect
   */
  private function _cekLogin()
  {
    if (!$this->session->has_userdata('username')) {
      redirect('auth');
    }
  }

  /**
   * Reset password 
   * 
   * 
   */
  public function reset($id)
  {
    $newpassword = generateRandomString(5);
    $password = password_hash($newpassword,PASSWORD_DEFAULT);
    $this->db->where('id',$id);
    $this->db->update('user',['password' => $password]);

    helper_log("reset", "Mereset password user");
    alertsuccess('message','Password baru <b>'.$newpassword.'</b>');
    redirect('user/index');
  }
  /**
   * Only Admin access this page
   */
  private function _isadmin()
  {
    if( $this->session->userdata('role_id') != 1) {
      redirect('errors/denied');
    }
  }
  /**
   * Show dashboard role khusus
   */
  public function khusus()
  {
    $data['users'] = $this->db->get('role_khusus')->result();
    $this->template->load('template','user/khusus',$data);
  }

  /**
   * Create new role khusus
   */
  public function add_khusus()
  {
    $data['users'] = $this->db->get_where('user')->result();
    $this->template->load('template','user/add_khusus',$data);
  }
  /**
   * Strore khusus role
   */
  public function create_khusus()
  {
    $data = [
      'guru_id'     => $this->input->post('user_id',true),
      'role_id'     => $this->input->post('role_id',true)
    ];
    $this->db->insert('role_khusus',$data);
    helper_log(uniqid(),'Menambahkan user dengan role khusus');
    alertsuccess('message','Berhasil menambahkan user dengan role khusus');
    redirect('user/khusus');
  }
  public function delete_khusus($id)
  {
    $this->db->delete('role_khusus',['id' => $id]);
    helper_log(uniqid(),'Menghapus user di role khusus');

    $data['title'] = 'Sukses';
    $data['text'] = 'Data berhasil dihapus';
    $data['type'] = 'success';
    
    echo json_encode($data);
  }
}
 