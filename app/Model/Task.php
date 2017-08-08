<?php

class Task extends AppModel {

  public $name = 'Task';

  public $hasMany = array(
     "Todo" => array(
       'className' => 'Todo',
       'dependent'    => true,
       'foreignKey' => 'task_id'
     )
   );

   public $validate = array(
    // name
    'title' => array(
      array(
        'rule' => 'notBlank',
        'message' => 'リスト名を入力してください。'
      ),
      array(
        'rule' => 'isUnique', //重複禁止
        'message' => '既に使用されているリスト名です。'
      ),
      array(
        'rule' => array('maxLength', 31),
        'message' => 'リスト名は31文字以内にしてください。'
      )
    )
  );
}
