<?php
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');
App::uses('Day', 'Vendor');
App::uses('MyEmployee', 'Vendor');
App::uses('Punch', 'Vendor');
App::uses('Employee', 'Model');
App::uses('TimeClock', 'Model');
App::uses('EditSupplemental', 'Model');
App::uses('EmployeesController', 'Controller');

class UsersController extends AppController {

 public $scaffold = true;
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    
public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('add'); // Letting users register themselves
}

public function login() {

    if ($this->request->is('post')) {

        if ($this->Auth->login($this->params['data'])) {

        $my_user = $this->User->find("first",array('conditions' => array('username' => $this->params['data']['User']['username'])));

        $temp = New Employee;
        $session_employee = New MyEmployee( $temp->find("first",array('conditions' => array('Employee.id' => $my_user['User']['employee_id']))));
        $this->Session->write('current_user', $session_employee);
        $this->redirect($this->Auth->redirect());
        } else {
           //debug ( $this->Auth );

            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }
}

public function logout() {
    $this->redirect($this->Auth->logout());
}
    
 public function isAuthorized()
 {
    
    return true;
 }    
}
?>