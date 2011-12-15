<div class="groups view">
<h2><?php  echo __('Group');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Name'); ?></dt>
		<dd>
			<?php echo h($group['Group']['group_name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Group'), array('action' => 'edit', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Group'), array('action' => 'delete', $group['Group']['id']), null, __('Are you sure you want to delete # %s?', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Employees'), array('controller' => 'employees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employee'), array('controller' => 'employees', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Employees');?></h3>
	<?php if (!empty($group['Employee'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('First Name'); ?></th>
		<th><?php echo __('Middle Name'); ?></th>
		<th><?php echo __('Last Name'); ?></th>
		<th><?php echo __('Employee Number'); ?></th>
		<th><?php echo __('User Group'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Pay Type'); ?></th>
		<th><?php echo __('Sick Time Remaining'); ?></th>
		<th><?php echo __('Pto Remaining'); ?></th>
		<th><?php echo __('Pay Cycle'); ?></th>
		<th><?php echo __('Position'); ?></th>
		<th><?php echo __('Department'); ?></th>
		<th><?php echo __('Extension'); ?></th>
		<th><?php echo __('Time Clock Remote Access'); ?></th>
		<th><?php echo __('Entry Type'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($group['Employee'] as $employee): ?>
		<tr>
			<td><?php echo $employee['id'];?></td>
			<td><?php echo $employee['first_name'];?></td>
			<td><?php echo $employee['middle_name'];?></td>
			<td><?php echo $employee['last_name'];?></td>
			<td><?php echo $employee['employee_number'];?></td>
			<td><?php echo $employee['user_group'];?></td>
			<td><?php echo $employee['email'];?></td>
			<td><?php echo $employee['password'];?></td>
			<td><?php echo $employee['pay_type'];?></td>
			<td><?php echo $employee['sick_time_remaining'];?></td>
			<td><?php echo $employee['pto_remaining'];?></td>
			<td><?php echo $employee['pay_cycle'];?></td>
			<td><?php echo $employee['position'];?></td>
			<td><?php echo $employee['department'];?></td>
			<td><?php echo $employee['extension'];?></td>
			<td><?php echo $employee['time_clock_remote_access'];?></td>
			<td><?php echo $employee['entry_type'];?></td>
			<td><?php echo $employee['group_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'employees', 'action' => 'view', $employee['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'employees', 'action' => 'edit', $employee['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'employees', 'action' => 'delete', $employee['id']), null, __('Are you sure you want to delete # %s?', $employee['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Employee'), array('controller' => 'employees', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
