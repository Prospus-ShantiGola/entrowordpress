<?php
/*
* Model Name: Video
*/
class Video extends AppModel {
    
    public $name = 'Video';
    
    public $validate = array(
                'title' => array(
                    'notEmpty' => array(
                        'rule'=> 'notEmpty',
                        'message' => 'Please Provide Title.'),
                    ),
                'url' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty', 
                        'message' => 'Please Provide Url.'
                    ),
                ),
                'files[]' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Something went wrong with the file upload',
                        
			        ),
                ),
              );

}

?>


