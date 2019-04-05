<?php
/**
 * Created by PhpStorm.
 * User: randrianaivo
 * Date: 05/04/2019
 * Time: 16:18
 */

defined("BASEPATH") OR exit("No direct access allowed");

class Vaovao extends CI_Model
{
    public function getAllNews()
    {
        $query = $this->db->get("news");
        return $query->result_array();
    }

    public function getNews($id)
    {
        $query = $this->db->get_where("news", array("id" => $id));
        return $query->row_array();
    }

    public function insertNews($news)
    {
        $new_news = $this->db->insert("news", $news);
        if ($new_news) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
}