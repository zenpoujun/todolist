<?php

class TasksController extends AppController {

  // モデル
  public $uses = array('Task','Todo');

  // javascriptヘルパー
  public $helpers = array('Js');

  // ページネーション
  public $paginate = array(
    'Task' => array(
      'page' => 1,
      'limit' => 5,
      'sort' => 'created',
      'direction' => 'desc',
      'recursive' => 1
    ),
    'Todo' => array(
      'page' => 1,
      'limit' => 5,
      'sort' => 'created_at_todo',
      'direction' => 'desc',
      'recursive' => 0
      )
  );


  //どのアクションが呼ばれてもはじめに実行される関数
  public function beforeFilter() {
        parent::beforeFilter();
        if($this->Session->read('errors')) {
            foreach($this->Session->read('errors') as $model => $errors) {
                $this->loadModel($model);
                $this->$model->validationErrors = $errors;
            }
            $this->Session->delete('errors');
        }
    }


  // ホーム画面の処理
  public function index(){
    // task hasMany todo なのでtodoのdeadlineにおいて、今日の日付に近い順にtodolistを並べ替える
    $this->Task->hasMany['Todo']['order'] = 'abs(datediff(CURDATE(), Todo.deadline)) asc ';
    $data = $this->paginate('Task');
    $this->set('data',h($data));
  }

  // taskリストの追加処理
  public function add(){
    if(!empty($this->data)){
      if($this->Task->save($this->data) == false){
          $this->Session->write('errors.Task', $this->Task->validationErrors);
          $this->Session->setFlash($errors);
        return $this->redirect($this->referer());
          } else {
            $this->Task->save($this->data);
            $this->Session->setFlash("新しいToDoリストが作成されました");
            return $this->redirect($this->referer());
          }
      }
  }

// taskリストの削除機能
  public function delete(){
    $id = $this->data['Task']['id'];
    if(!empty($id)){
      $conditions = array('Task.id'=>$id);
      $this->Task->delete($conditions);
    }
    $this->redirect("index");
  }

}
