<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public $user_type_list = array();

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/admin/footer/admin_about_us');
        $this->load->library('org/application/photography_library');
        $this->load->library('org/admin/application/admin_photography');
//        $this->load->library('org/admin/application/admin_xstream_banter');
        $this->load->library('org/admin/application/admin_service_directory');
        $this->load->library('org/application/service_directory_library');
        $this->load->library('org/admin/application/admin_healthy_recipes');
        $this->load->library('org/admin/application/admin_blog');
        $this->load->library('org/application/xstream_banter_library');
        $this->load->library('org/application/service_directory_library');
        $this->load->library('org/application/news_app_library');
        $this->load->library('org/admin/application/admin_news');
        $this->load->library('org/profile/business/business_profile_library');
        $this->load->library('org/question/security_question_library');
        $this->load->library('org/interest/special_interest');
        $this->load->library('org/utility/utils');
        $this->load->library('form_validation');
        $this->load->library('statuses');
        $this->load->library('recent_activities');
        $this->load->library('org/admin/users_library');
        $this->load->library('org/admin/visitors');
        $this->load->library('albums');
        $this->load->library('org/application/gympro_library');
        $this->load->helper('url');
        $this->user_type_list = $this->config->item("user_type", "ion_auth");
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
//        if (!$this->ion_auth->logged_in()) {
//            redirect('auth/login', 'refresh');
//        }
    }

    function index() {
        $response = $this->CallAPI("GET", "http://api.espn.com/v1/sports?apikey=zzj84kdyuvdabhv4n6dsr757");
        //print_r($response);

        /* $jsonIterator = new RecursiveIteratorIterator(
          new RecursiveArrayIterator(json_decode($response, TRUE)),
          RecursiveIteratorIterator::SELF_FIRST);

          foreach ($jsonIterator as $key => $val) {
          if(is_array($val)) {
          //echo "$key:\n";
          echo $key.'</br>';
          } else {
          echo "$key => $val\n";
          }
          } */
        //echo json_decode($response)
        //print_r(json_decode($response));
        $r = json_decode($response);
        print_r($r->sports);
        foreach ($r->sports as $key => $value) {
            print_r($value);
            echo "<br><br><br>";
        }
        //echo $response; 
    }

    function CallAPI($method, $url, $data = false) {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    function store_business_profile_type() {
        $lines = file('resources/business_profile_types.txt');
        $business_profile_type_list = array();
        foreach ($lines as $line) {
            $splited_content = explode("~", $line);
            $business_profile_type_info = array();
            $business_profile_type_info['description'] = $splited_content[0];
            $sub_type_list = array();
            $len = sizeof($splited_content);
            $counter = 1;
            for ($i = 1; $i < $len; $i++) {
                $sub_type = new stdClass();
                $sub_type->id = $counter++;
                $sub_type->description = trim($splited_content[$i]);
                $sub_type_list[] = $sub_type;
            }
            $business_profile_type_info['sub_type_list'] = json_encode($sub_type_list);
            $business_profile_type_list[] = $business_profile_type_info;
        }
        //print_r($business_profile_type_list);
        $this->business_profile_library->add_all_business_profile_types($business_profile_type_list);
    }

    public function get_all_security_questions() {
        $security_questions_array = $this->security_question_library->get_all_security_questions()->result_array();
        print_r($security_questions_array);
    }

    function store_member_special_interests() {
        $lines = file('resources/member_special_interests.txt');
        $special_interest_list = array();
        foreach ($lines as $line) {
            $splited_content = explode("~", $line);
            $special_interest_info = array();
            $special_interest_info['description'] = $splited_content[0];
            $sub_category_list = array();
            $len = sizeof($splited_content);
            $counter = 1;
            for ($i = 1; $i < $len; $i++) {
                $sub_category = new stdClass();
                $sub_category->id = $counter++;
                $sub_category->description = trim($splited_content[$i]);
                $sub_category_list[] = $sub_category;
            }
            $special_interest_info['sub_category_list'] = json_encode($sub_category_list);
            $special_interest_list[] = $special_interest_info;
        }
        //print_r($special_interest_list);
        $this->special_interest_library->add_all_special_interests($special_interest_list);
    }

    function test1() {
        $this->admin_about_us->test();
    }

    function test_details() {

        print_r($this->visitors->get_page_visitors());
        //print_r(now());
    }

    function config_news() {
        $this->load->view('admin/applications/news_app/config_news_for_catagory_new');
    }

    function my_blogs() {
        $this->template->load(null, "applications/blog_app/my_blogs_view", $this->data);
    }

    function upload_crop() {
        if (isset($_FILES["userfile"])) {
            //uploading picture
            $config['image_library'] = 'gd2';
            $config['upload_path'] = HEALTHY_RECIPES_IMAGE_PATH;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10240';
            $config['file_name'] = "00katakata.jpg";

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors();
                $this->data['error'] = $error;
                $this->load->view('test', $this->data);
            } else {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];

                $config['image_library'] = 'gd2';
                $config['source_image'] = HEALTHY_RECIPES_IMAGE_PATH . $file_name;
                $config['new_image'] = HEALTHY_RECIPES_IMAGE_PATH . "00katakataCroped.jpg";
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 512;
                $config['height'] = 512;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $error = 'suscessfully resized.';
                $this->data['error'] = $error;
                $this->load->view('test', $this->data);
            }
        } else {
            $error = 'first load or no file data found';
            $this->data['error'] = $error;
            $this->load->view('test', $this->data);
        }
    }

    function change_image() {
        $bg = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'); // array of filenames
        //$i = rand(0, count($bg)-1); // generate random number size of the array
        //$selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
        $this->data['bg_image'] = $bg;
        $this->load->view('background_img_view', $this->data);
    }

    function image_slide() {
        $bg = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'); // array of filenames
        $this->data['bg_image'] = $bg;
        $this->load->view('change_image', $this->data);
    }

    function app_dir() {
//        $this->load->view('test', $this->data);
        $app1 = array(
            'app_name' => 'FaceGGame',
            'desc' => 'Description description description description description description description description description description.',
            'summ' => '',
            'img1' => base_url() . "resources/images/face.jpg",
            'img2' => base_url() . "resources/images/face.jpg",
            'gal_img1' => base_url() . "resources/images/face.jpg",
            'gal_img2' => base_url() . "resources/images/face.jpg",
            'gal_img3' => base_url() . "resources/images/face.jpg",
            'gal_img4' => base_url() . "resources/images/face.jpg",
            'btn_state' => "Try it",
        );
        $app2 = array(
            'app_name' => 'abc',
            'desc' => 'desc',
            'summ' => '',
            'img1' => base_url() . "resources/images/face.jpg",
            'img2' => base_url() . "resources/images/face.jpg",
            'gal_img1' => base_url() . "resources/images/face.jpg",
            'gal_img2' => base_url() . "resources/images/face.jpg",
            'gal_img3' => base_url() . "resources/images/face.jpg",
            'gal_img4' => base_url() . "resources/images/face.jpg",
            'btn_state' => "Try it",
        );
        $app3 = array(
            'app_name' => 'abc',
            'desc' => 'desc',
            'summ' => '',
            'img1' => base_url() . "resources/images/face.jpg",
            'img2' => base_url() . "resources/images/face.jpg",
            'gal_img1' => base_url() . "resources/images/face.jpg",
            'gal_img2' => base_url() . "resources/images/face.jpg",
            'gal_img3' => base_url() . "resources/images/face.jpg",
            'gal_img4' => base_url() . "resources/images/face.jpg",
            'btn_state' => "Try it",
        );

        $app_data = array();
        $app_data[0] = $app1;
        $app_data[1] = $app2;
        $app_data[2] = $app3;



        $this->data['app_data'] = $app_data;
        $this->template->load(null, "test", $this->data);
    }

    function run_test_page_in_view() {
        $arrEMPTY = array();
//        $arrEMPTY = NULL;
        $arrFULL = array();
        $arrFULL[] = array(
            'name' => 'tanveer',
            'id' => '1'
        );
        $arrFULL[] = array(
            'name' => 'qtanveer',
            'id' => '2'
        );
        $arrFULL[] = array(
            'name' => 'atanveer',
            'id' => '3'
        );
        $arrFULL[] = array(
            'name' => 'ztanveer',
            'id' => '4'
        );
        $this->data['arrFULL'] = $arrFULL;
        $this->data['arrEMPTY'] = $arrEMPTY;


        foreach ($arrEMPTY as $value) {
            var_dump($value);
            var_dump('---entered----');
        }


        $this->template->load(null, "test", $this->data);
    }

    function run_toms_shoes() {
        $this->template->load(null, "shop/toms_shoes", $this->data);
    }

    function shop_home() {
        $this->template->load(null, "shop/shop_home", $this->data);
    }

    function shop_shopping_bag() {
        $this->template->load(null, "shop/shop_shopping_bag", $this->data);
    }

    function shop_item() {
        $this->template->load(null, "shop/shop_item", $this->data);
    }

    function shop_items_by_category() {
        $this->template->load(null, "shop/shop_items_by_category", $this->data);
    }

    function gympro_home() {
        $application_id = 1;
        $this->data['application_id'] = $application_id;
        $this->template->load(null, "gympro/gympro_home", $this->data);
    }

    function gympro_nutrition() {
        $this->template->load(null, "gympro/gympro_nutrition", $this->data);
    }

    function gympro_edit_programme() {
        $this->template->load(null, "gympro/gympro_edit_programme", $this->data);
    }

    function gympro_add_client() {
        $this->template->load(null, "gympro/gympro_add_client", $this->data);
    }

    function fileimageupload() {
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            //uploading image
            $result = $this->utils->upload_image($file_info, 'resources/images/test');
            if ($result['status'] == 1) {
                $data['picture'] = $result['upload_data']['file_name'];
            } else {
                $this->data['message'] = $result['message'];
                echo json_encode($this->data);
                return;
            }
        }
    }

    function test_msort() {
        $reference_info_list = new stdClass();
        $reference_info_list->user_id = 3; //reference id 

        $reference_info_list1 = new stdClass();
        $reference_info_list1->user_id = 1; //reference id 


        $reference_info_list2 = new stdClass();
        $reference_info_list2->user_id = 2; //reference id 


        $array_list = array();
        $array_list[0] = $reference_info_list;
        $array_list[1] = $reference_info_list1;
        $array_list[2] = $reference_info_list2;
        var_dump($array_list);

        function cmp($array_list, $compair_list) {

            return strcmp($array_list->user_id, $compair_list->user_id);
        }

        usort($array_list, "cmp");
        var_dump($array_list);
    }

    function get_statuses() {
        $result_array = $this->statuses->get_selected_recipe();
    }

    function datetest() {

        $nextWeek = time() + (7 * 24 * 60 * 60);
        // 7 days; 24 hours; 60 mins; 60 secs
        echo 'Now:       ' . date('Y-m-d') . "\n";
        echo 'Next Week: ' . date('Y-m-d', $nextWeek) . "\n";
// or using strtotime():
        echo 'Next Week: ' . date('Y-m-d', strtotime('+1 week')) . "\n";


        $date = '2015-02-27'; // current date
            echo $date ;
        $date = strtotime(date("Y-m-d", strtotime($date)) . " +1 week");
        echo $date ;
        $date = strtotime(date("Y-m-d", strtotime($date)) . " +2 week");
        $date = strtotime(date("Y-m-d", strtotime($date)) . " +1 month");
        $date = strtotime(date("Y-m-d", strtotime($date)) . " +30 days");
    }
    function session(){
        $user_id = 3;
        $session_list_array = $this->gympro_model->get_client($user_id)->result_array();
        var_dump($session_list_array);exit;
    }

}
