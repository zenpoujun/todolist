<h1>検索!</h1>
<?php
// フォーム処理
echo $this->Html->script('jquery',array('inline' => true));
echo $this->Form->create('Todo', array( 'type'=>'post'));
echo $this->Form->input('name',array('label' => 'ToDoを検索: ','placeholder'=>'todoリストを入力','size' => 30));
echo "<br/>";

// id="result-js-submit"に対してAjax処理を施す
echo $this->Js->submit('検索', array(
    'success' => $this->Js->get( '#sending-js-submit')->effect( 'show'),
    'url' => array(
        'action' => 'search_ajax'
    ),
    'update' => '#result-js-submit'
));
echo $this->Form->end();
echo $this->Js->writeBuffer();
echo "<hr><br/>";
 ?>

<div id="result-js-submit"></div><script>
