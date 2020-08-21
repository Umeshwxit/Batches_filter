
$(document).ready(function(){
  cat_id='';
  sub_cat='';
  order_by='';
  srt=''; 
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
   srt=$($this).val();
 })
 $("#name").change(function(){
   order_by='product_name';
   srt=$($this).val();
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
   url:'<?php echo base_url() ?>index.php/home/my_filters',
   method:'POST',
   data:{
     max:max,
     min:min,
     cat:cat_id,
     sub_cat:sub_cat,
     brand:brand,
     order_by:order_by,
     srt:srt
   },
   success:function($res){
      $("#products").html($res);
   }
  });
}
filter_data();
$(".brand").click(function(){
  filter_data();
});
      
    });
       

