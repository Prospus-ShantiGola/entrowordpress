<?php
class GuidelineHelper extends AppHelper {
    /**
     * To get guideline name by id
     * @param type guidelineId
     * @return type
     */
    public function guideLineName($guidelineId) {
        App::uses('EntropolisGuideline', 'Model');
        $obj = new EntropolisGuideline();
        $guidelineName = $obj->getGuidelineName($guidelineId);
        return $guidelineName;
    }
    

}
