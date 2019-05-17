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
		
		$ajaran_id = $_POST['ajaran_id'];
		$rombel_id = $_POST['rombel_id'];
    $query		= $_POST['query'];
    
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