<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use BootstrapUI\View\UIViewTrait;
use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @property \App\View\Helper\AuthHelper $Auth
 * @property \Burzum\FileStorage\View\Helper\ImageHelper $Image
 * @link https://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{
    use UIViewTrait;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        $this->initializeUI(['layout' => false]);

        $this->loadHelper('Auth');
        $this->loadHelper('Burzum/FileStorage.Image');

        $this->Form->setTemplates([
            'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
            //'error' => '<div class="alert alert-danger">{{content}}</div>',
            //'inputContainer' => '<div class="form-control">{{content}}</div>',
        ]);

        $this->Form->addWidget('datetime', ['App\View\Widget\DateTimeWidget', 'select']);
    }
}
