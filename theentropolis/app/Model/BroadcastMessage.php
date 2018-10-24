<?php

App::uses('AppModel', 'Model');

/**
 * BroadcastMessage Model
 *
 * @property User $User
 */
class BroadcastMessage extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'broadcast_messages';

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
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter title',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'message' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter broadcast message',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'role_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => 'Please select any role',
                
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'added_by' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'added_on' => array(
            'datetime' => array(
                'rule' => array('datetime'),
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
     * hasOne associations
     *
     * @var array
     */
    public $hasOne = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => false,
            'conditions' => 'User.id = BroadcastMessage.added_by',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'BroadcastMessageView' => array(
            'className' => 'BroadcastMessageView',
            'foreignKey' => 'broadcast_message_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );


public function getAllBroadcast(){
    $broadcast = $this->find('all',array('limit' => 10, 'order' => 'BroadcastMessage.added_on DESC'));//array('conditions' => array('limit' => 10, 'order' => 'broadcast_messages.id DESC'))

        return $broadcast;
}
public function getAllBroadcastCount(){
    $broadcast = $this->find('count');//array('conditions' => array('limit' => 10, 'order' => 'broadcast_messages.id DESC'))

        return $broadcast;
}

}