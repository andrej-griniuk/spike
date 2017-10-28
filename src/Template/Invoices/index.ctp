<?php
/**
 * @var \App\View\AppView $this
 */
?>
<style>
    .navbar-brand img {
        display: none;
    }
</style>
<div class="text-center" id="intro">
    <p style="margin-bottom: 50px;"><?= $this->Html->image('logo_big.png') ?></p>
    <h3 style="margin-bottom: 50px;"><?= __('Logged in as {0}', $this->Auth->user('full_name')) ?></h3>
    <a href="#" class="btn btn-primary btn-lg btn-camera" id="showCamera"><i class="fa fa-camera fa-3x"></i></a>
    <p style="margin-top: 50px;"><?= __('Photograph invoice to spike it') ?></p>
</div>
<div id="scanner" style="display: none">
    <div style="max-width:500px; margin: 0 auto;">
        <div class="camera-wrapper">
            <div id="camera"></div>
        </div>
    </div>
    <a href="#" class="btn btn-primary btn-lg btn-camera" id="takeSnapshot"><i class="fa fa-camera fa-2x"></i></a>
</div>
<?php $this->Html->script('webcam.min.js', ['block' => true]) ?>
<?php $this->append('script'); ?>
<script>
    $('#showCamera').on('click', function(e) {
        e.preventDefault();

        $('#intro').hide();
        $('#scanner').show();

        Webcam.attach('#camera');

        return false;
    })
</script>
<?php $this->end(); ?>

