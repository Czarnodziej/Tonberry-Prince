<?php

class UsersController extends AppController {

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('add');
     $this->Auth->authError = __('Dostęp tylko dla zalogowanych.');
  }

  public function login() {
    if ($this->request->is('post')) {
      if ($this->Auth->login()) {
        $this->redirect($this->Auth->redirect());
      } else {
        $this->Session->setFlash(__('Niewłaściwa nazwa użytkownika lub hasło, spróbuj ponownie.'));
      }
    }
  }

  public function logout() {
    $this->redirect($this->Auth->logout());
  }

  public function index() {
    $this->User->recursive = 0;
    $this->set('users', $this->paginate());
  }

  public function view($id = null) {
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Niewłaściwy użytkownik.'));
    }
    $this->set('user', $this->User->read(null, $id));
  }

  public function add() {
    if ($this->request->is('post')) {
      $this->User->create();
      if ($this->User->save($this->request->data)) {
        $this->Session->setFlash(__('Użytkownik został zapisany.'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('Użytkownik nie został zapisany. Spróbuj ponownie.'));
      }
    }
  }

  public function edit($id = null) {
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Invalid user'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->User->save($this->request->data)) {
        $this->Session->setFlash(__('Użytkownik został zapisany.'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('Użytkownik nie został zapisany. Spróbuj ponownie.'));
      }
    } else {
      $this->request->data = $this->User->read(null, $id);
      unset($this->request->data['User']['password']);
    }
  }

  public function delete($id = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Niewłaściwy użytkownik.'));
    }
    if ($this->User->delete()) {
      $this->Session->setFlash(__('Użytkownik został usunięty.'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Użytkownik nie został usunięty.'));
    $this->redirect(array('action' => 'index'));
  }

}

?>
