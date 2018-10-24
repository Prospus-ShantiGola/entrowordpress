<?php

App::uses('AppModel', 'Model');

/**
 * TourVideo Model
 *
 * @property Tag $Tag
 */
class TourVideo extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'tag_id' => array(
            'Numeric' => array(
                'rule' => 'numeric',
                'message' => 'Select an option to tag'
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter a title',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'rule1' => array(
                'rule' => '/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/i',
                'message' => 'Only letters and integers, min 3 characters'
            )
        ),


        
        'video_url' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter a video URL',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'rule2' => array('rule'=>'url','required'=>false, 
             'message'=>'Please enter a valid URL') 
            
        ),
                         
        // 'video_url' => array(
        //     'notEmpty' => array(
        //         'rule' => array('notEmpty'),
        //         'message' => 'Please fill video url',
        //     //'allowEmpty' => false,
        //     //'required' => false,
        //     //'last' => false, // Stop validation after this rule
        //     //'on' => 'create', // Limit validation to 'create' or 'update' operations
        //     ),
        // ),
        'timestamp' => array(
            'datetime' => array(
                'rule' => array('datetime'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'created_by' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Tag' => array(
            'className' => 'Tag',
            'foreignKey' => 'tag_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'blog_id'
    ));
    
}
