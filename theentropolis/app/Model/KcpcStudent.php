<?php

class KcpcStudent extends AppModel{

    public $name = 'KcpcStudent';


public $belongsTo=array(
         'PitchCompetitionEntryForm' => array(
			'className' => 'PitchCompetitionEntryForm',
			'foreignKey' => 'pitch_competition_entry_form_id',
            		
		)
    );

/**
 * Function to get user info 
 */
//public function getUserInfo($user_id)
//{	
//	return $res = $this->find('first',array('conditions'=>array('UserProfile.user_id'=>$user_id)));
//
//}

// public function getUserCountryName($country_id){
	
// 	$this->setSource('countries');
// 	return $countryName = $this->find('first',array('conditions'=>array('Country.id'=>$country_id),'fields'=>array('country_title')));
// 	//$this->setSource('user_profiles');
// }
}