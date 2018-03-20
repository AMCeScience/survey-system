<?php

class Prefills extends CI_Model {

  private $interesting_software_ids;

  public function getPrefills($user_id)
  {
    $data['reviews'] = $this->db->from('prefills')->where('user_id', $user_id)->get()->row(0);

    $data['software'] = $this->db->from('prefills')
      ->join('softwares_to_prefills', 'prefills.prefill_id = softwares_to_prefills.prefill_id')
      ->join('softwares', 'softwares_to_prefills.software_id = softwares.software_id')
      ->where('prefills.user_id', $user_id)
      ->get()
      ->result();

    return $data;
  }

  public function updateSoftware($software_id, $user_id, $value)
  {
    $prefill = $this->db->select('prefill_id')->get_where('prefills', ['user_id' => $user_id])->row(0);

    $this->db
      ->set(['value' => $value, 'has_changed' => 1])
      ->where(['prefill_id' => $prefill->prefill_id, 'software_id' => $software_id])
      ->update('softwares_to_prefills');
  }

  public function updatePrefill($type, $user_id, $value)
  {
    $field = 'number_of_reviews';

    if ($type === 'papers') {
      $field = 'number_of_papers';
    }

    $this->db
      ->set([$field => $value, 'has_changed' => 1])
      ->where('user_id', $user_id)
      ->update('prefills');
  }

  public function precheckFinishedUpdateProgress($user_id)
  {
    $progress_increments = $this->config->item('progress');

    $old_progress = $this->db->get_where('user_progress', ['user_id' => $user_id])->row(0);

    $data = [
      'progress' => 'prefill_check',
      'percentage' => $progress_increments['prefill_check']
    ];

    if (is_null($old_progress)) {
      $data['user_id'] = $user_id;

      $this->db->insert('user_progress', $data);
    } else if ($old_progress->percentage * 1 <= 25) {
      $this->db->where('user_id', $user_id)->update('user_progress', $data);
    }
  }

  public function userType($user_id)
  {
    $this->load->model('softwares');

    $interesting_software_obj = $this->softwares->getInteresting();

    foreach ($interesting_software_obj as $obj) {
      $this->interesting_software_ids[] = $obj->software_id;
    }

    if ($this->isUsing($user_id)) {
      return 'using';
    }

    if ($this->isConsideringUse($user_id)) {
      return 'considering';
    }

    return 'no_use';
  }

  public function validateSoftwareId($user_id, $software_id)
  {
    $interesting = $this->getInteresting($user_id, true);
    
    foreach ($interesting as $item) {
      if ($item->software_id === $software_id) {
        return true;
      }
    }

    return false;
  }

  public function getUndoneUserSoftware($user_id)
  {
    $done_list = $this->doneSoftwares($user_id);
    $interesting_list = $this->getInteresting($user_id, false, $done_list);
    
    $interesting_arr = [];

    if (!is_null($interesting_list) && count($interesting_list) > 0) {
      foreach ($interesting_list as $interesting) {
        if (!in_array($interesting->software_id, $done_list)) {
          $interesting_arr[] = $interesting->software_id;
        }
      }
    }

    $this->load->model('softwares');

    if (count($interesting_arr) > 0) {
      return $this->softwares->getDataByArr($interesting_arr);
    }

    return null;
  }

  public function selectUserSoftware($user_id)
  {
    $existing_id = $this->db->select('software_id')
      ->from('answers')
      ->where('software_id is not null', null, false)
      ->where('user_id', $user_id)
      ->where_in('question_list', ['specific', 'usability'])
      ->order_by('answer_id', 'desc')
      ->get()
      ->row(0);

    // Return whatever the user was working with
    if (!is_null($existing_id)) {
      return $existing_id->software_id;
    }

    $interesting_list = $this->getInteresting($user_id);
    
    $interesting_arr = [];

    foreach ($interesting_list as $interesting) {
      $interesting_arr[] = $interesting->software_id;
    }

    // If no software is in array return null
    if (count($interesting_arr) < 1) {
      return null;
    }

    $this->load->model('softwares');

    $preference_order = $this->softwares->softwareSort();
    
    $diff = array_diff($interesting_arr, $preference_order);

    // If a difference was found, no answers are given for that package yet
    // In that case return a random item from the difference array
    if (count($diff) > 0) {

      return $diff[array_rand($diff, 1)];
    }

    // Select the first item in the preference array
    foreach ($preference_order as $preference) {
      if (in_array($preference, $interesting_arr)) {
        return $preference;
      }
    }

    // Just return the first item
    return $interesting_arr[0];
  }

