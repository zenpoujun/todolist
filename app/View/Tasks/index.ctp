<h1>todoリスト</h1>
<hr>
<?php
// フォーム処理
 echo "<br/>";
 echo "新しいTodoリストを作る<br/><br/>";
 echo $this->Form->create('Task',array('url'=>array('action'=>'add')));
 echo $this->Form->input('Task.title',array('label' => 'リスト名: ','placeholder'=>'31文字以内で入力'));
 echo $this->Form->submit("リストの作成");
 echo $this->Form->end();
 echo $this->Session->flash();
 echo "<br/><hr>";


 // taskリストの表示処理
 for ($i=0; $i < count($data); $i++) {
   $task = $data[$i]['Task'];
   $todo = $data[$i]['Todo'];

  echo "<div class = 'titlelink'>";
  echo $this->Html->link($task['title'], array('controller' => 'todo','action'=>'index','?' => array('id' => $task["id"])));
  echo "</div>";
  echo "<br/>";

  // todoリストが完了した数のカウント処理
  $todocount = 0;
  for ($j=0; $j < count($todo); $j++) {
    if($todo[$j]["status"] == 1){
      $todocount += 1;
    }
  }

  if(count($todo)){
    echo count($todo),"個中{$todocount}個がチェック済み!<br/><br/>";
  }else {
    echo "todoリストはありません。";
  }

  // todoリストの表示処理
  for ($k=0; $k < count($todo); $k++) {

    $deadline_data = $todo[$k]["deadline"];
    $status = $todo[$k]["status"];

    $day = strtotime($deadline_data);

    $now = new DateTime();
    $now = (array)$now;
    $now = strtotime($now["date"]);

    // 締切日が過ぎてない事かつ未完了のtodoリストのみの条件で表示
    if ($now < $day && $status == 0) {
      echo "{$todo[$k]['name']}<br/>";
      $date = $todo[$k]['deadline'];
      echo "~",date('Y年m月d日',  strtotime($date));
      break;
    }
  }

  // 未完了のtodoリストの数
  $uncheck_Task = count($todo) - $todocount;

  // 削除ボタン
  if($uncheck_Task) {

    // 未完了のTodoが存在する時
      echo $this->Form->create('Task',array('url'=>'/tasks/delete', 'onsubmit' => 'return confirm("また未完了のtodoが存在しますが、削除します。よろしいですか？");'));
      echo $this->Form->hidden('id',array('value'=>$task['id']));
      echo $this->Form->submit('削除');
      echo $this->Form->end();
    } else {

      // 全て完了した、またはTodoを作成していない時
      echo $this->Form->create('Task',array('url'=> '/tasks/delete', 'onsubmit' => 'return confirm("削除します。よろしいですか？");'));
      echo $this->Form->hidden('id',array('value'=>$task['id']));
      echo $this->Form->submit('削除');
      echo $this->Form->end();
  }
   echo "<hr>";
 }


 echo "<br/><br/>";
 echo $this->paginator->prev('<<前へ',array());
 echo $this->paginator->next('>>次へ',array());

 ?>
