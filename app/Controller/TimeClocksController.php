<?php
App::uses('AppController', 'Controller');
App::uses('Day', 'Vendor');
App::uses('MyEmployee', 'Vendor');
App::uses('Punch', 'Vendor');
App::uses('Employee', 'Model');
App::uses('TimeClock', 'Model');
App::uses('EditSupplemental', 'Model');
App::uses('EmployeesController', 'Controller');
/**
 * TimeClocks Controller
 *
 */
class TimeClocksController extends AppController {

   // var $components = array('Auth');
	public function approve($id)
    {

     $this->TimeClock->id = $id;
     $this->TimeClock->saveField('approved',1);
    
     echo 'ok';
     $this->autoRender = false; 
    }

    public function disApprove($id)
    {
     $this->TimeClock->id = $id;
     $this->TimeClock->saveField('approved',0);

     echo 'ok';
     $this->render('/Layouts/plain'); 
    }
    public function updateTimes($id)
    {

    $my_time = $this->params['url']['my_time'];
    $employee_id = $this->params['url']['employee_id'];
    $pay_periods = EmployeesController::getPayPeriods();
    //debug( $pay_periods );
    $employee = new Employee($employee_id);
    $employee->read();
    //debug($employee);
    $temp  = new MyEmployee($employee->data);
    $temp->setWeeks($pay_periods['week_one_start']->format("Y-m-d"), $pay_periods['week_one_end']->format("Y-m-d"),$pay_periods['week_two_start']->format("Y-m-d"), $pay_periods['week_two_end']->format("Y-m-d"), $temp->id);
    
    $date = DateTime::createFromFormat("m-d-Y h:i a",$my_time);
    $date = $date->format("Y-m-d H:i:00");
    $day = $this->params['url']['day'];

     if (preg_match("/punch-out/",$id,$matches) )
     {
       
       $my_arr  = explode('punch-out', $id);
       $id = $my_arr[1];
       $this->TimeClock->read(null,$id);
       $this->TimeClock->set('punch_out',$date);
       $this->TimeClock->save();

     }
     else 
     {

       $my_arr  = explode('punch-in', $id);
       $id = $my_arr[1];
       $this->TimeClock->read(null,$id);
       $this->TimeClock->set('punch_in',$date);
       $this->TimeClock->save();
     	
     }

    $this->TimeClock->findById( $id );
    $this->TimeClock->read();     
    $punch_in =  date_create( $this->TimeClock->data['TimeClock']['punch_in']);
    $punch_out = date_create( $this->TimeClock->data['TimeClock']['punch_out'] );
    $punch_time = $punch_out->diff($punch_in);
    $my_day = new Day(clone $punch_in,$this->TimeClock->data['TimeClock']['employee_id']);
    //get the total hours
    //debug($temp->my_weeks);
    $week_one_total = $temp->week_one->total_regular_time;
    $week_one_overtime = $temp->week_one->over_time;
    $week_two_total = $temp->week_two->total_regular_time;
    $week_two_overtime = $temp->week_two->over_time;

    $two_week_total = $temp->two_week_total;
    $two_week_overtime = $temp->two_week_over_time;
    $return_arr = array('punch_time' => $punch_time->h.".".$punch_time->i, 'id' => $id ,
                        'daily_hours' => $my_day->daily_hours,
                        'week_one_total' => $week_one_total,
                        'week_two_total' => $week_two_total,                        
                        'week_one_overtime' => $week_one_overtime, 
                        'week_two_overtime' => $week_two_overtime,                        
                        'two_week_total' => $two_week_total, 
                        'two_week_overtime' => $two_week_overtime,
                        'day' => $day     

                        );
    echo json_encode($return_arr);
    $this->autoRender = false; 
    //$this->render("/Layouts/plain");
     
    }   
   public function getPunch()
   {
     $arr = $this->params['pass'];   
     $id = $arr[0];
     $day = $arr[1];
     $week = $arr[2];
     $this->set('read_only',false);
     //group id 3 is users and is read only
     if( $this->Session->read('current_user')->group_id == 3)
     {
      $this->set('read_only',true);    
     }
     
   	 $punch = new Punch($id); 
   	 $this->set('punch',$punch);
   	 $this->set('week',$week);
   	 $this->set('day',$day);
   	 $this->render('/Elements/punch',false);
   }
   public function setWorkCode()
   {
     $arr = $this->params['pass'];   
     $id = $arr[0];
     $work_code = @$arr[1];
     $this->TimeClock->read(null,$id);
     $this->TimeClock->set('work_code',$work_code);
     $employee_id = $this->TimeClock->data['TimeClock']['employee_id'];

     $this->TimeClock->save();
     $employee = new Employee(  );
     $employee->id = $employee_id;
     $employee->read();
     $my_emp = new MyEmployee($employee->data);
     $return_arr = array('result'=>'ok','sick_time_remaining' => $my_emp->getRemainingSick(), 'pto_remaining' => $my_emp->getRemainingVacation() );
     echo json_encode($return_arr);
     $this->autoRender = false; 
     
       
       
   }
   public function deletePunch()
   {
     $arr = $this->params['pass'];
     $id = $arr[0];
     $this->TimeClock->read(null,$id);
     $this->TimeClock->set('deleted',1);
     $this->TimeClock->save();
     $this->autoRender = false; 
   }
   public function addPunch()
   {
   	$arr = $this->params['pass'];   
    $clock = new TimeClock(); 
    $clock->create();
    $clock->set("employee_id",  $arr[0] );
    //echo $arr[1];
    //logger.info( "#arr[1] DATE");
    $clock->set("punch_in","$arr[1] 08:00:00");
    $clock->set("punch_out","$arr[1] 16:00:00");
    $clock->save();
    $id = $clock->id;
   	
     //$id = $arr[0];
     //$week = $arr[1];
   	 //$punch = new Punch($id ); 
   	 //$this->set('punch',$punch);
   	 //$this->set('week',1);
   	 //$this->render('/Elements/punch',false);
   	 echo $id;
   	 $this->autoRender = false; 
   }
   
  public function getUnapprovedTimes($employee_id)
  {

  	//$pay_periods = EmployeesController::getPayPeriods();
  	//debug( $pay_periods);
  	
  }
  public function  isAuthorized($user)
  {
    
  	$current_user =  $this->Session->read('current_user');
  /* group_id
   0, 'administrator'
   1, 'human_resource'
   2, 'manager'
   3, 'user'
 */ 	
  	switch ( $current_user->group_id )
  	{
  		case 0 :
  			return true;
  			break;
  		case 1 :
  			return true;
  	        break;
  		case 2 :
  			return true;
  			break;
  		case 3 :
  			$ok = false;
  			if ( in_array($this->action,array('getPunch')))
  			{
  			 $ok = true;
  			}
  			break;
  		default:
  			return false;
  	} 
   
  	return $ok;
  }
}
