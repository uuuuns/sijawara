<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EbookGuest extends Controller 
{
    function __construct()
	{
		parent::__construct();
		$this->load->model(['Event', 'Course', 'Ebook', 'Checkout', 'Promo']);
		// error_reporting(0);
	}

    public function index()
    {
        $data['title'] = "Ebook";

        $data['ebook'] = $this->Ebook->get_all_book();
		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $this->load->view('template/header', $data);
		$this->load->view('guest/ebook/ebook');
		$this->load->view('template/footer');
    }

    public function listEbook()
    {
        $data['title'] = "List E-Book";
		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $this->load->view('template/header', $data);
		$this->load->view('guest/ebook/ebook_list');
		$this->load->view('template/footer');
    }
}
?>
