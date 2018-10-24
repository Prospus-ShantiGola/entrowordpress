<?php
// $Id: Escene.php

/**
 * @file:
 *   Model to maintain all the post in the system by various user.
 *   author : Arti Sharma
 *   contact : arti.sharma@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */

class Eluminati extends AppModel{
    
/**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'Eluminati';

    public $belongsTo=array(
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id_creator',
            'fields' => 'username',
                    
        )
         
    );


    public $validate  =  array(
            'first_name'=>array(
                'notEmpty'=>array(
                    'rule'=>array('custom', '/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/i'),
                    'message'=>'Alphabets and Numbers only.',
                ),
                'validUserName'=>array(
                    'rule'=>array('preventOnlyNumbers'),
                    'message'=>'Only Numbers not allowed.',
                ),
            ),
          'last_name'=>array(
            'pattern'=>array(
                'rule'=>array('custom', '/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/i'),
                'allowEmpty'=>true,
                'message'=>'Alphabets and Numbers only.',
            ),
            'validUserName'=>array(
                'rule'=>array('preventOnlyNumbers'),
                'message'=>'Only Numbers not allowed.',
            ),
        ),
       'title'=>array(
         'notempty'=>array(
            'rule'=>'notEmpty',
            'message'=>'Please provide title.'

         )),
         'short_description'=>array(
                'rule'=>'notEmpty',
                'message'=>'Please enter description.'
                ),

         
        // 'testimonial'=>array(
        //         'rule'=>'notEmpty',
        //         'message'=>'Please enter testimonial.'
        //         ),


        // 'image_url'=>array(
        //         'rule'=>'notEmpty',
        //         'message'=>'Please provide image.'
        //         ),
        //  'eluminati_badge'=>array(
        //         'rule'=>'notEmpty',
        //         'message'=>'Please provide image.'
        //         ),
        );

	/**
	 * To prevent from input only numbers
	 * @param type $data
	 * @return int
	 */
	public function preventOnlyNumbers($data){
	    $value = array_values($data);
	    $value = $value[0];
	    if(preg_match('|^[0-9]*$|', $value)){
	        return 0;
	    }
	    
	    return 1;
	}
    /**
     *Function to get all eluminate
     */
    public function getAllEluminatiData($start_limit=null,$end_limit=null, $user_name=null){
        
        if($user_name != ''){
            // In case to get data for particular user
            $res = $this->find('all', array('conditions'=>array('Eluminati.first_name'=>$user_name), 'order' => array('Eluminati.id' => 'ASC LIMIT 1' )));
            
        }

        else if($start_limit!='' )
        {
            // $res = $this->find('all', array('order' => array('Eluminati.id' => 'DESC LIMIT '.$start_limit.','.$end_limit.'' )));
            $res = $this->find('all', array('order' => array('Eluminati.id' => 'DESC' )));
        }
        else
        {
             $res = $this->find('all');
        }
       
        return $res;
    }
    public function getEluminatiCountData(){
         $res = $this->find('count');
      
        return $res;
    }
    public function getEluminatiById($eluminati_id)
    {
         $data  = $this->find('first',array('conditions'=>array('Eluminati.id'=>$eluminati_id),'fields'=>array('Eluminati.first_name','Eluminati.last_name')));
      //pr($data);
       return  $data;
    }
}


