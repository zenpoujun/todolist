<h1>Todo詳細画面</h1>

<?php
// datepicker等の読み込み
echo $this->Html->script('jquery-1.8.3', array('inline' => true));
echo $this->Html->script('jquery-ui-1.9.2.custom', array('inline' => true));
echo $this->Html->script('jquery.ui.datepicker-ja', array('inline' => true));
echo $this->Html->css('jquery-ui-1.9.2.custom', null, array('inline' => true));


// datepickerのjavascript処理
echo $this->Html->scriptStart(array('inline' => true));
echo <<< END
$(document).ready( function() {
    $( "#datepicker" ).datepicker();
});
END;
echo $this->Html->scriptEnd();


// フォーム処理
echo $this->Html->div('taskname1', "タスク名: ");
echo $this->Html->div('taskname2', "{$task_name}");
echo "<br/><br/>";
echo $this->Form->create('Todo',array('url'=>array('controller' => 'todo','action'=>'add_todo')));
echo $this->Form->hidden('Todo.task_id',array('value'=>$id));
echo $this->Form->input('Todo.name',array('label' => 'ToDo名: ','placeholder'=>'31文字以内で入力','size' => 30));
echo "<br/>";
echo $this->Session->flash();

echo $this->Form->input('Todo.deadline',array('label' => '期間: ', 'type' => 'text','id' => 'datepicker'));
echo "<br/>";
echo $this->Form->submit("ToDoの作成");
echo $this->Form->end();
echo "<br/><hr>";

if(count($data)){
    for ($i=0; $i < count($data); $i++) {
      $task = $data[$i]['Todo'];
      echo "<br/>";
      echo h($task['name']),"<br/><br/>";

      $deadline_date = $task['deadline'];
      echo "期限: ",date('Y年m月d日',  strtotime($deadline_date)),"<br/>";

      $create_date = $task['created_at_todo'];
      echo "作成日: ",date('Y年m月d日',  strtotime($create_date));
      echo "<br/>";
      // todoが完了しているかどうかの条件分岐
      $todo = true;
      if ($task['status'] == 0) {
        $todo = false;
      }

      if($todo) {
          echo $this->Form->create('Todo',array('url'=>array('controller'=>'todo','action'=>'status')));
          echo $this->Form->hidden('id',array('value'=>$task['id']));
          echo $this->Form->hidden('task_id',array('value'=>$task['task_id']));
          echo $this->Form->hidden('status',array('value'=>$task['status']));
          echo $this->Form->submit('完了!');
          echo $this->Form->end();

          // 削除ボタン処理
          echo $this->Form->create('Todo',array('url'=>'/todo/delete', 'onsubmit' => 'return confirm("todoを削除します。よろしいですか？");'));
          echo $this->Form->hidden('id',array('value'=>$task['id']));
          echo $this->Form->hidden('task_id',array('value'=>$task['task_id']));
          echo $this->Form->submit('削除');
          echo $this->Form->end();

        } else {
          echo $this->Form->create('Todo',array('url'=>array('controller'=>'todo','action'=>'status')));
          echo $this->Form->hidden('id',array('value'=>$task['id']));
          echo $this->Form->hidden('task_id',array('value'=>$task['task_id']));
          echo $this->Form->hidden('status',array('value'=>$task['status']));
          echo $this->Form->submit('未完了!');
          echo $this->Form->end();

          // 削除ボタン処理
          echo $this->Form->create('Todo',array('url'=> '/todo/delete', 'onsubmit' => 'return confirm("todoは未完了ですが削除します。よろしいですか？");'));
          echo $this->Form->hidden('id',array('value'=>$task['id']));
          echo $this->Form->hidden('task_id',array('value'=>$task['task_id']));
          echo $this->Form->submit('削除');
          echo $this->Form->end();
      }


      echo "<hr>";
    }
  }else {
    echo "<br/>";
    echo $this->Html->div('notregist', "登録されたToDoはございません。");
}



echo "<br/><br/>";
// $idをパラメータとして持たせてページネーションさせる
echo $this->paginator->options(array('url' => $id));
echo $this->paginator->prev('<<前へ',array());
echo $this->paginator->next('>>次へ',array());

 ?>
