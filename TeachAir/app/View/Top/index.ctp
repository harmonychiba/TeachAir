
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
            <div class="class list">
                <?php
                echo $this->Html->link('授業を開催する', array(
                    'controller' => 'top',
                    'action' => 'host'));
                echo("<br>");
                $i = 0;
                foreach ($recent_classrooms as $key => $classroom) {
                    $holder = $holders[$i];
                    $i++;
                    echo $this->Html->link(h($classroom["Classroom"]["name"])." held by ".h($holder["User"]["name"]),array('controller'=>"class",'action'=>"visit","classroom_id"=>h($classroom["Classroom"]["id"])));
                    echo "<br>";
                }
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