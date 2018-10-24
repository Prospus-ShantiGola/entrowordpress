<?php
class AccessModuleList extends AppModel{
    public $name = 'AccessModuleList';
    public $useTable = 'module_list';
    
    public function getSubModuleList($parentId){
       $subModules = $this->find('all', array('conditions'=>array('module_parent_id'=>$parentId)));
       return $subModules;
    }
}
