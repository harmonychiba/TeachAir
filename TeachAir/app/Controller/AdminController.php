<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author harmonychiba
 */
class AdminController extends AppController {

    public
            $uses = Array('User','Classroom','Participation'),
            $components = Array(
                'Session',
                'Auth' => Array(
                    'loginRedirect' => Array('controller' => 'admin', 'action' => 'index'),
                    'logoutRedirect' => Array('controller' => 'admin', 'action' => 'login'),
                    'loginAction' => Array('controller' => 'admin', 'action' => 'login'),
                    'authenticate' => Array('Form' => Array('fields' => Array('username' => 'email')))
                )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        //$this->layout = 'admin';
        $this->Auth->allow('add', 'login');
    }

    public function index() {
        $this->set('title_for_layout', 'ダッシュボード | 管理画面');
        $login_id = $this->Auth->user('id');
        $login_user = $this->User->find('first',array('conditions' => array('id'=>$login_id)));
        $this->set('login_user',$login_user);        
        $holdings = $this->Classroom->find("all",array("conditions"=>array("created_by"=>intval($this->Auth->user("id")))));
        $participatings = $this->Participation->find("all",array("conditions"=>array("user_id"=>intval($this->Auth->user("id")))));
        $participating_classes = array();
        foreach($participatings as $participating){
            $participating_class = $this->Classroom->find("first",array("conditions"=>array("id"=>intval($participating["Participation"]["class_id"]))));
            if($participating_class){
                array_push($participating_classes, $participating_class);
            }
        }
        $this->set("participating_classes",$participating_classes);
        $this->set("holdings",$holdings);
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
            }
        }
    }

    public function logout($id = null) {
        $this->redirect($this->Auth->logout());
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

    public function edit() {
        if ($this->request->is('post')) {
            $this->User->read(null, intval($this->Auth->user("id")));
            $this->User->set($this->request->data);
            if ($this->User->save()) {
                $this->Session->setFlash(__('The user has been saved'));
                unset($user['User']['password']); // 念のためパスワードは除外。どうでもよければ消してもOK
                $this->Session->write('Auth', $user);
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}

?>
