<div class="timeClocks form">
<?php echo $this->Form->create('TimeClock');?>
	<fieldset>
		<legend><?php echo __('Edit Time Clock'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('punch_in');
		echo $this->Form->input('punch_out');
		echo $this->Form->input('employee_id');
		echo $this->Form->input('status');
		echo $this->Form->input('approved');
		echo $this->Form->input('work_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TimeClock.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TimeClock.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Time Clocks'), array('action' => 'index'));?></li>
	</ul>
</div>
