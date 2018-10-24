<?php
class Pipeline extends AppModel{
    public $name = 'Pipeline';
    public $belongsTo = array(
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country'
		),
      );
 }
