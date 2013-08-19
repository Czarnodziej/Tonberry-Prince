<?php echo $this->Form->create('ContactForm');?>
    <fieldset>
        <legend><?php echo 'Formularz kontaktowy';?></legend>
    <?php
        echo $this->Form->input('name', array('label' => 'Imię:'));
        echo $this->Form->input('email', array('label' => 'E-mail kontaktowy:'));
        echo $this->Form->input('subject', array('label' => 'Temat wiadomości:'));
        echo $this->Form->input('message', array('label' =>'Treść wiadomości:', 'rows'=>15));
     ?>
    </fieldset>
<?php echo $this->Form->submit('Wyślij'); ?>
<?php echo $this->Session->flash();?>
<?php echo $this->Form->end();?>
