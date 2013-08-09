<?php

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {

  public $validate = array(
      'username' => array(
          'required' => array(
              'rule' => array('notEmpty'),
              'message' => 'Nazwa użytkownika jest wymagana'
          )
      ),
      'password' => array(
          'required' => array(
              'rule' => array('notEmpty'),
              'message' => 'Hasło jest wymagane'
          )
      ),
      'role' => array(
          'valid' => array(
              'rule' => array('inList', array('admin', 'author')),
              'message' => 'Wybierz właściwą rolę',
              'allowEmpty' => false
          )
      )
  );

  public function beforeSave($options = array()) {
    if (isset($this->data[$this->alias]['password'])) {
      $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }
    return true;
  }

}

?>