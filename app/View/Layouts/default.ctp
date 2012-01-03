<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
    <?PHP echo $this->Html->charset(); ?>
    <title>Temple Daily Telegram Intranet</title>
    <?PHP echo $this->Html->css('jquery-ui-1.8.7.custom'); ?>
    <?PHP echo  $this->Html->css('main') ?>
    <?PHP echo  $this->Html->css('jquery.toastmessage.css') ?>
    <?PHP echo $this->Html->script('jquery-1.4.4.min'); ?>
    <?PHP echo $this->Html->script('jquery-ui-1.8.7.custom.min') ?>
    <?PHP echo $this->Html->script('jquery.toastmessage.js') ?>
    <?PHP echo $this->Html->script('datetime_picker.js') ?>
    <?PHP echo $scripts_for_layout; ?>

  </head>

    <body>
<div id="container">
   <div id="header">
   <?PHP echo $this->Html->image('logo.jpg',array('id' => 'logo')) ?>  
   <h1 style = 'display:inline;float:right;font-size:2em;' class="ui-widget-header">
    Intranet
   </h1>	  
   <?PHP echo  $content_for_layout ?>
   <div id="footer">
   <?PHP  //echo $this->element('sql_dump') ?>
   </div>
   </div>
  </body>
  </html>
