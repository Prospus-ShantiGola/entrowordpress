<?php


class Discussion extends AppModel{
	public $name = 'Discussion';

	public $validate = array(
		'question_title'=>array(
			 'notempty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please provide title for question.'
			 )),	

		'description'=>array(
				'notempty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please provide description.'
			 ),
		),

		'category_id'=>array(
            'required'=>array(
                'rule'=>array('notEmpty'),
                'message'=>'Select decision type.',
            ),
        ),
		'sub_category_id'=>array(
            'required'=>array(
                'rule'=>array('notEmpty'),
                'message'=>'Select category.',
            ),
        ),
        );
         
         public $belongsTo = array(
		'DecisionType' => array(
			'className' => 'DecisionType',
			'foreignKey' => 'category_id'
			
		),
        'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'sub_category_id'
			
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id_creator'
			
		),
       
      );
}