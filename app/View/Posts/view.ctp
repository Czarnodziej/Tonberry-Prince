<h2><?php echo h($post['Post']['title']); ?></h2>
<p>Utworzony: <?php echo $this->time->format('d.m.o G:i:s', $post['Post']['created']); ?></p>
<br>
<p><?php echo ($post['Post']['body']); ?></p>
<?php echo $this->Form->create('Comment', array('url' => array('controller' => 'posts', 'action' => 'view', $post['Post']['id']))); ?>
<p style="margin-top:50px;">Komentarze:</p><br>   
<!-- Here's where we loop through our $comment array, printing out post info -->
<?php
$newCommentOnTop = array_reverse( $post['Comment'] );
foreach ($newCommentOnTop as $comment): ?>
  <div class="comment">
    <p><?php echo h($comment['name']) ?>:<br>
      <?php echo h($comment['body']) ?><br>
    <span style="font-size: 0.7em">Napisane dnia: <?php echo $this->time->format('d.m.o G:i:s', $comment['created']); ?></span>
    </p>
    <br>
  </div>
<?php endforeach; ?>
<!-- add comment   -->
<hr>
<fieldset>
  <legend><?php __('Add Comment'); ?></legend>
  <?php
  echo $this->Form->input('Comment.name', array('label' => 'Autor komentarza:'));
  echo $this->Form->input('Comment.body', array('label' => 'Treść komentarza:'));
  ?>
</fieldset>
<?php echo $this->Form->end('Wyślij komentarz');?>