<?php

class PostsController extends AppController {

  public $helpers = array('Html', 'Form', 'Session');
  public $components = array('Session');

  public function index() {
    $this->set('posts', $this->Post->find('all'));
  }

  public function admin() {
    $this->set('posts', $this->Post->find('all'));
  }

  public function view($id = null) {
    if (!$id) {
      throw new NotFoundException(__('Nieprawidłowy post'));
    }

    $post = $this->Post->findById($id);
    if (!$post) {
      throw new NotFoundException(__('Nieprawidłowy post'));
    }
    $this->set('post', $post);
  }

  public function add() {
    if ($this->request->is('post')) {
      $this->request->data['Post']['user_id'] = $this->Auth->user('id');
      if ($this->Post->save($this->request->data)) {
        $this->Session->setFlash('Post został zapisany.');
        $this->redirect(array('action' => 'admin'));
      } else {
        $this->Session->setFlash('Dodanie posta nie udało się:(');
      }
    }
  }

  public function edit($id = null) {
    if (!$id) {
      throw new NotFoundException(__('Nieprawidłowy post'));
    }

    $post = $this->Post->findById($id);
    if (!$post) {
      throw new NotFoundException(__('Nieprawidłowy post'));
    }

    if ($this->request->is('post') || $this->request->is('put')) {
      $this->Post->id = $id;
      if ($this->Post->save($this->request->data)) {
        $this->Session->setFlash('Twój post został zaktualizowany.');
        $this->redirect(array('action' => 'admin'));
      } else {
        $this->Session->setFlash('Brak możliwości aktualizacji posta.');
      }
    }

    if (!$this->request->data) {
      $this->request->data = $post;
    }
  }

  public function delete($id) {
    if ($this->request->is('get')) {
      throw new MethodNotAllowedException();
    }

    if ($this->Post->delete($id)) {
      $this->Session->setFlash('Post o id: ' . $id . ' został usunięty.');
      $this->redirect(array('action' => 'admin'));
    }
  }

  public function isAuthorized($user) {
    // All registered users can add posts
    if ($this->action === 'add') {
      return true;
    }

    // The owner of a post can edit and delete it
    if (in_array($this->action, array('edit', 'delete'))) {
      $postId = $this->request->params['pass'][0];
      if ($this->Post->isOwnedBy($postId, $user['id'])) {
        return true;
      }
    }

    return parent::isAuthorized($user);
  }

}