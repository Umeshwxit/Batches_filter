<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <title>Task Of wxit</title>
   <style>
   .dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 5px 16px;
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}</style>
   </head>
  <body>
    <h1 class="text-center">Our Prodcuts</h1>
    <section class="container">
    <div class="row">
    <div class="col-md-3">
    <h3>Filters</h3>
    <p>
        <label for="amount">Price range:</label>
        <div id="slider-range"></div>
        <br>
        <label>Min:</label>
        <input type="text" name="max_price" id="max_price" value="300" style="height: 50px;width:50px">
        <label>Max:</label> <input type="text" name="min_price" id="min_price" value="60000" style="height: 50px;width:50px">
        <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;" >
       
    </p>
    <h4>Categoris</h4>
    <?php foreach($categories as $category){ ?>
    <div data-cat_id="<?php echo $category->id ?>" class="dropdown form-control commom category">
      <span><?php echo $category->category_name ?></span>
      <div class="dropdown-content">
      <?php  foreach($category->subs as $sub_cat) {?>
      <p class="sub_category"  data-cat_id=<?php echo  $category->id  ?> data-sub_cat_id="<?php echo $sub_cat->id ?>"><?php echo $sub_cat->sub_cat_name ?></p>
      <hr>
    <?php } ?>
      </div>
    </div><br>
     <?php } ?>
    <br>
     <h3>Brands</h3>
     <div id="brands">
     </div>
     
    <br>
    </div>
    <div class="col-md-9">
    <div class="bg-light py-3 px-2" style="width: 100%;">
        <div class="row">
          <div class="col-md-3">
            <strong>Price</strong>
            <select id="price">
            <option value="asc" >Low To high</option>
            
            <option value="desc" >High To low</option>
            </select>
          </div>
          <div class="col-md-3">
            <strong>Name</strong>
            <select id="name">
            <option value="asc"> A to Z</option>
            
            <option value="desc">Z to A</option>
            </select>
          </div>
          <div class="col-md-2">
            <strong>Show</strong>
            <select id="per_page">
            <option value="1">1</option>
            <option value="7">7</option>
            <option value="10">10</option>
            </select>
          </div>
          <div class="col-md-4" id="pagination_links">
            
          </div>
          </div>
        <div class="row" id="products">
        
        </div>
 
    </div>

    </div>



    </div>
    </section>
<script>

   $(document).ready(function(){
      cat_id='';
      sub_cat='';
      order_by='product_name';
      srt='asc'; 
      per_page=6;
      page=1;
      $(".category").click(function(){
       cat_id= $(this).data('cat_id');
       filter_data();
      })
      $(".sub_category").click(function(){
      cat_id=  $(this).data('cat_id')
       sub_cat= $(this).data('sub_cat_id')
     filter_data(); 
        
      })
     $("#price").change(function(){
       order_by='product_price';
       srt=$("#price").val();
       filter_data();
     })
     $("#name").change(function(){
       order_by='product_name';
       srt=$("#name").val();
       filter_data()
     })

     $("#per_page").change(function() {
      per_page=$("#per_page").val();
      filter_data();
     })
     $(document).on('click','.pagination li a',function(e){
      e.preventDefault();
      page=$(this).data('ci-pagination-page');
      filter_data();
     })

    $( "#slider-range" ).slider({
      range: true,
      min: 400,
      max: 60000,
      values: [ 400, 60000 ],
      slide: function( event, ui ) {
        $( "#max_price" ).val(ui.values[ 0 ]  );
        $( "#min_price" ).val(ui.values[ 1 ]  );
       filter_data();     
      }
            });
      
            
    function filter_data(){
      max= $( "#max_price" ).val();
      min=$( "#min_price" ).val();
      
      brand=get_brand();
      console.log(brand);
      function get_brand(){
        var brands = [];
        $(".brand:checked").each(function(){
          brands.push($(this).val())
        });
        return brands;
      }
      
      $.ajax({
       url:"<?php echo base_url() ?>index.php/home/my_filters/"+page,
       method:"POST",
       dataType:'JSON',
       data:{
         max:max,
         min:min,
         cat:cat_id,
         sub_cat:sub_cat,
         brand:brand,
         order_by:order_by,
         srt:srt,
         per_page:per_page
       },
       success:function($res){
        
        $("#brands").html($res.brands) 
        $("#pagination_links").html($res.pagination_links)
        $("#products").html($res.products)
          }
      });
    }
    filter_data();
    $(".brand").click(function(){
      filter_data();
    });
    $(document).scroll(function(){
      cat_id='';
      sub_cat='';
      order_by='';
      srt=''; 
      max='';
      min='';
      brand='';
      filter_data();
    })      
        });
     

    
    </script>
  