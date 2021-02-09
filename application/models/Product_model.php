<?php
class Product_model extends CI_Model {

    var $records_per_page = 10; 
    var $start_from = 0;
    var $current_page_number = 1;
    
    // to get all products with sorting and pagination 
    function make_query() {
        
        if (isset($_POST["rowCount"])) {
            $this->records_per_page = $_POST["rowCount"];
        } else {
            $this->records_per_page = 10;
        }
        if (isset($_POST["current"])) {
            $this->current_page_number = $_POST["current"];
        }
        $this->start_from = ($this->current_page_number - 1) * $this->records_per_page;
        $this->db->select("*");
        $this->db->from("products");
   
        if (isset($_POST["sort"]) && is_array($_POST["sort"])) {
            foreach ($_POST["sort"] as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else {
            $this->db->order_by('product_id', 'DESC');
        }
        if ($this->records_per_page != -1) {
            $this->db->limit($this->records_per_page, $this->start_from);
        }
        $query = $this->db->get();
        
        return $query->result_array();
    }
    //to get the total count of products
    function count_all_data() {
        $this->db->select("*");
        $this->db->from("products");
        $query = $this->db->get();
        return $query->num_rows();
    }
    //to insert product in table
    function insert($data) {
     
        $this->db->insert('products', $data);
    }
    //to get specified product detail to edit
    function fetch_single_data($id) {
        $this->db->where('product_id', $id);
        $query = $this->db->get('products');
        return $query->result_array();
    }
    // to update the product details
    function update($data, $id) {
        $this->db->where('product_id', $id);
        $this->db->update('products', $data);
    }
    //to delete the specified product
    function delete($id) {
        $this->db->where('product_id', $id);
        $this->db->delete('products');
    }
}
?>