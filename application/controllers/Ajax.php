<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{


  /**
   * Get rombel all indentifier with session
   * 
   * 
   * @return json
   */
  public function get_rombel()
  {
    $guru = get_my_info();

    $query = $this->input->post('query',true);
    $tingkat = $this->input->post('kelas',true);

    $this->db->where('guru_id',$guru->id);
    $this->db->group_by("kelas_id");
    $data_mapel= $this->db->get('kurikulum')->result();

    foreach($data_mapel as $datamapel) {
      $rombel_id[] = $datamapel->kelas_id;
    }

    if($query == 'sikap'){
      // $data_rombel = Datarombel::find('all', array('conditions' => array('id IN (?) AND tingkat = ?', $rombel_id, $tingkat)));
    } else {
      $data_rombel = $this->db->get_where('kelas',['tingkat' => $tingkat])->result();
    }
		if($data_rombel){
			foreach($data_rombel as $rombel){
				$record= array();
				$record['value'] 	= $rombel->id;
				$record['text'] 	= $rombel->nama;
				$output['result'][] = $record;
			}
		} else {
			$record['value'] 	= '';
			$record['text'] 	= 'Tidak ditemukan rombongan belajar di kelas terpilih';
			$output['result'][] = $record;
		}
		echo json_encode($output);
  }

  /**
   * Get mapel from ajax
   * 
   * 
   * 
   * @return json
   */
  public function get_mapel()
  {
    $guru = get_my_info();
    // $loggeduser = $this->ion_auth->user()->row();
		// $waka = array('waka');
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
    $query		= $_POST['query'];
    
		//$all_siswa = filter_agama_siswa(get_nama_mapel($ajaran_id, $rombel_id);
		// $all_siswa = Datasiswa::find_all_by_data_rombel_id($rombel_id);
		// if($loggeduser->data_guru_id && !$this->ion_auth->in_group($waka)){
		// 	//$all_mapel = Kurikulum::find_all_by_rombel_id_and_guru_id($rombel_id,$loggeduser->data_guru_id);
		// 	//$all_mulok = Mulok1::find_all_by_ajaran_id_and_rombel_id_and_guru_id($ajaran_id,$rombel_id,$loggeduser->data_guru_id);
		// 	$cond = array('group' => 'id', "conditions"=> array('kurikulums.ajaran_id = ? AND kurikulums.rombel_id = ? AND kurikulums.guru_id = ?',  $ajaran_id, $rombel_id, $loggeduser->data_guru_id));
		// } else {
		// 	if($query == 'rencana_penilaian' || $query == 'kd' || $query == 'kkm' || $query == 'add_kd'){
		// 		//$all_mapel = Kurikulum::find_all_by_rombel_id_and_guru_id($rombel_id,$loggeduser->data_guru_id);
		// 		//$all_mulok = Mulok1::find_all_by_ajaran_id_and_rombel_id_and_guru_id($ajaran_id,$rombel_id,$loggeduser->data_guru_id);
		// 		//$cond =array('conditions'=> array('ajaran_id = ? AND rombel_id = ? AND guru_id = ?', $ajaran_id, $rombel_id, $loggeduser->data_guru_id));
		// 		$join = "INNER JOIN kurikulum_aliases a ON(kurikulums.id_mapel = a.id AND a.nama_kur != 'k13_mulok' OR kurikulums.id_mapel = a.id AND a.nama_kur != 'k_mulok' OR kurikulums.id_mapel != '850010100')";
		// 	$cond = array('joins'=> $join, 'group' => 'id', "conditions"=> array('kurikulums.ajaran_id = ? AND kurikulums.rombel_id = ? AND kurikulums.guru_id = ?', $ajaran_id, $rombel_id, $loggeduser->data_guru_id));
		// 	} else {
		// 		//$all_mapel = Kurikulum::find_all_by_rombel_id($rombel_id);
		// 		//$all_mulok = Mulok1::find_all_by_ajaran_id_and_rombel_id($ajaran_id,$rombel_id);
		// 		$cond =array('conditions'=> array('ajaran_id = ? AND rombel_id = ?', $ajaran_id, $rombel_id));
		// 	}
		// }
    // $all_mapel = Kurikulum::all($cond);
    
    $this->db->select('*');
    $this->db->from('kurikulum');
    $this->db->where(['ajaran_id' => $ajaran_id, 'kelas_id' => $rombel_id, 'guru_id' => $guru->id]);
    $all_mapel = $this->db->get()->result();

		if($all_mapel){
			foreach($all_mapel as $mapel){
				$record= array();
				$record['value'] 	= $mapel->id_mapel;
				$record['text'] 	= get_nama_mapel($ajaran_id, $rombel_id, $mapel->id_mapel).' ('.$mapel->id_mapel.')';
				$output['mapel'][] = $record;
			}
		} else {
			$record['value'] 	= '';
			$record['text'] 	= 'Tidak ditemukan mata pelajaran di kelas terpilih';
			$output['mapel'][] = $record;
		}

		echo json_encode($output);
  }
}