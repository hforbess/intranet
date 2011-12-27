<?php
App::uses('AppController', 'Controller');
/**
 * TimeClocks Controller
 *
 */
class TimeClocksController extends AppController {

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
     $date = DateTime::createFromFormat("m-d-Y h:i a",$my_time);
     $date = $date->format("Y-m-d H:i:00");
     if (preg_match("/punch-out/",$id,$matches) )
     {
       $my_arr  = explode('punch-out', $id);
       $id = $my_arr[1];
       $this->TimeClock->id = $id;
       $this->TimeClock->saveField('punch_out',$date);

     }
     else 
     {

       $my_arr  = explode('punch-in', $id);
       $id = $my_arr[1];
       $this->TimeClock->id = $id;
       $this->TimeClock->saveField('punch_in',$date);
     	
     }
     //return the difference
     $this->TimeClock->id = $id;
     
     $this->TimeClock->read();
    $punch_in =  date_create( $this->TimeClock->data['TimeClock']['punch_in']);
    $punch_out = date_create( $this->TimeClock->data['TimeClock']['punch_out'] );
   // debug ( $punch_out);
    $total_time = $punch_out->diff($punch_in);
    //debug ( $total_time );
    $return_arr = array('total_time' => $total_time->h.".".$total_time->i, 'id' => $id );
    echo json_encode($return_arr);
    $this->autoRender = false; 
    }   
  
}
