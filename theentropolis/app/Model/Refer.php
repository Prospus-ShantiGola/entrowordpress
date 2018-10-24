<?php



/**
 * Description of Refer
 *
 * @author arti sharma
 */
class Refer extends AppModel{  

/* Model name
 *
 * @var string
 * @access public
 */
    public $name = 'Refer';
    public $useTable = 'citizen_reference';
    public $validate  =  array(
            'email_address'=>array(
                'email' => array(
                    'rule' => array('custom','/^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$/i'),
                    'message' => 'Please enter a valid email address.',
                 ),
                'exist_mail' => array(
                     'rule'=>array('alreadyExist'),
                    'message' => 'Email address already exists.',
                ),
                'validEmail'=>array(
                    'rule'=>array('validateEmail'),
                    'message'=>'Please enter a valid email address.',
                ),
                 'isUnique' => array(
                    'rule' => 'isUnique',
                    'message' => 'Request already sent to this citizen.',
                ),
            ),
            );
            /**
         * To validate email 
         * @param type $data
         * @return int
         */
        public function validateEmail($data){
            $value = array_values($data);
            $value = $value[0];
            
            $values = explode('@', $value);
                       
            if($values[0][0] == '.'){
                // leading dot in address should not allow
                return 0;
            }    
            // trailing dot in address should not allow
            $lenbeforAtr = strlen($values[0])-1;
            if($values[0][$lenbeforAtr] == '.'){
                return 0;
            }
            // leading das infront of domain should not allow
            if($values[1][0] == '-'){
                return 0;
            }
            // only numeric value should not allow in email            
            if(preg_match('|^[0-9]*$|', $values[0])){
               // return 0;
            }
            
            return 1;
        }

        public function alreadyExist($data=null)
        {
            $email_address = $data['email_address'] ;
           App::import("Model", "User");
           $user_obj = new User();
           if($email_address!='' &&  $email_address ='NULL')
           {
             
              $result = $user_obj->find('count',array('conditions'=>array('User.email_address'=>$data['email_address'])));
        
              if(empty($result))
              {
                return 1;
              }
              else
              {
                return 0;
              }
             
           }
        }

        
}
