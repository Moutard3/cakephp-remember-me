<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;

/**
 * Test suite bootstrap for RememberMe.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */
$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception("Cannot find the root of the application, unable to run tests");
};
$root = $findRoot(__FILE__);
unset($findRoot);

chdir($root);
if (file_exists($root . '/config/bootstrap.php')) {
    require $root . '/config/bootstrap.php';
} else {
    require $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';

    // Disable deprecations for now when using 3.6
    if (version_compare(Configure::version(), '3.6.0', '>=')) {
        error_reporting(E_ALL ^ E_USER_DEPRECATED);
    }

    Plugin::getCollection()->add(new \RememberMe\Plugin(['path' => dirname(dirname(__FILE__)) . DS]));
    Plugin::getCollection()->add(new \Authentication\Plugin(['path' => dirname(dirname(__FILE__)) . DS]));

    error_reporting(E_ALL);
}
