<?php

class KidBusinessProfile extends AppModel {

    public $name = 'KidBusinessProfile';
    public $useTable = 'kid_business_profiles';

        public $validate = array(
            
        'founded_year' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'This field is required',
            )),
        'business_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'This field is required',
            )),
        'start_up' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'This field is required',
            ),'pattern' => array(
                'rule' => '/^$|^[0-9 ]+$/i',
                'message' => 'Only digits allowed',
            ),),
        
        'about_business' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'This field is required',
            )),
        'mission' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'This field is required',
            )),
        'vision_goal' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'This field is required',
            )),
        'revenue' => array(
            'notempty' => array(
                'rule' => array('notempty'), 
                'message' => 'This field is required',
            )),
             'donated' => array(
            'notempty' => array(
                'rule' => array('notempty'), 
                'message' => 'This field is required',
            )),
             'feature_benefit' => array(
            'notempty' => array(
                'rule' => array('notempty'), 
                'message' => 'This field is required',
            )),
             'business_website' => array(
//            'notempty' => array(
//                'rule' => array('notempty'), 
//                'message' => 'This field is required',
//            ),
             'validUrl'=>array(
                     'required' => false,
                     'allowEmpty' => true, 
                     //'rule'=>array('custom', '@^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]*$@i'),
                    //'rule' => array('url', true), 
                     'rule'=>array('custom','/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/'),
                     'message'=>'Please enter valid url',
                )
            
            ),
               'product_image' => array(
            'notempty' => array(
                'rule' => array('notempty'), 
                'message' => 'Please provide image',
            )
            ),
             'logo_image' => array(
            'notempty' => array(
                'rule' => array('notempty'), 
                'message' => 'Please provide image',
            )

            ),
              'pitch_video_id' => array(
//            'notempty' => array(
//                'rule' => array('notempty'), 
//                'message' => 'Please upload business pitch video',
//            )

            )
            
      
        );

  public $belongsTo=array(
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
                    
        )
    );
   public $hasMany = array(
        'KidBusinessOwner' => array(
            'className' => 'KidBusinessOwner',
            'foreignKey' => 'kid_business_profile_id'
        ),
        'KidProductGallery' => array(
            'className' => 'KidProductGallery',
            'foreignKey' => 'kid_business_profile_id'
        )

        );

    public function businessProfileExist($user_id)
    {
        //  $this->recursive = -1;
        $res = $this->find('first', array('conditions' => array('KidBusinessProfile.user_id' => $user_id)));
        return $res;
    }
    public function businessProfileCount($user_id)
    {
        //  $this->recursive = -1;
        $res = $this->find('count', array('conditions' => array('KidBusinessProfile.user_id' => $user_id)));
        return $res;
    }   
    public function getAllBusinessProfile($user_id)
    {
        //  $this->recursive = -1;
        $res = $this->find('all', array('conditions' => array('KidBusinessProfile.user_id' => $user_id)));
        return $res;
    }

    public function getPublishedBusinessProfile($user_id)
    {
        //  $this->recursive = -1;
        $res = $this->find('all', array('conditions' => array('KidBusinessProfile.user_id' => $user_id,'status'=>'save')));
        return $res;
    }
     public function getPublishedBusinessProfileCount($user_id)
    {
        //  $this->recursive = -1;
        $res = $this->find('count', array('conditions' => array('KidBusinessProfile.user_id' => $user_id,'status'=>'save')));
        return $res;
    } 
    public function getAllBusinessProfileData($user_id,$excluded_id =null)
    {
        $this->recursive = -1;
        $res = $this->find('all', array('conditions' => array('KidBusinessProfile.user_id' => $user_id,'KidBusinessProfile.id !='=>$excluded_id),'fields'=>array('KidBusinessProfile.id','KidBusinessProfile.user_id')));
        return $res;
    }  

}

?>