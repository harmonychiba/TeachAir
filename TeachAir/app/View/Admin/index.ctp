<?php
echo $this->element('HeaderElement');
?>
<table>
    <tr>
        <td width='20%'>
            <div>
                <?php
                echo $this->element('LeftSidebarElement', array('login_user' => $login_user,'holdings'=>$holdings,'participating_classes',$participating_classes));
                ?>
            </div>
        </td>
        <td width='60%'>
            <div class="edit form">
                <?php
                echo $this->Form->create('User', Array('url' => '/admin/edit'));
                echo $this->Form->input('email');
                echo $this->Form->input('password');
                echo $this->Form->input('name');
                echo $this->Form->end('アカウントを編集する');
                ?>
            </div>
        </td>
        <td width='20%'>
            <?php
            echo $this->element("RightSidebarElement");
            ?>
        </td>
    </tr>
</table>