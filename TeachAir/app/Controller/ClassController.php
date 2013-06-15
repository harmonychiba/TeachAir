<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassController
 *
 * @author harmonychiba
 */
class ClassController extends AppController {

    //put your code here
    public
            $uses = Array('User', 'Classroom', 'Category', 'Belonging', 'Participation','Conversation'),
            $components = Array(
                'Session',
                'Auth' => Array(
                    'loginRedirect' => Array('controller' => 'admin', 'action' => 'index'),
                    'logoutRedirect' => Array('controller' => 'admin', 'action' => 'login'),
                    'loginAction' => Array('controller' => 'admin', 'action' => 'login'),
                    'authenticate' => Array('Form' => Array('fields' => Array('username' => 'email')))
    ));

    public function entry() {
        $this->autoLayout = false;
        $this->autoRender = false;
        $new_class = $this->request->data["Classroom"];
        $current_time = date('c');
        $this->Classroom->create();

        $data = array('Classroom' => array("name" => $new_class["name"],
                "description" => $new_class["description"],
                "ustream_id" => intval($new_class["ustreamID"]),
                "created_at" => $current_time,
                "created_by" => intval($this->Auth->user("id")),
                'status' => 1));
        $fields = array('name', 'description', 'ustream_id', 'created_at', 'created_by', 'status');
        $new_classroom = $this->Classroom->save($data, false, $fields);
        if ($new_classroom) {
            $this->Session->setFlash(__('The classroom has been saved'));

            $category_names = split(",", $new_class["categories"]);
            foreach ($category_names as $category_name) {
                $category = $this->Category->find("first", array("conditions" => array("name" => $category_name)));
                if ($category) {
                    $this->Belonging->create();
                    $data = array("Belonging" => array("category_id" => intval(h($category["Category"]["id"])),
                            "classroom_id" => h($new_classroom["Classroom"]["id"]),
                            "status" => 1));
                    $fields = array("category_id", "classroom_id", "status");
                    $new_belonging = $this->Belonging->save($data, false, $fields);
                    if ($new_belonging) {
                        $this->Session->setFlash(__("The belonging has been saved"));
                    } else {
                        $this->Session->setFlash(__("The belonging could not be saved. Please, try again."));
                    }
                } else {
                    $this->Category->create();
                    $data = array("Category" => array("name" => $category_name, "status" => 1));
                    $fields = array("name", "status");

                    $category = $this->Category->save($data, false, $fields);
                    if ($category) {
                        $this->Session->setFlash(__("New category has been saved"));
                        $this->Belonging->create();
                        $data = array("Belonging" => array("category_id" => intval(h($category["Category"]["id"])),
                                "classroom_id" => h($new_classroom["Classroom"]["id"]),
                                "status" => 1));
                        $fields = array("category_id", "classroom_id", "status");
                        $new_belonging = $this->Belonging->save($data, false, $fields);
                        if ($new_belonging) {
                            $this->Session->setFlash(__("The belonging has been saved"));
                        } else {
                            $this->Session->setFlash(__("The belonging could not be saved. Please, try again."));
                        }
                    }
                }
            }

            $this->redirect(array('controller' => 'top', "action" => "index"));
        } else {
            $this->Session->setFlash(__('The classroom could not be saved. Please, try again.'));
            $this->redirect(array("controller" => "top", "action" => "host"));
        }
    }

    public function visit() {
        $login_id = $this->Auth->user('id');
        $login_user = $this->User->find('first', array('conditions' => array('id' => $login_id)));
        $this->set('login_user', $login_user);
        $holdings = $this->Classroom->find("all", array("conditions" => array("created_by" => intval($this->Auth->user("id")))));
        $participatings = $this->Participation->find("all", array("conditions" => array("user_id" => intval($this->Auth->user("id")))));
        $participating_classes = array();
        foreach ($participatings as $participating) {
            $participating_class = $this->Classroom->find("first", array("conditions" => array("id" => $participating["Participation"]["class_id"])));
            if ($participating_class) {
                array_push($participating_classes, $participating_class);
            }
        }
        $this->set("participating_classes", $participating_classes);
        $this->set("holdings", $holdings);

        $classroom_id = $this->params["named"]["classroom_id"];
        $classroom = $this->Classroom->find("first", array("conditions" => array("id" => $classroom_id)));
        if ($classroom) {
            $this->set("classroom", $classroom);
            $holding = $this->User->find("first", array("conditions" => array("id" => intval(h($classroom["Classroom"]["created_by"])))));
            $this->set("holding", $holding);
            $belongings = $this->Belonging->find("all", array("conditions" => array("classroom_id" => intval($classroom_id))));
            $categories = array();
            if ($belongings) {
                
                foreach ($belongings as $belonging) {
                    $category = $this->Category->find("first", array("conditions" => array("id" => intval(h($belonging["Belonging"]["category_id"])))));
                    array_push($categories, $category);
                }
                
            }
            $this->set("categories", $categories);
        }
    }

