<?php

class Comment extends AppModel {

  var $name = 'Comment';
  public $validate = array(
      'name' => array(
          'rule' => 'notEmpty'),
      'body' => array(
          'rule' => 'notEmpty'));
}

