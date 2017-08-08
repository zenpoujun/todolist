<?php

class Todo extends AppModel {

  public $name = 'Todo';

  public $belongsTo = array(
     "Task" => array(
       'className' => 'Task',
       'foreignKey' => 'task_id'
     )
   );

   public $validate = array(
    // name
    'name' => array(
      array(
        'rule' => 'notBlank',
        'message' => 'Todo名を入力してください。'
      ),
      array(
        'rule' => 'isUnique', //重複禁止
        'message' => '既に使用されているTodo名です。'
      ),
      array(
        'rule' => array('maxLength', 31),
        'message' => 'Todo名は31文字以内にしてください。'
      )
    ),

    'deadline' => array(
      array(
        'rule' => 'notBlank',
        'message' => '期限を入力してください。'
      )
    )
  );

}
