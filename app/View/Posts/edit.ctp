<h2>Edytuj posta</h2>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title', array('label' => 'Tytuł'));
echo $this->Form->input('body', array('rows' => '3', 'label' => 'Treść'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Zapisz posta');
?>
  <?php $this->start('bottom_scripts'); ?>

<?php echo $this->Html->script('vendor/tinymce/tinymce.min.js'); ?>

<script>
 tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen emmet",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
<?php $this->end(); ?>