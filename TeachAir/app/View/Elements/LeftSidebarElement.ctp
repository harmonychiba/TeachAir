<?php
$login_user = $this->get("login_user");
echo $this->Html->link(h($login_user['User']['name']),array('controller'=>'top','action'=>'index'));
echo "<br>"."あなたが開催中の講義"."<br>";
foreach($holdings as $holding){
    echo $this->Html->link(h($holding["Classroom"]["name"]),array("controller"=>"class","action"=>"visit","classroom_id"=>h($holding["Classroom"]["id"])));
    echo "<br>";
}
echo "あなたが受講中の講義"."<br>";
foreach($participating_classes as $participating_class){
    echo $this->Html->link(h($participating_class["Classroom"]["name"]),array("controller"=>"class","action"=>"visit","classroom_id"=>h($participating_class["Classroom"]["id"])));
    echo "<br>";
}
?>