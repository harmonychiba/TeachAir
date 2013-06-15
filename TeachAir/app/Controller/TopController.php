<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TopController
 *
 * @author harmonychiba
 */
class TopController extends AppController {

    //put your code here
    public
            $uses = Array('User','Classroom','Participation'),
            $components = Array(
                'Session',
                'Auth' => Array(
                    'loginRedirect' => Array('controller' => 'admin', 'action' => 'index'),
                    'logoutRedirect' => Array('controller' => 'admin', 'action' => 'login'),
                    'loginAction' => Array('controller' => 'admin', 'action' => 'login'),
                    'authenticate' => Array('Form' => Array('fields' => Array('username' => 'email')))
                ));

    public function index() {
        //commons
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
        
        
        $this->loadModel("Classroom");
        $recent_classrooms = $this->Classroom->find("all", array("order" => array('created_at DESC')));
        $this->set("recent_classrooms", $recent_classrooms);
        
        $holders = array();
        foreach ($recent_classrooms as $classroom){
            $holder = $this->User->find("first",array("conditions"=>array("id"=>intval(h($classroom["Classroom"]["created_by"])))));
            array_push($holders, $holder);
        }
        $this->set("holders",$holders);
    }
    public function host(){
        //commons
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
}

?>
