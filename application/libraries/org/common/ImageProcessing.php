<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Author: Tanveer Ahmed
 *
 *
 * Created:  22.6.2014
 *
 * Requirements: PHP5 or above
 *
 */
class ImageProcessing {
    public function __construct() {
        
        $this->load->library('image_lib');
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
    }    

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    }
    
    public function resize_image($source_path, $new_path, $height, $width) {
        $config = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $new_path,
            'maintain_ratio' => FALSE,
            'overwrite' => TRUE,
            'height' => $height,
            'width' => $width
        );
        $image_absolute_path = FCPATH.dirname($new_path);
        if( !is_dir($image_absolute_path) )
        {
            mkdir($image_absolute_path, 0777, TRUE);
        }
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) return $this->image_lib->display_errors();
        return "resized successfully.";
    }
    
    public function image_upload($userfile, $upload_path, $file_name)
    {
        $config['image_library'] = 'gd2';
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = $file_name;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) return $this->upload->display_errors();
        else return "Image uploaded successfully.";
    }
}

?>
