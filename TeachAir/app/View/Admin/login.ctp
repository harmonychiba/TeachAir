<div class="login form">
    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Form->create('User', Array('url' => '/admin/login')); ?>
    <table>
    	<tr>
    		<th>メールアドレス</th>
            <td><?php echo $this->Form->input('email', Array('label' => false)); ?></td>
    	</tr>
    	<tr>
    		<th>パスワード</th>
            <td><?php echo $this->Form->input('password', Array('label' => false)); ?></td>
    	</tr>
    </table>
    <?php echo $this->Form->end('ログイン'); ?>
</div>