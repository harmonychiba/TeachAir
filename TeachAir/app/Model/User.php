<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author harmonychiba
 */
class User extends AppModel {
 
    public $name = 'User';
    public $validate = Array(
        'email' => Array(
            'required' => Array(
                'rule' => Array('notEmpty'),
                'message' => 'メールアドレスを入力してください。'
            )
        ),
        'password' => Array(
            'required' => Array(
                'rule' => Array('notEmpty'),
                'message' => 'パスワードを入力してください。'
            )
        ),
        'role' => Array(
            'valid' => Array(
                'rule' => Array('inList', Array('admin', 'staff', 'author')),
                'message' => '権限を選択してください。',
                'allowEmpty' => false
            )
        ),
        'name' => Array(
            'required' =>Array(
                'role'=>Array('notEmpty'),
                'massage' => '名前を入力してください。'
            )
        )
    );
 
    public function beforeSave() {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
}

?>
