<h2><?php echo h($post['Post']['title']); ?></h2>
<p><small>Utworzony: <?php echo $post['Post']['modified']; ?></small></p>
<br>
<p><?php echo ($post['Post']['body']); ?></p>
<?php echo $this->Form->create('Comment', array('url' => array('controller' => 'posts', 'action' => 'view', $post['Post']['id']))); ?>
<p style="margin-top:50px;">Komentarze:</p><br>   
<!-- Here's where we loop through our $comment array, printing out post info -->
<?php foreach ($post['Comment'] as $comment): ?>
  <div class="comment">
    <p><?php echo h($comment['name']) ?>:<br>
      <?php echo h($comment['body']) ?></p>
    <br>
  </div>
<?php endforeach; ?>
<!-- add comment   -->
<fieldset>
  <legend><?php __('Add Comment'); ?></legend>
  <?php
  echo $this->Form->input('Comment.name', array('label' => 'Autor komentarza:'));
  echo $this->Form->input('Comment.body', array('label' => 'Treść komentarza:'));
  ?>
</fieldset>
<?php echo $this->Form->end('Zapisz');?>