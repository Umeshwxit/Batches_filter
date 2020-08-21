<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uv_model extends CI_Model {

    public function get_data($table){
     $query=  $this->db->select('*')
                        ->from($table)
                        ->order_by('id','desc')
                        ->get();
    return $query->result();


    }
    public function get_categories()
{
    $query = $this->db->get('product_category');
    $return = array();

    foreach ($query->result() as $category)
    {
        $return[$category->id] = $category;
        $return[$category->id]->subs = $this->get_sub_categories($category->id); // Get the categories sub categories
    }
    return $return;
  
}

public function get_sub_categories($category_id)
{
    $this->db->where('category_id', $category_id);
    $query = $this->db->get('sub_category');
    return $query->result();
}
public function get_brand($cat_id,$sub_cat_id)
{   
    $this->db->select('b.brand_name,b.id');
    $this->db->from('products p');
    $this->db->group_by('product_brand');
    $this->db->join('brands  b','p.product_brand=b.id', 'left');
    
    if(empty($sub_cat_id)&& !empty($cat_id)){
        $this->db->where('p.product_category_id',$cat_id);
    }elseif(!empty($sub_cat_id)&& !empty($cat_id)){
    $this->db->where(array('p.product_category_id'=>$cat_id,'p.product_sub_category_id'=>$sub_cat_id));
            
    }
    $query=   $this->db->get();
    return  $query->result();
}

public function get_num_rows($min,$max,$cat_id,$sub_cat_id,$brand){
        $this->db->select('*');
        $this->db->from('products p');
        if(!empty($min) && !empty($max)){
        $this->db->where(array('p.product_price>='=>$min,'p.product_price<='=>$max));
        }
        if(empty($sub_cat_id)&& !empty($cat_id)){
            $this->db->where('p.product_category_id',$cat_id);
        }elseif(!empty($sub_cat_id)&& !empty($cat_id)){
        $this->db->where(array('p.product_category_id'=>$cat_id,'p.product_sub_category_id'=>$sub_cat_id));
             
        }
        if(!empty($brand)){
        $this->db->where_in('product_brand',$brand);
        }
        $query=   $this->db->get();
        return  $query->result();
    }

    public function filter_data($min,$max,$cat_id,$sub_cat_id,$brand,$order_by,$srt,$limit,$offset){
        $this->db->select('*');
        $this->db->from('products p');
        if(!empty($min) && !empty($max)){
        $this->db->where(array('p.product_price>='=>$min,'p.product_price<='=>$max));
        }
        if(empty($sub_cat_id)&& !empty($cat_id)){
            $this->db->where('p.product_category_id',$cat_id);
        }elseif(!empty($sub_cat_id)&& !empty($cat_id)){
        $this->db->where(array('p.product_category_id'=>$cat_id,'p.product_sub_category_id'=>$sub_cat_id));
             
        }
        if(!empty($brand)){
        $this->db->where_in('product_brand',$brand);
        }
        $this->db->order_by($order_by,$srt);
        $this->db->limit($limit,$offset);
        $query=   $this->db->get();
        return  $query->result();
    }
}
?>
    