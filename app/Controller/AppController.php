<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller','Model','User');
App::import('Lib', 'DebugKit.Toolbar');

/**
 * This is a placeholder class.
 * Create the same file in app/Controller/AppController.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       Cake.Controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {

var $helpers = array('Html', 'Form','Session');	

    public $components = array(
    
        'Session','DebugKit.Toolbar',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'Employees', 'action' => 'Edit'),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
            'authorize' => array( 'Controller' ),  
        'fields'   => array('role'=> 'role'),
    

        )
    );

    public function beforeFilter() {

 $this->Auth->allow('index', 'view', 'login');
    }	
//var $viewClass = 'Haml';
//var $view = 'haml';
}
