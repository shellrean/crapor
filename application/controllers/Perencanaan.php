<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perencanaan extends CI_Controller
{

  /**
   * Show perencanaan dashboard
   * 
   * 
   * @return perencanaan view
   */
  public function pengetahuan()
  {
    $guru = get_my_info();
		$ajaran = get_ta();

		// limit
		// $start = $this->custom_fuction->get_start();
		// $rows = $this->custom_fuction->get_rows();
		// $join_rombel = '';
		// $join_mapel = '';
		// $id_rombel = '';
		// $id_mapel = '';
		// if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
		// 	$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'order'=>'rombel_id ASC'));
		// 	foreach($data_mapel as $datamapel){
		// 		$get_id_rombel[$datamapel->rombel_id] = $datamapel->rombel_id;
		// 		$get_id_mapel[$datamapel->id_mapel] = $datamapel->id_mapel;
		// 	}
		// 	if(isset($get_id_rombel)){
		// 		$id_rombel = array_unique($get_id_rombel);
		// 		$id_rombel = implode(",", $id_rombel);
		// 	} else {
		// 		$id_rombel = 0;
		// 	}
		// 	if(isset($get_id_mapel)){
		// 		$id_mapel = array_unique($get_id_mapel);
		// 		$id_mapel = "'" . implode("','", $id_mapel) . "'";//implode(",", $id_mapel);
		// 	} else {
		// 		$id_mapel = 0;
		// 	}
		// $join_rombel = "AND a.id IN ($id_rombel)";
		// $join_mapel = "AND b.id_mapel IN ($id_mapel)";
		// }
		// if($jurusan && $tingkat == NULL && $rombel == NULL){
		// 	$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan $join_rombel)";
		// 	$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
		// 	$sel = 'rencanas.*, b.guru_id AS guru_id';
		// }elseif($jurusan && $tingkat && $rombel == NULL){
		// 	$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat $join_rombel)";
		// 	$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
		// 	$sel = 'rencanas.*, b.guru_id AS guru_id';
		// } elseif($jurusan && $tingkat && $rombel){
		// 	$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id AND a.kurikulum_id = $jurusan AND a.tingkat = $tingkat AND a.id = $rombel $join_rombel)";
		// 	$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel AND b.id_mapel IN ($id_mapel))";
		// 	$sel = 'rencanas.*, b.guru_id AS guru_id';
		// } else {
		// 	$join = "INNER JOIN data_rombels a ON(rencanas.rombel_id = a.id $join_rombel)";
		// 	$join .= "INNER JOIN kurikulums b ON(rencanas.id_mapel = b.id_mapel $join_mapel)";
		// 	$sel = 'rencanas.*, b.guru_id AS guru_id';
		// }
		// $query = Rencana::find('all', array('include'=>array('rencanapenilaian'), 'conditions' => "b.ajaran_id = $ajaran->id AND kompetensi_id = 1 AND (b.id_mapel LIKE '%$search%' OR b.rombel_id LIKE '%$search%')",'limit' => $rows, 'offset' => $start,'order'=>'b.id_mapel ASC, id DESC', 'joins'=> $join, 'select'=>$sel, 'group'=> 'id'));
		// $filter = Rencana::find('all', array('conditions' => "b.ajaran_id = $ajaran->id AND kompetensi_id = 1 AND (b.id_mapel LIKE '%$search%' OR b.rombel_id LIKE '%$search%')",'order'=>'b.id_mapel ASC, id DESC', 'joins'=> $join, 'group'=> 'id'));
		// $iFilteredTotal = count($query);
		
		// $iTotal=count($filter);
    // $this->db->select('kd.*,kurikulum.kelas_id as kelas_id, kurikulum.ajaran_id as ajaran_id, data_mapel.nama_mapel');
    
    $this->db->from('rencana');
   
    $this->db->join('kelas a','rencana.kelas_id = a.id','inner');
    $this->db->join('kurikulum b','rencana.id_mapel = b.id_mapel','inner');


    $this->db->where(['b.ajaran_id' => $ajaran->id ,'b.guru_id' => $guru->id,'b.ajaran_id' => $ajaran->id]);

    $data['result'] = $this->db->get()->result();

    var_dump($data['result']);
		// $output = array(
		// 	"sEcho" => intval($_GET['sEcho']),
	  //       "iTotalRecords" => $iTotal,
	  //       "iTotalDisplayRecords" => $iTotal,
	  //       "aaData" => array()
	  //   );

	  //   // get result after running query and put it in array
		// $i=$start;
	  //   foreach ($query as $temp) {
		// 	$ajaran = Ajaran::find($temp->ajaran_id);
		// 	$rencana_penilaian_group = Rencanapenilaian::find('all', array('conditions' => "rencana_id = $temp->id",'group' => 'nama_penilaian','order'=>'bentuk_penilaian ASC'));
		// 	foreach($rencana_penilaian_group as $rpg){
		// 		$rpg_id[] = $rpg->id;
		// 	}
		// 	if(isset($rpg_id)){
		// 		$rpg_id_result = implode(',',$rpg_id);
		// 	} else {
		// 		$rpg_id_result = 0;
		// 	}
		// 	$nilai = Nilai::find('all', array('conditions' => "rencana_penilaian_id IN ($rpg_id_result)", 'limit'=>1));
		// 	if(!in_array('waka',$nama_group)){ //murni guru
		// 		if($nilai){
		// 			$admin_akses = '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
		// 		} else {
		// 			$admin_akses = '<li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
		// 			$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
		// 		}
		// 	} else { // guru plus waka
		// 		$admin_akses = '<li><a href="'.site_url('admin/perencanaan/view/'.$temp->id).'" class="toggle-modal"><i class="fa fa-eye"></i> Detil</a></li>';
		// 		if(get_nama_guru($loggeduser->data_guru_id) == get_nama_guru($temp->guru_id)){
		// 			if($nilai){
		// 				$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
		// 			} else {
		// 				$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/edit/1'.$temp->id).'"><i class="fa fa-pencil"></i> Edit</a></li>';
		// 				$admin_akses .= '<li><a href="'.site_url('admin/perencanaan/delete/'.$temp->id).'" class="confirm"><i class="fa fa-power-off"></i> Hapus</a></li>';
		// 			}
		// 		}
		// 	}
		// 	$jumlah_rencana_penilaian = count($temp->rencanapenilaian);
		// 	$record = array();
    //         $tombol_aktif = '';
		// 	$record[] = '<div class="text-center"><input type="checkbox" class="satuan" value="'.$temp->id.'" /></div>';
		// 	$record[] = $ajaran->tahun;
		// 	$record[] = get_nama_rombel($temp->rombel_id);
		// 	$record[] = get_nama_mapel($temp->ajaran_id, $temp->rombel_id, $temp->id_mapel);
    //         $record[] = get_nama_guru($temp->guru_id);
    //         $record[] = '<div class="text-center">'.count($rencana_penilaian_group).'</div>';
    //         $record[] = '<div class="text-center">'.$jumlah_rencana_penilaian.'</div>';
		// 	//$record[] = '<div class="text-center">'.$admin_akses.'</div>';
    //         //$record[] = '<a class="tooltip-left" title="'.$get_kd->kompetensi_dasar.'">'.$temp->kd.'</a>';
		// 	$record[] = '<div class="text-center"><div class="btn-group">
		// 					<button type="button" class="btn btn-default btn-sm">Aksi</button>
    //                         <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
		// 						<span class="caret"></span>
		// 						<span class="sr-only">Toggle Dropdown</span>
    //                         </button>
    //                         <ul class="dropdown-menu pull-right text-left" role="menu">
    //                             <!--li><a href="javascript:void(0)" class="toggle-modal"><i class="fa fa-eye"></i>Detil</a></li-->
		// 						 <!--li><a href="'.site_url('admin/perencanaan/edit/1/'.$temp->id).'"><i class="fa fa-pencil"></i>Edit</a></li-->
		// 						 '.$admin_akses.'
    //                         </ul>
    //                     </div></div>';
		// 	$output['aaData'][] = $record;
		// }
		// if($jurusan && $tingkat){
		// 	if($loggeduser->data_guru_id && !in_array('waka',$nama_group)){
		// 		$get_all_rombel = Datarombel::find('all', array('conditions' => "id IN ($id_rombel) AND kurikulum_id = $jurusan AND tingkat = $tingkat"));
		// 	} else {
		// 		$get_all_rombel = Datarombel::find_all_by_kurikulum_id_and_tingkat($jurusan,$tingkat);
		// 	}
		// 	foreach($get_all_rombel as $allrombel){
		// 		$all_rombel= array();
		// 		$all_rombel['value'] = $allrombel->id;
		// 		$all_rombel['text'] = $allrombel->nama;
		// 		$output['rombel'][] = $all_rombel;
		// 	}
		// }
		// // format it to JSON, this output will be displayed in datatable
    // echo json_encode($output);
    
    $this->template->load('template','perencanaan/pengetahuan');
  }

  /**
   * Show create page perencanaan pengetahuan
   * 
   * 
   * 
   * @return true arg
   */
  public function add_pengetahuan()
  {
    $guru = get_my_info();
    
    $data['ajarans'] = $this->db->get('ajaran')->result();
    
    $loggeduser = $this->ion_auth->user()->row();
    
    
    if($loggeduser->data_guru_id){
			$data_mapel = Kurikulum::find('all', array('conditions' => "guru_id = $loggeduser->data_guru_id", 'group' => 'rombel_id','order'=>'rombel_id ASC'));
      
      $data_mapel = $this->db->get_where('kurilulum',['guru_id' => $guru->id])->result();

      foreach($data_mapel as $datamapel){
				$rombel_id[] = $datamapel->rombel_id;
			}
			if(isset($rombel_id)){
				$id_rombel = $rombel_id;
			} else {
				$id_rombel = array();
			}
			$data['rombels'] = Datarombel::find('all', array('conditions' => array('id IN (?)', $id_rombel)));
		} else {
			$data['rombels'] = Datarombel::all();
    }
    

		$data['kelas'] = Datarombel::find('all', array('group' => 'tingkat','order'=>'tingkat ASC'));
		$this->template->title('Administrator Panel')
		->set_layout($this->admin_tpl)
		->set('form_action', 'admin/perencanaan/simpan_perencanaan')
		->set('page_title', 'Perencanaan Penilaian Pengetahuan')
		->set('query', 'kd')
		->set('kompetensi_id', 1)
		->build($this->admin_folder.'/perencanaan/add_perencanaan',$data);
  }
}