<?php

class M_perencanaan extends CI_Model
{
    public function get_all_rencana_penilaian($rencana_id)
    {
        $this->db->from('rencana_penilaian');
        $this->db->where(['rencana_id' => $rencana_id]);
        $this->db->group_by(['nama_penilaian']);
        $this->db->order_by('bentuk_penilaian','ASC');
        
        $result = $this->db->get()->result();
        return $result;
    }
}