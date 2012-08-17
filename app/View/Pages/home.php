<script>
  $(function() {
    $( "#tabs" ).tabs();
</script>

<div id="tabs">
  <ul>
    <li>
      <?php  echo $this->Html->link( 'Home','#tabs-1') ?>
    </li> 
    <li>
     <?php echo $this->Html->link( 'H/R and forms','#tabs-2') ?>
     </li> 
    <li>
      <?php echo $this->Html->link( 'Benefits', '#tabs-3') ?>
     </li> 
    <li>
      <?php echo $this->Html->link( 'Payroll','#tabs-4') ?> 
     </li>
  <div id="tabs-1">

    <?php echo $this->element('accordion_home') ?>
   </div>
  <div ="tabs-2">
    <?php  echo $this->element('accordion_forms') ?>
  </div>
  <div ="tabs-3">
    <?php echo $this->element('accordion_forms') ?>
  </div>
  <div ="tabs-4">
  </div>
    hi
  </ul>
</div>