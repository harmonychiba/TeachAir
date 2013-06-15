<div class="admin form">
    <?php
        echo $this->Form->create('User', Array('url' => '/admin/add'));
        echo $this->Form->input('email');
        echo $this->Form->input('password');
        echo $this->Form->input('name');
        echo $this->Form->input('role', array(
            'options' => array('admin' => '管理者', 'staff' => 'スタッフ', 'customer' => 'お客様')
        ));
        echo $this->Form->end('アカウントを作成する');
    ?>
</div>