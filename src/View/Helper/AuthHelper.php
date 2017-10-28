<?php
namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Auth helper
 */
class AuthHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function user($key = null)
    {
        if ($key) {
            $key = '.' . $key;
        }

        return $this->request->getSession()->read("Auth.User{$key}");
    }

}
