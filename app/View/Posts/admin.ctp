<h2>Posty</h2>
<p>
  <?php echo $this->Html->link("Dodaj nowy post", array('action' => 'add')); ?>

</p>
<table>
  <tr>
    <th>Id</th>
    <th>Tytuł</th>
    <th>Akcja</th>
    <th>Utworzony</th>
    <th>Zmodyfikowany</th>
  </tr>

  <!-- Here's where we loop through our $posts array, printing out post info -->

  <?php foreach ($posts as $post): ?>

    <tr>
      <td><?php echo $post['Post']['id']; ?>

      </td>
      <td>
        <?php echo $this->Html->link($post['Post']['title'], array('action' => 'view', $post['Post']['id'])); ?>

      </td>
      <td>
        <?php
        echo $this->Form->postLink(
                'Usuń', array('action' => 'delete', $post['Post']['id']), array('confirm' => 'Ale czy na pewno?'));
        ?>
        <?php echo $this->Html->link('Edytuj', array('action' => 'edit', $post['Post']['id'])); ?>

      </td>
      <td>
        <?php echo $post['Post']['created']; ?>

      </td>
      <td>
        <?php echo $post['Post']['modified']; ?>

      </td>
    </tr>
  <?php endforeach; ?>

</table>