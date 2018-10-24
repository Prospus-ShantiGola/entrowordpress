<?php

App::uses('UsersController', 'Controller');

/**
 * 
 */
class CityGuidesController extends AppController {

    public $helper = array('Html', 'Form', 'Js' => array('Jquery'), 'Paginator', 'Image');
    public $components = array('Session', 'RequestHandler', 'Paginator');
    public $uses = array('Cityguide', 'CityguideVideo');

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->RequestHandler->isAjax() && $this->Session->read('user_id') == "") {

            echo '<script type = "text/javascript"> 
                        window.location.reload();
                </script>';
            exit();
        }
        if ($this->Session->read('user_id') == "") {

            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
        }


        $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);

        $context_ary = $this->Session->read('context-array');
        if (in_array('1', $context_ary) && @$this->request->params['action'] == 'index') {
            $this->redirect(array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true));
        }
        if ((in_array('6', $context_ary) || in_array('5', $context_ary)) && @$this->request->params['action'] == 'admin_index') {
            $this->redirect(array('controller' => 'cityGuides', 'action' => 'index', 'admin' => false));
        }

        $this->set('title_for_layout', 'Tutorials');
    }

    public function index() {
        $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        $cityGuide = $this->Cityguide->find('first');
        $this->set("cityGuide", $cityGuide);
    }

    public function edit() {
        $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        $cityGuide = $this->Cityguide->find('first');
        $this->set("cityGuide", $cityGuide);
//        pr($cityGuide);
//        die('hhh');
    }
    /**
     * saveCityGuide to save the video links. Tutorial section.
     * 
     */
    public function saveCityGuide() {

        $cityGuide = $this->Cityguide->find('first');
        if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {
                $uploadFolder = "img";
                $currDate = date('Y-m-d H:i:s');
                $title = htmlentities($this->request->data['Cityguide']['city_guide_title'], ENT_QUOTES);
                $video_url = $this->request->data['Cityguide']['video_url'];
                // $this->CityguideVideo->deleteAll(array('Cityguide.id' => $cityGuide['Cityguide']['id']));
                foreach ($this->request->data['city_guide_title'] as $videoKey => $city_guide_title) {
                    $videoArr = array();
                    $videoArr[$videoKey]['city_guide_title'] = $city_guide_title;
                    $videoArr[$videoKey]['video_url'] = $this->request->data['video_url'][$videoKey];
                    $videoArr[$videoKey]['cityguide_id'] = $this->request->data['cityguide_id'];
                    $videoExist = $this->CityguideVideo->find('first', array('conditions' => array('CityguideVideo.id' => $videoKey + 1)));
                    if (!$videoExist) {
                        $this->CityguideVideo->create();
                        $this->CityguideVideo->save($videoArr[$videoKey]);
                    } else {
                        $this->CityguideVideo->id = $videoKey + 1;
                        $this->CityguideVideo->save($videoArr[$videoKey]);
                    }
                }

                $updateData = array('city_guide_title' => "'$title'", 'video_url' => "'$video_url'");
                $this->Cityguide->updateAll($updateData, array('Cityguide.id' => $cityGuide['Cityguide']['id']));
                $result = array("result" => "success");
            } else {
                $result = array("result" => "error");
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        }
    }

}
