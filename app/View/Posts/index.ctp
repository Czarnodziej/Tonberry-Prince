<h2>Posty</h2>
<table>
  <tr>
    <th>Tytuł</th>
    <th>Utworzony</th>
  </tr>
  <!-- Here's where we loop through our $posts array, printing out post info -->
  <?php foreach ((array_reverse($posts)) as $post): ?>
    <tr>
      <td>
        <?php echo $this->Html->link($post['Post']['title'], array('action' => 'view', $post['Post']['id'])); ?>
      </td>
      <td>
        <?php echo $this->time->format('d.m.o G:i:s', $post['Post']['created']); ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>