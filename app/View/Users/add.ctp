<div class="users form">
  <?php echo $this->Form->create('User'); ?>
  <fieldset>
    <legend><?php echo __('Dodaj użytkownika:'); ?></legend>
    <?php
    echo $this->Form->input('username', array('label' => 'Użytkownik:'));
    echo $this->Form->input('password', array('label' => 'Hasło:'));
    echo $this->Form->input('role', array('label' => 'Rola',
        'options' => array('admin' => 'Administrator', 'author' => 'Autor')
    ));
    ?>
  </fieldset>
<?php echo $this->Form->end(__('Wyślij')); ?>
</div>