<?php
// $Id: EsceneController.php

/**
 * @file:
 *   Controller file to maintain all the post in the system by various user and display those comment in the view section.
 *   author : awdhesh soni
 *   contact : awdhesh.soni@prospus.com
 *   copyright reserved with Prospus Consulting Pvt. Ltd.
 */


class GroupCodesController extends AppController {

   // var $name = 'GroupCodes'; 
	public $helper = array('Html', 'Form');
    public $components = array('Email', 'Session', 'RequestHandler');
    public $uses = array('GroupCode');
	 
	 function beforeFilter() {
	 	parent::beforeFilter();
	 }
	 /*function here to display group code here*/
	 public function admin_index() {
			 //$this->layout = 'admin_default';
			 $this->set('title_for_layout', 'Group Code Management');
			 $categories = $this->GroupCode->generateTreeList(null,null,null,'&nbsp;','1');
			 $limitPerpage = 10;
				$this->paginate = array('conditions'=>array(),
				'limit' => $limitPerpage,
				'order' => array('lft' => 'asc')
				);
			
			$GroupCode = $this->paginate('GroupCode');
			
        	$this->set(compact('categories','GroupCode'));     
			
		$this->set('pass', $this->params['pass']);
        $this->set('perPageLimit', $limitPerpage);
        
        if($this->RequestHandler->isAjax()){          
             $this->layout = 'ajax'; 
             $this->render('/Elements/all_groupcode'); 
        }
        else{
            $this->layout = 'admin_default';
        }
			
          } 
	/*function here to add gropu code here*/	  
	public function admin_add() {
	$this->layout = 'admin_default';
	 $this->set('title_for_layout', 'Add Group Code');
		
		$parents[0] = " ";
		$categories = $this->GroupCode->generateTreeList(null,null,null, " - ", '1');
		if($categories) {
		foreach ($categories as $key=>$value)
			$parents[$key] = $value;
		}
		$this->set(compact('parents'));
		if (!empty($this->request->data) ) {
		if($this->GroupCode->validates()){ 
		$this->request->data['GroupCode']['created'] = date('Y-m-d h:i:s');	
		
		if(!empty($this->request->data['GroupCode']['parent_id'])){
			$parentName = $this->GroupCode->find('first',array('conditions'=>array('GroupCode.id'=>$this->request->data['GroupCode']['parent_id']),'fields'=>array('GroupCode.name')));
			$this->request->data['GroupCode']['parent_name'] = $parentName['GroupCode']['name'];	
		}
		
		$save= $this->GroupCode->save($this->request->data);
		if($save){
                         $this->Session->setFlash('Group Code has been added.', 'default', array('class'=>'alert-success session-alert'));
						 $this->redirect(array('action' => 'index'));
                     }
                     else{
                         $this->Session->setFlash('Sorry! Group Code not add.', 'default', array('class'=>'alert-danger session-alert '),array('style'=>'background: #f2dede !important;color: #a94442'));

                     }
		}
	} else {
		$parents[0] = " ";
		$categories = $this->GroupCode->generateTreeList(null,null,null, " - ", '1');
		if($categories) {
		foreach ($categories as $key=>$value)
			$parents[$key] = $value;
		}
		$this->set(compact('parents'));
	}  
	
  } 
     /*function here to update group code here */
		public function admin_edit($id=null) {
			$this->layout = 'admin_default';
			$this->set('title_for_layout', 'Update Group Code');
		$parents[0] = " ";
		$categories = $this->GroupCode->generateTreeList(null,null,null, " - ", '1');
		if($categories) {
		foreach ($categories as $key=>$value)
			$parents[$key] = $value;
		}
		$this->set(compact('parents'));
		
		if (!empty($this->request->data)) {
			if($this->GroupCode->validates()){ 
			
			
			$parentName = $this->GroupCode->find('first',array('conditions'=>array('GroupCode.id'=>$this->request->data['GroupCode']['parent_id']),'fields'=>array('GroupCode.name')));
			
			if($this->request->data['GroupCode']['parent_id']==0 && empty($parentName)){
					$parent_name = $this->request->data['GroupCode']['name'];
					//$this->GroupCode->updateAll($this->request->data['GroupCode']['parent_name'],array('parent_id',$id));
					$dataArray = array('parent_name'=>"'$parent_name'");
					$update  = $this->GroupCode->updateAll($dataArray, array('GroupCode.parent_id' =>$id));
					
					
			}
			else if($this->request->data['GroupCode']['parent_id']!=0){
			
				
				$this->request->data['GroupCode']['parent_name'] = $parentName['GroupCode']['name'];	
			}
			else {
				$this->request->data['GroupCode']['parent_name'] = '';	
			}
			
			
				if($this->GroupCode->save($this->request->data)){
				         $this->Session->setFlash('Group code has been updated.', 'default', array('class'=>'alert-success session-alert'));
						 $this->redirect(array('action' => 'index'));
                     }
                     else{
                         $this->Session->setFlash('Sorry! Group Code not update.', 'default', array('class'=>'alert-danger session-alert'));
                     }
			}
		}else {
			if($id==null) die("No ID received");
			$this->data = $this->GroupCode->read(null, $id);
			$parents[0] = " ";
			$categories = $this->GroupCode->generateTreeList(null,null,null," - ");
			if($categories) 
			foreach ($categories as $key=>$value)
			$parents[$key] = $value;
			$this->set(compact('parents'));
			}
		}

      /*function use here to delete group code*/

		public function admin_delete($id=null) {
		  if($id==null)
		  die("No ID received");
		  $this->GroupCode->id=$id;
		  if($this->GroupCode->removeFromTree($id,true)==false)
			 $this->Session->setFlash('The Group Code could not be deleted.');
		   $this->Session->setFlash('Group Code has been deleted.');
		   $this->redirect(array('action'=>'index'));
		}
	 
}