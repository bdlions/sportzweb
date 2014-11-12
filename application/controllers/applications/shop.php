<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shop extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->helper('url');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    
    public function index()
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/shop/index', $this->data);
    }
    
    public function show_product($product_id = 0)
    {
        $this->data['message'] = '';        
        $this->template->load(null,'applications/shop/product_show', $this->data);
    }
    public function shopping_bag()
    {
        $this->data['message'] = '';        
        $this->template->load(null, "applications/shop/shopping_bag", $this->data);
    }
    public function items_by_category()
    {
        $this->data['message'] = '';        
        $this->template->load(null, "applications/shop/items_by_category", $this->data);
    }
    
    //////////////////
    
    
    function run_toms_shoes()
    {
        $this->template->load(null, "shop/toms_shoes", $this->data);
    }
}

