<?php
// $Id: EsceneDetail.php

/**
 * @file:
 *   Model to maintain all the eluminatis Detail.
 *   author : Afroj Alam
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

class EluminatiDetail extends AppModel{
    
/**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'EluminatiDetail';
    public $belongsTo = array(
     'Category' => array(
         'className'    => 'Category',
         'foreignKey'    => 'category_id'
      ),
      'DecisionType' => array(
         'className'    => 'DecisionType',
         'foreignKey'    => 'decision_type_id'
      ));


    public function averageRating($eluminati_id)
    {
       
        $avg_rating = '';
        $this->recursive = -1;
        $result = $this->find('all',array('conditions'=>array('EluminatiDetail.eluminati_id'=>$eluminati_id),'fields'=>array('EluminatiDetail.id')));
        foreach ($result as  $value){
        $advice_id = $value['EluminatiDetail']['id'];

        $this->setSource('eluminati_comments');
        //$this->find('all');

        $userData = $this->find('first', array('recursive' => -1, 'fields' => array('(sum(rating)/count(*)) as rating'), 'conditions'=>array('eluminati_detail_id '=>$advice_id,'rating !='=>''))); 
                    if($userData[0]['rating']==''){
                    $userData[0]['rating']="0";
                    
                }
                else{
                    $userData[0]['rating']= number_format($userData[0]['rating'], 1, '.', '');
                }
      
                 if($avg_rating =='')
                 {
                  $avg_rating = $userData[0]['rating'];
                 }
                 else
                 {
                  $avg_rating = $avg_rating + $userData[0]['rating'];
                 }

       
       }
     
       $this->setSource('eluminati_details');

      $count = $this->find('count',array('conditions'=>array('EluminatiDetail.eluminati_id'=>$eluminati_id)));
      $avg_rating = $avg_rating/$count;
      

       return   number_format($avg_rating , 1, '.', '');
    }

    public function TotalEluminatiDetail()
    {
      $res = $this->find('count');
      if($res)
      {
        return $res;
      }
      else
      {
        return 0;
      }
       
       
    }

    public function eluminatiDetailById($eluminati_detail_id)
    {
     // echo $eluminati_detail_id;
    //  die("fsf");
      $res = $this->find('first',array('conditions'=>array('EluminatiDetail.id'=>$eluminati_detail_id)));
      if($res)
      {
        return $res;
      }
      else
      {
        return 0;
      }
    }
    function getEluminatiDetailByEluminatiId($eluminati_id)
    {
        $this->recursive =-1;
        $res =  $this->find('first',array('conditions'=>array('EluminatiDetail.eluminati_id'=>$eluminati_id),'fields'=>array('id')));
        return $res ;
    }
    
}


