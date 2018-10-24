<?php
class Cityguide extends AppModel{
	public $name = 'Cityguide';
        public $hasMany=array(
         'CityguideVideo' => array(
			'className' => 'CityguideVideo',
			'foreignKey' => 'cityguide_id',
            		
		)
    );

}

?>