<?php
/**
 * Created by PhpStorm.
 * User: randrianaivo
 * Date: 05/04/2019
 * Time: 11:16
 */
defined('BASEPATH') OR exit("No direct script allowed");

class News extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('vaovao');
    }

    public function index()
    {
        $data = array();
        if ($this->session->userdata('success_msg')) {
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if ($this->session->userdata('error_msg')) {
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }

        $data['nouvelles'] = $this->vaovao->getAllNews();
        $data['title'] = 'News';

        //load the list page view
        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');

    }

    public function view($id)
    {
        $data = array();

        //check whether post id is not empty
        if (!empty($id)) {
            $data['nouvelle'] = $this->vaovao->getNews($id);
            $data['title'] = $data['nouvelle']['title'];

            //load the details page view
            $this->load->view('templates/header', $data);
            $this->load->view('news/view', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('/news');
        }
    }

    public function create()
    {
        $data = array();
        $newsData = array();

        //if add request is submitted
        if ($this->input->post('create_news')) {
            //form field validation rules
            $this->form_validation->set_rules('title', 'news title', 'required');
            $this->form_validation->set_rules('description', 'news description', 'required');

            //prepare post data
            $newsData = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description')
            );

            //validate submitted form data
            if ($this->form_validation->run() == true) {
                //insert post data
                $insert = $this->vaovao->insertNews($newsData);

                if ($insert) {
                    $this->session->set_userdata('success_msg', 'Post has been added successfully.');
                    redirect('/news');
                } else {
                    $data['error_msg'] = 'Some problems occurred, please try again.';
                }
            }
        }

        $data['nouvelle'] = $newsData;
        $data['title'] = 'Create news';
        $data['action'] = 'Add';

        //load the add page view
        $this->load->view('templates/header', $data);
        $this->load->view('news/add-edit', $data);
        $this->load->view('templates/footer');

    }
}