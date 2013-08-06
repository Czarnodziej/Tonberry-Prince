<h1>Edytuj posta</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title', array('label' => 'Tytuł'));
echo $this->Form->input('body', array('rows' => '3', 'label' => 'Treść'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Zapisz posta');