<?php
/**
	* Component for Generating Captcha in CakePHP 2.x
	* PHP versions 5.2.8
	* @author     Dave
	* @link       http://deliciouscakephp.com/
	* @version 0.0.2
	* @license   GPL (www.gnu.org/licenses/gpl.html)
	*   - Initial release
	*/
App::uses('Component', 'Controller');

class CommonComponent extends Component{
    
    public function getDecisionTypeBasedOnRole($decision_types){
        
        //Check if the user is Admin from Session
        $isAdmin   = CakeSession::read('isAdmin');              //$this->Session->read("isAdmin");
        
        //Get user role context id from the session
        $contextId = CakeSession::read('context_role_user_id'); //$this->Session->read("context_role_user_id");

        //Initialise User Model
        $model = ClassRegistry::init('User');                   //$this->User->getRoleByContextId
        
        $rolearr = $model->getRoleByContextId($contextId);

        if($isAdmin != 1 && count($rolearr) > 0){
            if((strtolower($rolearr['roles']) != 'kidpreneurs' && strtolower($rolearr['roles']) != 'parents')){
                if(($key = array_search('Club Kidpreneur Library', $decision_types)) !== false) {
                    unset($decision_types[$key]);
                }
            }
        }
        return $decision_types; 
    }
    
    
    public function getNewDecisionTypeInSequence($decision_types){
         $new = array();
         $other = array();
         $newcategoryArray = array(18,19,20,21,22,23,24,25,26);
         
         foreach ($decision_types as $id => $name) {
            if (in_array($id,$newcategoryArray) !== false || empty($id)) { // this might also depend on the IDs, or how you determine if a country is popular or not
                $new[$id] = $name;
            } else {
                $other[$id] = $name;
            }
         }
         $options = array(
                $new,
            '==========================' => $other
         ); 
         return $options;
    }
    
}