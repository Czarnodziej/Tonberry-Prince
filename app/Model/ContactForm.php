<?php
class ContactForm extends ToolsAppModel {
 
    protected $_schema = array(
        'name' => array('type' => 'string' , 'null' => false, 'default' => '', 'length' => '30'),
        'email' => array('type' => 'string' , 'null' => false, 'default' => '', 'length' => '60'),
        'subject' => array('type' => 'string' , 'null' => false, 'default' => '', 'length' => '60'),
        'message' => array('type' => 'text' , 'null' => false, 'default' => ''),
    );
 
    public $useTable = false;
 
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'valErrMandatoryField',
                'last' => true
            )
        ),

    );
}