<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
    }

    function index() {
        $this->load->view('index');
    }
    
    //this function is used to fetch all the products with details and display in grid.
    function fetch_data() { 
        $data = $this->product_model->make_query();

        $array = array();
        foreach ($data as $row) {
            $array[] = $row;
        }       
        
        $output = array(
            'current' => intval($_POST["current"]),
            'rowCount' => 10,
            'total' => intval($this->product_model->count_all_data()),
            'rows' => $array
        );
      
        echo json_encode($output);
    }
    //this function is used to perform actions like add and edit products.
    function action() {

        if ($this->input->post('operation')) {

            if (!empty($_FILES['product_image']['name'])) {
                $product_image = $this->uploadImage();
            }

            $data = array(
                'product_title' => $this->input->post('product_title'),
                'product_description' => $this->input->post('product_description'),
                'product_price' => $this->input->post('product_price'),
                'product_quantity' => $this->input->post('product_quantity')
            );
            if ($product_image != '')
                $data['product_image'] = $product_image;

            if ($this->input->post('operation') == 'Save') {
                $this->product_model->insert($data);
                echo 'Data Inserted';
            }
            if ($this->input->post('operation') == 'Update') {
                $this->product_model->update($data, $this->input->post('product_id'));
                echo 'Data Updated';
            }
        }
    }
    //this function is used to fetch specified product detail for updation
    function fetch_single_data() {
        if ($this->input->post('product_id')) {
            $data = $this->product_model->fetch_single_data($this->input->post('product_id'));
            foreach ($data as $row) {
                $output['product_title'] = $row['product_title'];
                $output['product_description'] = $row['product_description'];
                $output['product_price'] = $row['product_price'];
                $output['product_quantity'] = $row['product_quantity'];
            }
            echo json_encode($output);
        }
    }
    //this function is used to delete specified  product 
    function delete_data() {
        if ($this->input->post('product_id')) {
            $this->product_model->delete($this->input->post('product_id'));
            echo 'Data Deleted';
        }
    }
    //this fuction is to upload product image and thumbimage to the folder
    public function uploadImage() {

        $type = explode('.', $_FILES['product_image']['name']);
        $type = $type[count($type) - 1];
        $imagefile = uniqid(rand()) . '.' . $type;
        $url = 'assets/images/products/' . $imagefile;

        if (in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
            if (is_uploaded_file($_FILES['product_image']['tmp_name'])) {
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $url)) {
                    $source_path = $url;
                    $thumb_path = 'assets/images/products/thumb/';
                    $thumb_width = 96;
                    $thumb_height = 96;
                    // Image resize config 
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $source_path;
                    $config['new_image'] = $thumb_path;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = $thumb_width;
                    $config['height'] = $thumb_height;

                    $this->load->library('image_lib', $config);

                    if ($this->image_lib->resize()) {
                        $thumbnail = $thumb_path . $imagefile;
                        $thumb_image_size = $thumb_width . 'x' . $thumb_height;
                    }
                    return $imagefile;
                } else {
                    return false;
                }
            }
        }
    }

}
?>