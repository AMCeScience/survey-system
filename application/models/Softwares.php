<?php

class Softwares extends CI_Model {

  private $not_interesting_names = ['EndNote', 'Review Manager (RevMan)', 'Covidence'];

  public function getSoftware()
  {
    return $this->db->from('softwares')->get()->result();
  }

  public function getInteresting()
  {
    return $this->db->from('softwares')->where_not_in('name', $this->not_interesting_names)->get()->result();
  }

  public function isValidId($id)
  {
    return $this->db->from('softwares')->where(['software_id' => $id])->count_all_results() > 0;
  }

  public function getUserSoftware($user_id)
  {
    $this->load->model('prefills');

    $software_id = $this->prefills->selectUserSoftware($user_id);

    return $this->db->select(['software_id', 'name'])->from('softwares')->where('software_id', $software_id)->get()->row(0);
  }

  public function getDataByArr($software_ids)
  {
    $software = $this->db->select(['software_id', 'name'])->from('softwares')->where_in('software_id', $software_ids)->get()->result();

    $software_arr = [];

    foreach ($software as $item) {
      $software_arr[$item->software_id] = $item->name;
    }

    return $software_arr;
  }

  public function softwareSort()
  {
    $software_list = $this->db->query("select count(*) as count, software_id
      from (select * from answers
        where software_id is not null
        group by user_id) as x
      group by x.software_id
      order by count desc")->result();

    $software_arr = [];

    foreach ($software_list as $software) {
      $software_arr[] = $software->software_id;
    }

    return $software_arr;
  }

}