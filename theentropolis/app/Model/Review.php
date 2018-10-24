<?php

class Review extends AppModel{
    
  /**
 * Model name
 *
 * @var string
 * @access public
 */
public $name = 'Review';

	public function getTotalReviewed($user_id,$obj_type,$start_date=null,$end_date=null)
	{

		if($start_date)
		{
			$published_count = $this->find('count',array('conditions'=>array('Review.view_date >='=>$start_date,'Review.view_date <='=>$end_date,'Review.user_id'=>$user_id,'obj_type'=>$obj_type)));
		}
		else
		{

			$published_count = $this->find('count',array('conditions'=>array('Review.user_id'=>$user_id,'obj_type'=>$obj_type)));
		}
		 
		 return $published_count;
	}

    
}