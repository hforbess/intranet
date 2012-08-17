<?php
App::uses('AppModel', 'Model');
/**
 * TimeClock Model
 *
 * @property Employee $Employee
 */
class TimeClock extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
/*
	public $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	*/
	
	
    var $virtualFields = array(
    'date_part' => 'DATE(punch_in)'
    );
	
}