  public function getInteresting($user_id, $all = false, $done_list = [])
  {
    $user_type = $this->userType($user_id);

    $software = null;

    switch ($user_type) {
      case 'using':
        $software = $this->softwareUsing($user_id, $all, $done_list);

        break;
      case 'considering':
        $software = $this->softwareConsidering($user_id, $all, $done_list);

        break;
    }

    return $software;
  }

  public function doneSoftwares($user_id)
  {
    $done = $this->db->select('software_id')->from('answers')->where('user_id', $user_id)->group_by('software_id')->get()->result();

    $id_arr = [];

    foreach ($done as $item) {
      if (is_null($item->software_id)) {
        continue;
      }

      $id_arr[] = $item->software_id;
    }

    return $id_arr;
  }

  public function softwareUsing($user_id, $all, $done_list)
  {
    $prefill = $this->getPrefillIdForUser($user_id);

    $using_obj = $this->db
      ->select(['name', 'softwares.software_id'])
      ->from('softwares_to_prefills')
      ->join('softwares', 'softwares.software_id = softwares_to_prefills.software_id')
      ->where('prefill_id', $prefill->prefill_id)
      ->where('softwares_to_prefills.software_id !=', 35)
      ->where_in('value', ['2', '3'])
      ->where_in('softwares_to_prefills.software_id', $this->interesting_software_ids);

    if (count($done_list) > 0) {
      $using_obj->where_not_in('softwares_to_prefills.software_id', $done_list);
    }

    $using = $using_obj->get()
      ->result();

    if (count($using) < 1 || $all === true) {
      $using = $this->db
      ->select(['name', 'softwares.software_id'])
      ->from('softwares_to_prefills')
      ->join('softwares', 'softwares.software_id = softwares_to_prefills.software_id')
      ->where('prefill_id', $prefill->prefill_id)
      ->where('softwares_to_prefills.software_id !=', 35)
      ->where_in('value', ['2', '3']);

      if (count($done_list) > 0) {
        $using_obj->where_not_in('softwares_to_prefills.software_id', $done_list);
      }

      $using = $using_obj->get()
        ->result();
    }

    return $using;
  }

  public function softwareConsidering($user_id, $all, $done_list)
  {
    $prefill = $this->getPrefillIdForUser($user_id);

    $considering_obj = $this->db
      ->select(['name', 'softwares.software_id'])
      ->from('softwares_to_prefills')
      ->join('softwares', 'softwares.software_id = softwares_to_prefills.software_id')
      ->where(['prefill_id' => $prefill->prefill_id, 'value' => '1'])
      ->where('softwares_to_prefills.software_id !=', 35)
      ->where_in('softwares_to_prefills.software_id', $this->interesting_software_ids);

    if (count($done_list) > 0) {
      $considering_obj->where_not_in('softwares_to_prefills.software_id', $done_list);
    }

    $considering = $considering_obj->get()
      ->result();

    if (count($considering) < 1 || $all === true) {
      $considering = $this->db
      ->select(['name', 'softwares.software_id'])
      ->from('softwares_to_prefills')
      ->join('softwares', 'softwares.software_id = softwares_to_prefills.software_id')
      ->where(['prefill_id' => $prefill->prefill_id, 'value' => '1'])
      ->where('softwares_to_prefills.software_id !=', 35);

      if (count($done_list) > 0) {
        $considering_obj->where_not_in('softwares_to_prefills.software_id', $done_list);
      }

      $considering = $considering_obj->get()
        ->result();
    }
    
    return $considering;
  }

  private function isUsing($user_id)
  {
    $prefill = $this->getPrefillIdForUser($user_id);

    return $this->db->from('softwares_to_prefills')
      ->where('prefill_id', $prefill->prefill_id)
      ->where('software_id !=', 35)
      ->where_in('value', ['2', '3'])
      ->count_all_results() > 0;
  }

  private function isConsideringUse($user_id)
  {
    $prefill = $this->getPrefillIdForUser($user_id);

    $is_using = $this->isUsing($user_id);
    $is_considering = $this->db->from('softwares_to_prefills')
      ->where('software_id !=', 35)
      ->where(['prefill_id' => $prefill->prefill_id, 'value' => '1'])
      ->count_all_results() > 0;

    return (!$is_using && $is_considering);
  }

  private function getPrefillIdForUser($user_id)
  {
    return $this->db->select('prefill_id')->get_where('prefills', ['user_id' => $user_id])->row(0);
  }

}