
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
            <div class="hosting form">
    <?php
        echo $this->Form->create('Classroom', Array('url' => '/class/entry'));
        echo $this->Form->input('name');
        echo $this->Form->input('description');
        echo $this->Form->input('ustreamID');
        echo $this->Form->input('categories');
        echo $this->Form->end('授業を開催する');
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