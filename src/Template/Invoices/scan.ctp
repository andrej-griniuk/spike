<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?= $this->Form->create(null, ['type' => 'file']); ?>
    <?= $this->Form->file('image', ['accept' => 'image/*']) ?>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-primary']) ?>
<?= $this->Form->end() ?>
<?php if (isset($name)): ?>
    <?= $this->Html->image($name) ?>
<?php endif; ?>
<?php
/*
<?= $this->Html->script('webcam.min.js') ?>

<div id="my_camera" style="width:320px; height:240px;"></div>
<div id="my_result"></div>

<script language="JavaScript">
    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>

<a href="javascript:void(take_snapshot())">Take Snapshot</a>

*/
