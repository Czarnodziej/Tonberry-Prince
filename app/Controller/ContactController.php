<?php

class ContactController extends AppController {

  public $uses = array('Tools.ContactForm');

  public function index() {
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->ContactForm->validates()) {
        $name = $this->request->data['ContactForm']['name'];
        $email = $this->request->data['ContactForm']['email'];
        $subject = $this->request->data['ContactForm']['subject'];
        $message = $this->request->data['ContactForm']['message'];

        // send email with CakeEmail
        $Email = new CakeEmail();
        $Email->config('smtp');
       // $Email->sender($name); to be used in eemail template
        $Email->from($email);
        $Email->to('pagodemc@gmail.com'); //my email address
        $Email->subject($subject);
        $Email->send($message);
        $this->Session->setFlash('Wiadomość wysłana pomyślnie:)');
      } else {
        $this->Session->setFlash('Wysyłanie wiadomości zakończone niepowodzeniem:(');
      }
    }
    $this->helpers = array_merge($this->helpers, array('Tools.Captcha'));
  }

}