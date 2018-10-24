<style>
.faq-detail{ display:none;
}
</style>


<script>
    var limit = 5;
   $(document).ready(function(){ 
    size_li = $(".faq-detail").size();

                if(size_li<=limit){
                 jQuery("#loadMore").hide();
                }else{
                 jQuery("#loadMore").show();
                }

    x=limit;
       
       $('.faq-detail:lt('+x+')').show();
       $('#loadMore').click(function () {
           x= (x+limit <= size_li) ? x+limit : size_li;
           $('.faq-detail:lt('+x+')').show();
            if( x== size_li )
           {
              $('#loadMore').hide();
           }
       });
        
   });
</script>   

<div class="col-md-10 col-md-offset-2 content-wraaper admin-wrap">    
  <div class="title dashboard-title">
    <h1>My Questions</h1>
    <div class="title-sep-container">
      <div class="title-sep"></div>   
    </div>
  </div>

  <div class="faq no-faq">
   <?php 
                                //pr($question);

                                foreach($question as $question_detail){ ?>
                                <div class="faq-detail">
                                    <h6><?php echo  $question_detail['Discussion']['question_title']; ?></h6>
                                    <p><?php echo  $question_detail['Discussion']['description']; ?></p>
                                </div>
                                <?php } ?>

                                 <button class="btn btn-orange-small margin-top-small large right " id="loadMore">Load More</button>
  </div>
</div>
