<?php

class BroadcastHelper extends AppHelper {

    /**
     * To get number of published advices
     */
    function getBroadCastById($broadcastId)
    {
        App::import('Model', 'BroadcastMessage');
        $obj = new BroadcastMessage();
         return $data = $obj->findAllById($broadcastId);
    }
}
