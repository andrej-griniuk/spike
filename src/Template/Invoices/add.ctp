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
    <p style="margin-top: 50px;"><a href="#" data-toggle="modal" data-target="#myModal"><?= __('Photograph invoice to spike it') ?></a></p>
</div>
<div id="scanner" style="display: none">
    <div style="max-width:500px; margin: 0 auto;">
        <div class="camera-wrapper">
            <div id="camera"></div>
            <a href="#" id="closeCamera"><i class="fa fa-times fa-2x"></i></a>
            <div class="loader"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
        </div>
    </div>
    <a href="#" class="btn btn-primary btn-lg btn-camera" id="takeSnapshot"><i class="fa fa-camera fa-2x"></i></a>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['type' => 'file']); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= __('Upload Invoice') ?></h4>
                </div>
                <div class="modal-body">
                    <?= $this->Form->file('file', ['accept' => 'image/*']) ?>
                </div>
                <div class="modal-footer">
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn-primary']) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php if (Configure::read('debug')): ?>
<?php endif; ?>

<?php $this->Html->script('webcam.min.js', ['block' => true]) ?>
<?php $this->append('script'); ?>
<script>
    $('#closeCamera').on('click', function(e) {
        e.preventDefault();

        Webcam.reset();
        $('#scanner').hide();
        $('#intro').fadeIn();

        return false;
    });

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
    });
</script>
<?php $this->end(); ?>
