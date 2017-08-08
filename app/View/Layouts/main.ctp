<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>
    <?php echo $this->Html->css('main'); ?>
    <?php echo $this->Html->css('todo'); ?>
    <?php echo $this->fetch('script'); ?>
  </head>
  <body>
  <div id="container">
    <div id="header">
      <div id="header_menu">
        <?php
          echo "<h1>";
          echo $this->Html->link('検索','/todo/search');
          echo "</h1>";
        ?>
      </div>
      <div id="header_logo">
        <?php echo $this->Html->link($this->Html->image('todolist.png',array('width'=>'200','height'=>'100')),array('controller'=>'tasks','action'=>'index'),array('escape'=>false)); ?>
      </div>
      <hr>
      <div id="content">
        <?php echo $this->fetch('content'); ?>
      </div>
    </div>
  </body>
</html>
