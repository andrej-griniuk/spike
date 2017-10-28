<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="alert alert-success box" role="alert" style="display: none"><i class="fa fa-check"></i> <?= __('Invoice image filed to Spike Cloud') ?></div>
<div class="alert alert-success box" role="alert" style="display: none"><i class="fa fa-check"></i> <?= __('Posted payable to Xero') ?></div>
<div class="alert alert-success box" role="alert" style="display: none"><i class="fa fa-check"></i> <?= __('NAB Payment request setup') ?></div>
<div class="text-center box" style="display: none">
    <?= $this->Html->link(__('Next Invoice'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link(__('Close'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
</div>
<?php $this->append('script'); ?>
<script>
    $(function(){
        $('.box').each(function(index) {
            $(this).delay(1000*index).fadeIn(1000);
        });
    });
</script>
<?php $this->end(); ?>
