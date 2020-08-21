<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
	{
	  parent :: __construct();
	  $this->load->model('Uv_model','uv');
	}
	
	public function index()
	{   $data['brands']=$this->uv->get_brand('','');
		$data['categories']=$this->uv->get_categories();
		
		$this->load->view('index',$data);
	}
	
	public function my_filters(){
		$max=$this->input->post('max');
		$min=$this->input->post('min');
		$cat=$this->input->post('cat');
		$per_page=$this->input->post('per_page');
		$sub_cat=$this->input->post('sub_cat');
		$brand=	$this->input->post('brand');
		$order_by=$this->input->post('order_by');
        $srt=$this->input->post('srt');
		$num_rows=$this->uv->get_num_rows($max,$min,$cat,$sub_cat,$brand);
		$total_rows= count($num_rows);
        
        $this->load->library('pagination');
        $config['base_url'] = '#';
        $config['total_rows'] = $total_rows;
        $config['per_page'] =$per_page;
        
        $config['full_tag_open']='<nav aria-label="Page navigation example"><ul class="pagination">';
        $config['last_tag_close']="</ul></nav>";
        $config['last_tag_open']='<li class="page-item">';
        $config['last_tag_close']="</li>";
        $config['first_tag_open']='<li class="page-item">';
        $config['first_tag_close']="</li>";
        $config['prev_tag_open']='<li class="page-item">';
        $config['prev_tag_close']="</li>";
        $config['last_tag_open']='<li class="page-item">';
        $config['last_tag_close']="</li>";
        $config['cur_tag_open']="<li class='page-item active'><a href='#'>";
        $config['cur_tag_close']="</a></li>";
        $config['num_tag_open']='<li class="page-item">';
        $config['num_tag_close']="</li>";
        $config['next_tag_open']='<li class="page-item">';
        $config['next_tag_close']="</li>";
        $config['num_links'] = 2;
        $this->pagination->initialize($config);        
        // getting products	
        $limit=$per_page;
         $offset=($this->uri->segment('3')-1)*$limit;
		$data=$this->uv->filter_data($max,$min,$cat,$sub_cat,$brand,$order_by,$srt,$limit,$offset);
		if(!empty($data)){
		$response='';
		foreach($data as $product){
			$response.='<div class="col-md-4">
            <div class="card" " style="margin:10px 0px"><img class="img-thumbnail img-fluid " src=" '.base_url().'assets/images/'.$product->product_image.'" class="card-img-top"><div class="card-body">
                    <h5 class="">'.$product->product_name.'</h5>
                    <p class="">'.$product->product_price.' <span></span></p>
                    <a href="#" class="btn btn-primary">Buy now</a>
                </div>
            </div>

       </div>';
		}}else{
		 $response='<div class="alert alert-danger" style="margin-top: 130px;margin:auto;font-size:50px">No Product Found</div>';
		}
		// getting brands
		$brands=$this->uv->get_brand($cat,$sub_cat);
		if(!empty($brands)){
		$filter_brand='';
		foreach($brands as $brand){
			$filter_brand.='<input type="checkbox"  class="brand" value='.$brand->id .' >&nbsp;<label>'. $brand->brand_name.'</label>';
		}}else{
		 $filter_brand='<div class="alert alert-danger" >No brand available</div>';
		}
	// json response
		$output=array('pagination_links'=>$this->pagination->create_links(),'brands'=>$filter_brand,'products'=>$response);
		echo json_encode($output);
	}
	
}
?>



