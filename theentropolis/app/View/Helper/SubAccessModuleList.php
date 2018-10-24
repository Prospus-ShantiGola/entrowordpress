<?php
class GuideComboHelper extends AppHelper{
    
    public function classCombo($classId =0){
       
        App::import("Model", "Classguide");
        $guide = new Classguide();
        $classLst = $guide->getClassList();
        $result = array();
        foreach($classLst as $key=>$class){
            $result[] = $class['Classguide'];
        }
        $classHtml = '';
        foreach($result as $key=>$datas){
            $classHtml .= '<option value="'.$datas['preferred_class_id'].'" ';
	    $classHtml .=  $classId==$datas['preferred_class_id'] ? "selected='selected'" : '';
	    $classHtml .=  '> Class '.$datas['class_name'].'</option>';	
        }
        return $classHtml;
    }
}