    public function paticipate() {
        $this->autoLayout = false;
        $this->autoRender = false;
        $class_id = $this->params["named"]["class_id"];

        $participation = $this->Participation->find("all", array("conditions" => array("class_id" => intval($class_id), "user_id" => intval($this->Auth->user("id")))));

        if (!$participation) {
            $this->Participation->create();
            $data = array("Participation" => array("user_id" => intval($this->Auth->user("id")), "class_id" => intval($class_id), "status" => 1));
            $fields = array("user_id", "class_id", "status");
            $this->Participation->save($data, false, $fields);
        }
        $this->redirect(array("controller" => "class", "action" => "enter", "class_id" => $class_id));
    }

    public function enter() {
        $login_id = $this->Auth->user('id');
        $login_user = $this->User->find('first', array('conditions' => array('id' => $login_id)));
        $this->set('login_user', $login_user);
        $holding_classes = $this->Classroom->find("all", array("conditions" => array("created_by" => intval($this->Auth->user("id")))));
        $holdings = array();
        foreach ($holding_classes as $holding_class) {
            array_push($holdings, $holding_class);
        }
        $participatings = $this->Participation->find("all", array("conditions" => array("user_id" => intval($this->Auth->user("id")))));
        $participating_classes = array();
        foreach ($participatings as $participating) {
            $participating_class = $this->Classroom->find("first", array("conditions" => array("id" => $participating["Participation"]["class_id"])));
            if ($participating_class) {
                array_push($participating_classes, $participating_class);
            }
        }
        $this->set("participating_classes", $participating_classes);
        $this->set("holdings", $holdings);

        $this->set("div_id", "CDADA62EE844D90207C75E724FAC908C");
        
        $class = $this->Classroom->find("first",array("conditions"=>array("id" => intval($this->params["named"]["class_id"]))));
        $video_id = h($class["Classroom"]["ustream_id"]);
        $this->set("video_id",$video_id);
        $this->set("class_id",$this->params["named"]["class_id"]);
        $this->set("login_id",$login_id);
    }
    public function comments() {
        $this->autoLayout = false;
        $this->autoRender = false;
        
        $class_id = $this->params["named"]["class_id"];
        $comments = $this->Conversation->find("all",array("conditions"=>array("classroom_id"=>$class_id)));
        $classroom = $this->Classroom->find("first",array("conditions"=>array("id"=>$class_id)));
        
        echo h($classroom["Classroom"]["name"]);
        echo "<br>";
        foreach($comments as $comment){
            $user = $this->User->find("first",array("conditions"=>array("id"=>intval(h($comment["Conversation"]["user_id"])))));
            echo h($user["User"]["name"]);
            echo " | ";
            echo h($comment["Conversation"]["comment"]);
            echo " | ";
            echo h($comment["Conversation"]["created_at"]);
            echo "<br>";
        }
    }
    public function submit(){
        $this->autoLayout = false;
        $this->autoRender = false;
        
        $class_id = $this->params["named"]["class_id"];
        $value = $this->params["named"]["value"];
        $login_id = $this->params["named"]["login_id"];
        
        $this->Conversation->create();
        $data = array("Conversation"=>array("user_id"=>intval($login_id),"classroom_id"=>intval($class_id),"comment"=>$value,"created_at"=>date("c"),"status"=>1));
        $fields = array("user_id","classroom_id","comment","created_at","status");
        $this->Conversation->save($data,false,$fields);
        $this->redirect(array("action"=>"comments","class_id"=>$class_id));
        
        
    }
}
?>
