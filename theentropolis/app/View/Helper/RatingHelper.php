<?php
App::uses('Helper', 'View');
 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RatingHelper
 *
 * @author ShantiGola
 */
class RatingHelper extends Helper {
    
    
    /**
 * Option return rating for the advice/hindsight
 *
 * @var array
 */
	
	 function getRating($recordID = null) {
		App::import("Model", "Comment");  
		$model = new Comment();  
		$userData = $model->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions'=>array('Comment.advice_id'=>$recordID,'Comment.rating !='=>''))); 
              

      


                if($userData[0]['rating']==''){
                    $userData[0]['rating']="0";
                    
                }
                else{
                    $userData[0]['rating']= number_format($userData[0]['rating'], 1, '.', '');
                }
		return  $userData[0]['rating'];
	}
        
         function getHindsightRating($recordID = null) {
		App::import("Model", "Comment");  
		$model = new Comment();  
		$userData = $model->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions'=>array('Comment.hindsight_id'=>$recordID,'Comment.rating !='=>''))); 
                if($userData[0]['rating']==''){
                    $userData[0]['rating']="0";
                    
                }
                else{
                    $userData[0]['rating']= number_format($userData[0]['rating'], 1, '.', '');
                }
		return  $userData[0]['rating'];
	}

    //  function getRatingAllAdvice($context_role_user_id = null) {
    //     App::import("Model", "Comment");  
    //     $model = new Comment();  

    //       App::import("Model", "Advice");  
    //     $advice = new Advice(); 
    //    //echo "SELECT (sum(rating)/count(*)) as rating FROM `comments` LEFT JOIN advices ON advices.id = comments.advice_id where comments.rating !='' AND advices.context_role_user_id ='$context_role_user_id'";
    //    //die;
    //     $advice->recursive = -1;
    //       //$res = $advice->averageRating($context_role_user_id);
    //       //pr($res);
    //     $avg_rating = '';
    //     $userData = $advice->find('all',array('conditions'=>array('Advice.context_role_user_id'=>$context_role_user_id),'fields'=>array('Advice.id')));
    //      pr($userData);
    //      // die;
    //     $i =0;
    //     foreach($userData as $datas)
    //     {
    //      //  pr($userData);
    //       // pr($data);
    //            echo 'advice'. $advice_id = $datas['Advice']['id'];
    //            echo "<br/>";

    //              echo $rating = $this->getRating($advice_id);

    //            if($avg_rating =='')
    //            {
    //             $avg_rating = $rating;
    //            }
    //            else
    //            {
    //             $avg_rating = $avg_rating + $rating;
    //            }
    //            $i++;
    //            return  $avg_rating;
    //   }

    // }

     function getRatingAllAdvice($context_role_user_id = null) {

        App::import("Model", "Advice");  
        $advice = new Advice(); 
       return $result = $advice->averageRating($context_role_user_id);

     }

    function IndividualCommentCount($obj_id,$obj_type)
    {
        App::import("Model", "Comment");  
        $model = new Comment();  
        return $comment_count = $model->commentCount($obj_id,$obj_type);
    }
    function totalCommentCount($context_role_user_id,$obj_type)
    {
        App::import("Model", "Comment");  
        $model = new Comment();  
       return $total_comment_count = $model->TotalcommentCountData($context_role_user_id,$obj_type);
      
    }
    /**
     * count data either advice /hindsight
     */
    function totalDataCount($context_role_user_id,$obj_type)
    {
        if($obj_type=='Advice')
        {
          App::import("Model", "Advice");  
          $model = new Advice();  
           return $total_comment_count = $model->totalAdviceCount($context_role_user_id);  
        }
        else
        {
            App::import("Model", "DecisionBank");  
            $model = new DecisionBank(); 
             return  $total_comment_count = $model->totalHindsightCount($context_role_user_id); 
            // die;
        }
    }

    function eluminatiRatingCount($eluminati_detail_id)
    {

       App::import("Model", "EluminatiComment");  
            $model = new EluminatiComment(); 
     
         $userData = $model->query("SELECT (sum(eluminati_comments.rating)/count(*)) as rating  FROM `eluminati_comments` WHERE eluminati_comments.rating !='' AND eluminati_comments.eluminati_detail_id ='$eluminati_detail_id'");    

       if($userData[0][0]['rating']==''){
        $userData[0][0]['rating']="0";
       }
                else{
                    $userData[0][0]['rating']= number_format($userData[0][0]['rating'], 1, '.', '');
                }

      return $userData[0][0]['rating'];

    }

