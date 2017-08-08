<?php
// Ajaxを用いて、検索画面に表示するもの
if($count_Todo){
  echo "<div class = 'notregist'>";
  echo "Todoが",$count_Todo,"件見つかりました。<br/><hr>";
  echo "</div>";
    for ($i=0; $i < count($data_Todo); $i++) {
      $Todolist = $data_Todo[$i]["Todo"];
      echo $this->Html->link($Todolist["name"], array('controller' => 'todo','action'=>'index','?' => array('id' => $Todolist["task_id"])));
      echo "<br/><br/>";

      echo "Todoリスト名: ";
      echo h($data_Todo[$i]['Task']['title']);
      echo "<br/><br/>";

      $deadline_date = $Todolist['deadline'];
      echo "期限: ",date('Y年m月d日',  strtotime($deadline_date)),"<br/>";
      $create_date = $Todolist['created_at_todo'];
      echo "作成日: ",date('Y年m月d日',  strtotime($create_date));
      echo "<br/>";
      echo "<hr>";
    }
  } else {
  echo $this->Html->div('nosearch', "対象のTodoは見つかりませんでした。");
  }

  echo "<br/><br/>";
  if ($count_Task) {
    echo "<div class = 'notregist'>";
    echo "Todoリストが",$count_Task,"件見つかりました。<br/><hr>";
    echo "</div>";
    for ($i=0; $i < count($data_Task); $i++) {
      $Tasklist = $data_Task[$i]["Task"];
      echo $this->Html->link($Tasklist["title"], array('controller' => 'todo','action'=>'index','?' => array('id' => $Tasklist["id"])));
      echo "<br/><br/>";
      $created = $Tasklist['created'];
      echo "作成日: ",date('Y年m月d日',  strtotime($created));
      echo "<hr>";
    }
  }else {
    echo $this->Html->div('nosearch', "対象のTodoリストは見つかりませんでした。");
  }
 ?>
