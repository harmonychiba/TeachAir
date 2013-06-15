<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Class
 *
 * @author harmonychiba
 */
class Classroom extends AppModel{
//put your code here
    public $name = 'Classroom';
    public $validate = Array(
        'name' => Array(
            'required' => Array(
                'rule' => Array('notEmpty'),
                'message' => 'メールアドレスを入力してください。'
            )
        ),
        'categories' => Array(
            'required' => Array(
                'rule' => Array('notEmpty'),
                'message' => 'カテゴリーを入力してください(,区切り)。'
            )
        ),
        'description' => Array(
            'required' => Array(
                'role' => Array('notEmpty'),
                'message' => '権限を選択してください。',
            )
        ),
        'ustreamID' => Array(
            'required' => Array(
                'rule' => Array('notEmpty'),
                'message' => 'チャンネルIDを入力してください。'
            )
        )
    );
}
?>
