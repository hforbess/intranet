<div class="timeClocks view">
<h2><?php  echo __('Time Clock');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($timeClock['TimeClock']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Punch In'); ?></dt>
		<dd>
			<?php echo h($timeClock['TimeClock']['punch_in']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Punch Out'); ?></dt>
		<dd>
			<?php echo h($timeClock['TimeClock']['punch_out']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Employee Id'); ?></dt>
		<dd>
			<?php echo h($timeClock['TimeClock']['employee_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($timeClock['TimeClock']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Approved'); ?></dt>
		<dd>
			<?php echo h($timeClock['TimeClock']['approved']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Work Code'); ?></dt>
		<dd>
			<?php echo h($timeClock['TimeClock']['work_code']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Time Clock'), array('action' => 'edit', $timeClock['TimeClock']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Time Clock'), array('action' => 'delete', $timeClock['TimeClock']['id']), null, __('Are you sure you want to delete # %s?', $timeClock['TimeClock']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Time Clocks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time Clock'), array('action' => 'add')); ?> </li>
	</ul>
</div>
