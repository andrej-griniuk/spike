<?php
namespace App\Controller;

/**
 * Index Controller
 *
 */
class IndexController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow();
    }

    public function index()
    {

    }
}
