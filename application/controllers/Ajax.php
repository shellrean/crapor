<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends MY_Controller
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

	$qry1 = $this->db->from('kurikulum');
    $qry1->where('guru_id',$guru->id);
    $qry1->group_by("kelas_id");
    $data_mapel= $qry1->get()->result();

    foreach($data_mapel as $datamapel) {
      $rombel_id[] = $datamapel->kelas_id;
    }

		# car di role khusus apakah dia termasuk role khusus
		$qry2 = $this->db->from('role_khusus');
		$qry2->where(['guru_id' => $guru->id]);
		$datas = $qry2->get()->row();
		if($datas) {
			# jika role khusus adalah wakil kurikulum yaitu 4
			if($datas->role_id == 4) {

				$qry3 = $this->db->from('kelas');
				$qry3->where(['tingkat' => $tingkat]);
				$data_rombel = $qry3->get()->result();

			}

		} else {

			$qry4 = $this->db->from('kelas');
			$qry4->where_in('id',$rombel_id);
			$qry4->where('tingkat',$tingkat);
			$data_rombel = $qry4->get()->result();

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
		$kelas_id = $_POST['kelas_id'];
    $query		= $_POST['query'];

    $this->db->select('*');
    $this->db->from('kurikulum');
    $this->db->where(['ajaran_id' => $ajaran_id, 'kelas_id' => $kelas_id, 'guru_id' => $guru->id]);
    $all_mapel = $this->db->get()->result();

		if($all_mapel){
			foreach($all_mapel as $mapel){
				$record= array();
				$record['value'] 	= $mapel->id_mapel;
				$record['text'] 	= get_nama_mapel($ajaran_id, $kelas_id, $mapel->id_mapel).' ('.$mapel->id_mapel.')';
				$output['mapel'][] = $record;
			}
		} else {
			$record['value'] 	= '';
			$record['text'] 	= 'Tidak ditemukan mata pelajaran di kelas terpilih';
			$output['mapel'][] = $record;
		}

		echo json_encode($output);
  }

  /**
   * GEt kd
   *
   *
   * @return ajax
   */
  public function get_kd()
  {
    $guru = get_my_info();

    $data['guru_id'] 		= $guru->id;

	$data['kelas'] 			= $_POST['kelas'];
	$data['kompetensi_id'] 	= $_POST['kompetensi_id'];
	$data['ajaran_id'] 		= $_POST['ajaran_id'];
	$data['id_mapel'] 		= $_POST['id_mapel'];
    $data['id_kelas'] 		= $_POST['kelas_id'];

    $this->load->view('perencanaan/form_perencanaan',$data);
  }

  /**
   * Get rencana penilaian
   *
   *
   */
  public function get_rencana_penilaian()
  {
    $ajaran_id	    	= $_POST['ajaran_id'];
    $kelas_id	      	= $_POST['kelas_id'];
    $id_mapel	      	= $_POST['id_mapel'];
    $kompetensi_id  	= $_POST['kompetensi_id'];

    $rencana = $this->db->get_where('rencana',[
      'ajaran_id'   => $ajaran_id,
      'id_mapel'    => $id_mapel,
      'kelas_id'    => $kelas_id,
      'kompetensi_id'=> $kompetensi_id,
    ])->result();

    if($rencana){
			foreach($rencana as $ren){
				$id_rencana[] = $ren->id;
      }

      $this->db->from('rencana_penilaian');
      $this->db->group_by('nama_penilaian');
      $this->db->order_by('id','ASC');
      $this->db->where_in('rencana_id',$id_rencana);

      $all_pengetahuan = $this->db->get()->result();

			$i=1;
			ksort($all_pengetahuan);
			if($all_pengetahuan){
				foreach($all_pengetahuan as $allpengetahuan){
					$record= array();
					$record['value'] 	= $allpengetahuan->rencana_id.'#'.$allpengetahuan->nama_penilaian.'#'.$allpengetahuan->id.'#'.$allpengetahuan->bobot_penilaian;
					if($kompetensi_id == 1){
					$record['text'] 	= 'Penilaian '.$i.' ('.$allpengetahuan->nama_penilaian.') || Bobot = '.$allpengetahuan->bobot_penilaian;
					} else {
					$record['text'] 	= 'Penilaian '.$i.' ('.$allpengetahuan->nama_penilaian.')';
					}
					$output['result'][] = $record;
					$i++;
				}
			} else {
				$record['value'] 	= '';
				$record['text'] 	= 'Tidak ditemukan rencana penilaian di mata pelajaran terpilih';
				$output['result'][] = $record;
			}
		} else {
			$record['value'] 	= '';
			$record['text'] 	= 'Tidak ditemukan rencana penilaian di mata pelajaran terpilih';
			$output['result'][] = $record;
		}
		echo json_encode($output);
  }

  /**
   * Get remedial value
   */
  public function get_remedial(){
		$record[0]['value'] 	= 'P';
		$record[0]['text'] 	= 'Pengetahuan';
		$record[1]['value'] 	= 'K';
		$record[1]['text'] 	= 'Keterampilan';
		$output['result'] = $record;
		echo json_encode($output);
  }

  public function get_rencana_id(){
		$all_rencana = array(
							array(
								'id'	=> 1,
								'nama'	=> 'Pengetahuan'
							),
							array(
								'id'	=> 2,
								'nama'	=>'Keterampilan'
							)
						);
		foreach($all_rencana as $rencana){
				$record= array();
				$record['value'] 	= $rencana['id'];
				$record['text'] 	= $rencana['nama'];
				$output['result'][] = $record;
			}
		echo json_encode($output);
	}
	public function get_rapor(){
		$data['ajaran_id'] = $_POST['ajaran_id'];
		$data['kelas_id'] = $_POST['kelas_id'];

		$data['nama_kompetensi'] = 2013;

		$this->load->view('cetak/rapor',$data);
	}

	public function get_chart(){
		$ajaran = get_ta();
		$this->db->from('rencana');
		$this->db->select('rencana.* , b.guru_id as guru_id');
		$this->db->group_by('id_mapel');
		$this->db->join('kelas a ','rencana.kelas_id = a.id','inner');
		$this->db->join('kurikulum b' ,'rencana.id_mapel = b.id_mapel','inner');
		$this->db->where(['rencana.ajaran_id' => $ajaran->id]);
		$query = $this->db->get()->result();
		if($query){
			$rp = 0;
			foreach($query as $q){
				$mapel = $this->db->get_where('data_mapel',['id' => $q->id_mapel])->row();
				$rencanapenilaian = $this->db->get_where('rencana_penilaian',['rencana_id' => $q->id])->result();
				$record= array();
				$record['value'] 	= count($rencanapenilaian);
				$record['color'] 	= "#".random_color();
				$record['highlight'] = "#".random_color();
				$record['label'] = isset($mapel->nama_mapel) ? $mapel->nama_mapel : '';
				$output['result'][] = $record;
			}
		} else {
			$record['value'] = '1e-10';
      $record['color'] = "#f56954";
    	$record['highlight'] = "#f56954";
	    $record['label'] = "Belum ada penilaian";
			$output['result'][] = $record;
		} 
		echo json_encode($output);
	}
}