    function eluminatiCommentCount($eluminati_detail_id)
    {
             App::import("Model", "EluminatiComment");  
            $model = new EluminatiComment(); 
             return  $total_comment_count = $model->commentCount($eluminati_detail_id); 

    }

    function totalEluminatiRatingCount($eluminati_id)
    {
            App::import("Model", "Eluminati");  
            $model = new EluminatiComment(); 


       
           $avg_rating_val  = $model->query("SELECT (sum(eluminati_comments.rating)/count(*)) as rating FROM `eluminati_comments` LEFT JOIN eluminati_details ON eluminati_details.id = eluminati_comments.eluminati_detail_id LEFT JOIN  eluminatis ON eluminatis.id = eluminati_details.eluminati_id where eluminati_comments.rating !='' AND eluminatis.id ='$eluminati_id'");      
           if($avg_rating_val[0][0]['rating']==''){
                    $avg_rating_val[0][0]['rating']="0";
                    
                }
                else{
                    $avg_rating_val[0][0]['rating']= number_format($avg_rating_val[0][0]['rating'], 1, '.', '');
                }
       
               return$avg_rating_val[0][0]['rating'];

    }
     function eluminatiTotalAverageRating($eluminati_id)
    {
            App::import("Model", "EluminatiDetail");  
            $model = new EluminatiDetail(); 

            
        return $result = $model->averageRating($eluminati_id);

    }
    
    /**
     * To get rating on all hindsight of particular user
     * @param type $context_role_user_id
     * @return type
     */
    function getRatingAllHindsight($context_role_user_id = null) {
        
        App::import("Model", "Comment");  
        $model = new Comment();  
       //echo "SELECT (sum(rating)/count(*)) as rating FROM `comments` LEFT JOIN advices ON advices.id = comments.advice_id where comments.rating !='' AND advices.context_role_user_id ='$context_role_user_id'";
       //die;
        $userData = $model->query("SELECT (sum(rating)/count(*)) as rating FROM `comments` LEFT JOIN hindsights ON hindsights.id = comments.hindsight_id where comments.rating !='' AND hindsights.context_role_user_id ='$context_role_user_id'");      

        if($userData[0][0]['rating']==''){
            $userData[0][0]['rating']="0";           
        }
        else{
            $userData[0][0]['rating']= number_format($userData[0][0]['rating'], 1, '.', '');
        }
        
        return  $userData[0][0]['rating'];
    }


    /**
     * Funtion to calculate the average rating of a user'all hindsight
     */
     function getHindsightAverageRating($context_role_user_id = null) {

        App::import("Model", "DecisionBank");  
        $decisionbank = new DecisionBank(); 
        return $result = $decisionbank->averageRating($context_role_user_id);

     }

     function getCategoryTitle($category_id)
     {
        App::import("Model", "Category");  
        $category = new Category(); 
        return $result = $category->getCategoryById($category_id);
     }

     function UserInfo($id,$type)
     {
        if(strtoupper($type) == strtoupper('eluminati'))
        {
           App::import("Model", "Eluminati");  
           $eluminati = new Eluminati(); 
           return $result = $eluminati->getEluminatiById($id);
        }
        else
        {
          App::import("Model", "ContextRoleUser");  
          $contextroleuser = new ContextRoleUser(); 
          return $result = $contextroleuser->getUserById($id);
        }

     }

	 function getWisdomRating($recordID = null) {
		App::import("Model", "WisdomComment");  
		$model = new WisdomComment();  
		$userData = $model->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions'=>array('WisdomComment.publication_id'=>$recordID,'WisdomComment.rating !='=>''))); 
	    if($userData[0]['rating']==''){
			$userData[0]['rating']="0";
			
		}
		else{
			$userData[0]['rating']= number_format($userData[0]['rating'], 1, '.', '');
		}
		return  $userData[0]['rating'];
	}

	function wisdomUserInfo($id,$type) {
		App::import("Model", "User");  
		$usermodel = new User();  
		$data  = $usermodel->find('first',array('recursive'=>-1,'conditions'=>array('User.id'=>$id),'fields'=>array('User.first_name','User.last_name','User.id')));
       return  $data;
	}
	
	 
}

?>
