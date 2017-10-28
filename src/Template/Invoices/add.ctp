<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<style>
    .navbar-brand img {
        display: none;
    }
</style>
<div class="text-center" id="intro">
    <p style="margin-bottom: 50px;"><?= $this->Html->image('logo_big.png') ?></p>
    <?php if ($user): ?>
        <h3 style="margin-bottom: 50px;"><?= __('Submit invoice for {0}', $user->full_name) ?></h3>
    <?php else: ?>
        <h3 style="margin-bottom: 50px;"><?= __('Logged in as {0}', $this->Auth->user('full_name')) ?></h3>
    <?php endif; ?>
    <a href="#" class="btn btn-primary btn-lg btn-camera" id="showCamera"><i class="fa fa-camera fa-3x"></i></a>
    <p style="margin-top: 50px;"><?= __('Photograph invoice to spike it') ?></p>
</div>
<div id="scanner" style="display: none">
    <div style="max-width:500px; margin: 0 auto;">
        <div class="camera-wrapper">
            <div id="camera"></div>
            <div class="loader"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
        </div>
    </div>
    <a href="#" class="btn btn-primary btn-lg btn-camera" id="takeSnapshot"><i class="fa fa-camera fa-2x"></i></a>
</div>

<?php if (Configure::read('debug')): ?>
    <?= $this->Form->create(null, ['type' => 'file']); ?>
        <?= $this->Form->file('file', ['accept' => 'image/*']) ?>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn-primary']) ?>
    <?= $this->Form->end() ?>
<?php endif; ?>

<?php $this->Html->script('webcam.min.js', ['block' => true]) ?>
<?php $this->append('script'); ?>
<script>
    $('#showCamera').on('click', function(e) {
        e.preventDefault();

        $('#intro').hide();
        $('#scanner').fadeIn();

        <?php if (!Configure::read('debug')): ?>
        Webcam.set('constraints', {
            facingMode: { exact: 'environment' }
        });
        <?php endif; ?>
        Webcam.set('upload_name', 'file');
        Webcam.attach('#camera');

        return false;
    });

    $('#takeSnapshot').on('click', function(e) {
        e.preventDefault();

        $('#scanner').addClass('loading');
        $('#takeSnapshot').hide();

        Webcam.snap(function(data_uri) {
            Webcam.upload(data_uri, '<?= Router::url(['controller' => 'Invoices', 'action' => 'add', $user ? $user->username : null, '_ext' => 'json'], true) ?>', function(code, text) {
                $('#scanner').removeClass('loading');
                $('#takeSnapshot').show();
                var response = JSON.parse(text);

                if (code === 200 && response.success) {
                    window.location.replace('<?= Router::url(['controller' => 'Invoices', 'action' => 'edit'], true) ?>/' + response.invoice.id);
                } else {
                    alert('Something went wrong: ' + text);
                    console.log(text);
                    console.log(response);
                }
                //alert('done!');
                // Upload complete!
                // 'code' will be the HTTP response code from the server, e.g. 200
                // 'text' will be the raw response content
            } );
        });

        return false;
    })
</script>
<?php $this->end(); ?>
