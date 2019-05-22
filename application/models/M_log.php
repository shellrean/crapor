<?php
class M_log extends CI_Model
{
  /**
   * Method untuk menyimpan log log dari apliaksi
   * @param array $param
   * @return integer
   */
  public function save_log($param)
  {
      $sql        = $this->db->insert_string('log',$param);
      $ex         = $this->db->query($sql);
      return $this->db->affected_rows($sql);
  }

  /**
   * Method untuk mendapatkan login log terahir berdasarkan login_id
   * @param  integer $login_id
   * @return array
   * @author kuswandi <wandinak17@gmail.com>
   */
  public function retrieve_last_log($login_id)
  {
      $this->db->where('login_id', $login_id);
      $this->db->order_by('id', 'desc');
      $result = $this->db->get('login_log', 1);
      return $result->row_array();
  }

  /**
     * Method untuk menambahkan riwayat log
     * @param  integer $login_id
	 * @return integer
     * @author kuswandi <wandinak17@gmail.com>
     */
    public function create_log($login_id)
    {
        $this->db->insert('login_log', array(
            'login_id' => $login_id,
            'lasttime' => date('Y-m-d H:i:s'),
            'agent'    => json_encode(array(
                'is_mobile'    => ($this->agent->is_mobile()) ? 1 : 0,
                'browser'      => ($this->agent->is_browser()) ? $this->agent->browser() . ' ' . $this->agent->version() : '',
                'platform'     => $this->agent->platform(),
                'agent_string' => $this->agent->agent_string(),
                'ip'           => get_ip(),
            ))
        ));

        return $this->db->insert_id();
    }
}
