<h1>Teach_Air</h1>
<div Align="right">
<?php
echo $this->Html->link('Login', 
           array('controller' => 'admin', 'action' => 'login')
           );
echo ' ';
echo $this->Html->link('register', 
           array('controller' => 'admin', 'action' => 'add')
           );
echo ' ';
echo $this->Html->link('Logout', 
           array('controller' => 'admin', 'action' => 'logout')
           );
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
</div>