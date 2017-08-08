<?php


class TodoController extends AppController {

  // モデル
  public $uses = array('Task','Todo');

  // javascriptヘルパー
  public $helpers = array('Js' => array('Jquery'));

  public $components = array('Session','RequestHandler');

// ページネーション
  public $paginate = array(
    'Task' => array(
      'page' => 1,
      'limit' => 5,
      'sort' => 'created',
      'direction' => 'desc',
      'recursive' => 0
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

  // todoリストの処理
  public function index($param = null){
    // todoリストのidパラメータを受け取る
    if(!empty($this->request->query)) {
      $id = $this->request->query['id'];
      $this->set('id',$id);
    } else {
      $id = $param;
      $this->set("id",$id);
    }

    $conditions = array('conditions' => array('Task.id ' => $id));
    $task_name = $this->Task->find('first',$conditions);

    $this->set('task_name',h($task_name["Task"]["title"]));

    $conditions = array('Todo.task_id'=>$id);
    $data = $this->paginate('Todo',$conditions);
    $this->set('data',h($data));

  }


  // todoリストの追加処理
  public function add_todo(){
    if(!empty($this->data)){
      if($this->Todo->save($this->data) == false){
          $this->Session->write('errors.Todo', $this->Todo->validationErrors);
          $this->Session->setFlash($errors);
        return $this->redirect($this->referer());
          } else {
            $this->Todo->save($this->data);
            // idをパラメータに持たせリダイレクト
            $id = $this->data['Todo']['task_id'];
            $this->redirect(array('action'=>'index',$id));
          }
      }
  }


  public function delete(){
    $id = $this->data['Todo']['id'];
    if(!empty($id)){
      $conditions = array('Todo.id'=>$id);
      $this->Todo->delete($conditions);
    }
    $id = $this->data['Todo']['task_id'];
    $this->redirect(array('action'=>'index',$id));
    }


  // todoリストの完了、未完了の処理（未完了 => 0, 完了 => 1）
  public function status(){
    if(!empty($this->data)){
      // 未完了の時の処理
      if ($this->data['Todo']['status'] == 0) {
        $arr1 = array('Todo.id' => $this->data['Todo']['id']);
        $arr2 = array('Todo.status' => 1);
        $this->Todo->updateAll($arr2, $arr1);
      } else {
        // 完了の時の処理
        $arr1 = array('Todo.id' => $this->data['Todo']['id']);
        $arr2 = array('Todo.status' => 0);
        $this->Todo->updateAll($arr2, $arr1);
      }
    }
    // idをパラメータに持たせリダイレクト
    $id = $this->data['Todo']['task_id'];
    $this->redirect(array('action'=>'index',$id));
  }


  // 検索画面の処理
  public function search(){}


  // 検索画面でのAjax処理
  public function search_ajax(){
    $this->autoLayout = false;
    // View/Layouts にあるレイアウトを使用しない
    // $this->autoRender = false;
    $post = $this->request->data['Todo']['name'];

    // Taskリストのセレクト条件
    $condition_Task = array('conditions' => array('Task.title like' => "%{$post}%"));
    // Taskリストのセレクト
    $data_Task = $this->Task->find('all',$condition_Task);
    // Taskリストのカウント
    $count_Task = $this->Task->find('count',$condition_Task);


    // Todoリストのセレクト条件
    $condition_Todo = array('conditions' => array('Todo.name like' => "%{$post}%"),'order' => array('created_at_todo' => 'desc'));
    // Todoリストのセレクト
    $data_Todo = $this->Todo->find('all',$condition_Todo);
    // Todoリストのカウント
    $count_Todo = $this->Todo->find('count',$condition_Todo);

    $this->set("data_Task",h($data_Task));
    $this->set("count_Task",h($count_Task));
    $this->set("data_Todo",h($data_Todo));
    $this->set("count_Todo",h($count_Todo));
  }
}
