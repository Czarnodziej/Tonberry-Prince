<h1>Napisz posta</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title', array('label' => 'Tytuł'));
echo $this->Form->input('body', array('rows' => '3', 'label' => 'Treść'));
echo $this->Form->end('Zapisz posta');
?>
<script type="text/javascript">
tinymce.init({
    selector: "#PostBody"
 });
</script>