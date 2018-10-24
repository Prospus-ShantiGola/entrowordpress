<?php

class CityguideVideo extends AppModel{

    public $name = 'CityguideVideo';
    public $useTable = 'cityguide_videos';
    public $belongsTo=array(
         'Cityguide' => array(
			'className' => 'Cityguide',
			'foreignKey' => 'cityguide_id',
            		
		)
    );

}