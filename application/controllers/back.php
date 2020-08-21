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