
<?php
echo $this->element('HeaderElement');
?>
<table>
    <tr>
        <td width ='20%'>
            <div>
                <?php
                echo $this->element('LeftSidebarElement', array('login_user' => $login_user, 'holdings' => $holdings, 'participating_classes', $participating_classes));
                ?>
            </div>
        </td>
        <td width='60%'>
            <div class="paticipating form">
                <?php
                echo "講義名:" . h($classroom["Classroom"]["name"]);
                echo "<br>";
                echo "講師:" . h($holding["User"]["name"]);
                echo "<br>";
                echo "カテゴリー:";
                if ($categories) {
                    foreach ($categories as $category) {
                        echo h($category["Category"]["name"]);
                        echo " ";
                    }
                }
                echo "<br>";
                echo $this->Html->link('参加する', array(
                    'controller' => 'class',
                    'action' => 'paticipate',
                    'class_id' => h($classroom["Classroom"]["id"])));
                echo("<br>");
                echo $this->Html->link('覗く', array(
                    'controller' => 'class',
                    'action' => 'enter',
                    'class_id' => h($classroom["Classroom"]["id"])));
                ?>
            </div>

        </td>
        <td width='20%'>
                <?php
                echo $this->element('RightSidebarElement');
                ?>
        </td>
    </tr>
</table>