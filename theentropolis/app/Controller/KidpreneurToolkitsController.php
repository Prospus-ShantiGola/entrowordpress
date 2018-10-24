<?php

App::uses('AppController', 'Controller');

/**
 * Toolkits Controller
 *
 * @property Toolkit $Toolkit
 * @property PaginatorComponent $Paginator
 */
class KidpreneurToolkitsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session', 'RequestHandler', 'Paginator');
 public $uses = array('User','KidpreneurToolkit');
    /**
     * index method
     *
     * @return void
     */
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

        if (!$this->Session->read('isAdmin')) {
            if (strtoupper(trim($this->request->params['action'])) == "EDIT" || strtoupper(trim($this->request->params['action'])) == "VIEW" || strtoupper(trim($this->request->params['action'])) == "DELETE") {
                $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => false));
            }
        }

        $loggedInRole=$this->Session->read('roles');
        $userId = $this->Session->read('user_id');
        $context_ary = $this->Session->read('context-array');
        $this->set('title_for_layout', 'My Biz Toolkit');
        ($loggedInRole=='Kidpreneur') ? $this->layout = "kid_layout" : $this->layout = "challenger_new_layout";

        $user_id = $this->Session->read('user_id');       
        $this->loadModel('User');
        $user_info = $this->User->find('first', array('conditions'=>array('User.id'=>$user_id), 'fields'=>array('first_name', 'last_name', 'user_image','country_id','registration_date','gender','username','email_address','parent_id'))); 
        //echo $this->request->params['action']; 
       
        if($user_info['User']['parent_id']!="")
        {
            $parent_info= $this->User->getUserRoleInfo($user_info['User']['parent_id']);
      
        $logged_in_user_addedby=$parent_info[0]['roles']['role'];
        $this->set(compact('logged_in_user_addedby'));}
    }

    public function index() {
         $this->loadModel('kidpreneurToolkit');
        $this->kidpreneurToolkit->recursive = 0;
        $toolkits = $this->kidpreneurToolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));
       // pr($toolkits);
        foreach ($toolkits as $key => $val) {
            if ($val["kidpreneurToolkit"]["parent_id"] <= 0) {
                $arrFile[$val["kidpreneurToolkit"]["id"]]["name"] = $val["kidpreneurToolkit"]["name"];
                $arrFile[$val["kidpreneurToolkit"]["id"]]["short_description"] = $val["kidpreneurToolkit"]["short_description"];
                $arrFile[$val["kidpreneurToolkit"]["id"]]["description"] = $val["kidpreneurToolkit"]["description"];
                $arrFile[$val["kidpreneurToolkit"]["id"]]["created_date"] = $val["kidpreneurToolkit"]["created_date"];
                $arrFile[$val["kidpreneurToolkit"]["id"]]["last_modified_date"] = $val["kidpreneurToolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["title"] = $val["kidpreneurToolkit"]["title"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["type"] = $val["kidpreneurToolkit"]["type"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["name"] = $val["kidpreneurToolkit"]["name"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["short_description"] = $val["kidpreneurToolkit"]["short_description"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["extension"] = $val["kidpreneurToolkit"]["extension"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["description"] = $val["kidpreneurToolkit"]["description"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["created_date"] = $val["kidpreneurToolkit"]["created_date"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["last_modified_date"] = $val["kidpreneurToolkit"]["last_modified_date"];
            }
        }
       // echo "--->";
        uasort($arrFile, function($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        });
        $this->set('arrFile', $arrFile);
       // pr($arrFile);
       // die;
        $this->loadModel('Page');
        $arrPage = $this->Page->findById(18);
        $this->set('arrPage', $arrPage);
    }
     /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit() {
         $this->loadModel('kidpreneurToolkit');
        $this->kidpreneurToolkit->recursive = 0;
        $toolkits = $this->kidpreneurToolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));

        foreach ($toolkits as $key => $val) {
            if ($val["kidpreneurToolkit"]["parent_id"] <= 0) {
                $arrFile[$val["kidpreneurToolkit"]["id"]]["name"] = $val["kidpreneurToolkit"]["name"];
                $arrFile[$val["kidpreneurToolkit"]["id"]]["short_description"] = $val["kidpreneurToolkit"]["short_description"];
                $arrFile[$val["kidpreneurToolkit"]["id"]]["description"] = $val["kidpreneurToolkit"]["description"];
                $arrFile[$val["kidpreneurToolkit"]["id"]]["created_date"] = $val["kidpreneurToolkit"]["created_date"];
                $arrFile[$val["kidpreneurToolkit"]["id"]]["last_modified_date"] = $val["kidpreneurToolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["title"] = $val["kidpreneurToolkit"]["title"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["type"] = $val["kidpreneurToolkit"]["type"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["name"] = $val["kidpreneurToolkit"]["name"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["short_description"] = $val["kidpreneurToolkit"]["short_description"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["extension"] = $val["kidpreneurToolkit"]["extension"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["description"] = $val["kidpreneurToolkit"]["description"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["created_date"] = $val["kidpreneurToolkit"]["created_date"];
                $arrFile[$val["kidpreneurToolkit"]["parent_id"]]["child"][$val["kidpreneurToolkit"]["id"]]["last_modified_date"] = $val["kidpreneurToolkit"]["last_modified_date"];
            }
        }
        uasort($arrFile, function($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        });
        $this->set('arrFile', $arrFile);
        $this->loadModel('Page');
        $arrPage = $this->Page->findById(18);
        $this->set('arrPage', $arrPage);
    }
    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->KidpreneurToolkit->create();

            if (count($this->KidpreneurToolkit->findByName($this->request->data["KidpreneurToolkit"]["name"]))) {
                $result = array("result" => "error", 'message' => 'A folder already exists by this name. Please enter a different folder name.');
            } else {
                if (!isset($this->request->data["KidpreneurToolkit"]["parent_id"])) {
                    $this->request->data["KidpreneurToolkit"]["parent_id"] = 0;
                    $this->request->data["KidpreneurToolkit"]["type"] = "folder";
                    $this->request->data["KidpreneurToolkit"]["extension"] = "";
                    $this->request->data["KidpreneurToolkit"]["added_by"] = $this->Session->read('user_id');
                    $this->request->data["KidpreneurToolkit"]["created_date"] = date('Y-m-d H:i:s');
                }
//                pr($this->request->data);
//                $this->KidpreneurToolkit->save($this->request->data);
//                $errors = $this->KidpreneurToolkit->validationErrors;
//                pr($errors);
                if ($this->KidpreneurToolkit->save($this->request->data)) {
                    echo $this->getListFiles();
                    exit;
                    //$result = array("result" => "success", 'message' => $this->getListFiles());
                } else {
                    $result = array("result" => "error", 'message' => 'Folder could not be uploaded.');
                }
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        }
    }

    public function getListFiles() {
        $this->layout = "ajax";
        $toolkits = $this->KidpreneurToolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));

        foreach ($toolkits as $key => $val) {
            if ($val["KidpreneurToolkit"]["parent_id"] <= 0) {
                $arrFile[$val["KidpreneurToolkit"]["id"]]["name"] = $val["KidpreneurToolkit"]["name"];
                $arrFile[$val["KidpreneurToolkit"]["id"]]["short_description"] = $val["KidpreneurToolkit"]["short_description"];
                $arrFile[$val["KidpreneurToolkit"]["id"]]["description"] = $val["KidpreneurToolkit"]["description"];
                $arrFile[$val["KidpreneurToolkit"]["id"]]["created_date"] = $val["KidpreneurToolkit"]["created_date"];
                $arrFile[$val["KidpreneurToolkit"]["id"]]["last_modified_date"] = $val["KidpreneurToolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["KidpreneurToolkit"]["parent_id"]]["child"][$val["KidpreneurToolkit"]["id"]]["name"] = $val["KidpreneurToolkit"]["name"];
                $arrFile[$val["KidpreneurToolkit"]["parent_id"]]["child"][$val["KidpreneurToolkit"]["id"]]["title"] = $val["KidpreneurToolkit"]["title"];
                $arrFile[$val["KidpreneurToolkit"]["parent_id"]]["child"][$val["KidpreneurToolkit"]["id"]]["type"] = $val["KidpreneurToolkit"]["type"];
                $arrFile[$val["KidpreneurToolkit"]["parent_id"]]["child"][$val["KidpreneurToolkit"]["id"]]["short_description"] = $val["KidpreneurToolkit"]["short_description"];
                $arrFile[$val["KidpreneurToolkit"]["parent_id"]]["child"][$val["KidpreneurToolkit"]["id"]]["extension"] = $val["KidpreneurToolkit"]["extension"];
                $arrFile[$val["KidpreneurToolkit"]["parent_id"]]["child"][$val["KidpreneurToolkit"]["id"]]["description"] = $val["KidpreneurToolkit"]["description"];
                $arrFile[$val["KidpreneurToolkit"]["parent_id"]]["child"][$val["KidpreneurToolkit"]["id"]]["created_date"] = $val["KidpreneurToolkit"]["created_date"];
                $arrFile[$val["KidpreneurToolkit"]["parent_id"]]["child"][$val["KidpreneurToolkit"]["id"]]["last_modified_date"] = $val["KidpreneurToolkit"]["last_modified_date"];
            }
        }
        uasort($arrFile, function($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        });
        $this->set('arrFile', $arrFile);
        return $result = $this->render('/Elements/kid_file_list_elements');
    }

    
    public function edit_folder($id = null) {
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->KidpreneurToolkit->exists($this->request->data["KidpreneurToolkit"]['id'])) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            }
            $this->request->data["KidpreneurToolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
            if (count($this->KidpreneurToolkit->find('list', array('conditions' => array('id NOT' => $this->request->data["KidpreneurToolkit"]['id'], 'name' => $this->request->data["KidpreneurToolkit"]['name']))))) {
                $result = array("result" => "error", 'message' => 'Folder name should be unique. Already exists with name "' . $this->request->data["KidpreneurToolkit"]["name"] . '"');
            } elseif ($this->KidpreneurToolkit->save($this->request->data)) {
                echo $this->getListFiles();
                exit;
            } else {
                $result = array("result" => "error", 'message' => 'Folder information couldnot updated.');
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        } else {
            $options = array('conditions' => array('Toolkit.' . $this->KidpreneurToolkit->primaryKey => $id));
            $this->request->data = $this->KidpreneurToolkit->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete() {
        if (strpos($this->request->data["id"], "~") !== false) {
            $arrFilesId = explode("~", $this->request->data["id"]);
        } else {
            $arrFilesId = $this->request->data["id"];
        }

        //$this->KidpreneurToolkit->id = $this->request->data['id'];
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->KidpreneurToolkit->exists()) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            }

            $this->request->onlyAllow('post', 'delete');
            $filelist = ($this->KidpreneurToolkit->find('list', array('conditions' => array('parent_id' => $arrFilesId, 'type NOT'=>'youtube'))));
            foreach ($filelist as $k => $v) {
                if (!unlink(WWW_ROOT . "files" . DS . $v)) {
                    $result = "Error to remove files";
                }
            }
            $this->KidpreneurToolkit->deleteAll(array('parent_id' => $arrFilesId));
            if ($this->KidpreneurToolkit->deleteAll(array('id' => $arrFilesId))) {
                echo $this->getListFiles();
                exit;
            } else {
                $result = array("result" => "error", 'message' => 'Folder could not deleted.');
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        } else {
            $options = array('conditions' => array('Toolkit.' . $this->KidpreneurToolkit->primaryKey => $id));
            $this->request->data = $this->KidpreneurToolkit->find('first', $options);
        }
    }

    public function add_file() {
        
        if (isset($this->request->data["KidpreneurToolkit"]["title"]) && $this->request->data["KidpreneurToolkit"]["title"] != "") {
            if (count($this->KidpreneurToolkit->find('all', array('conditions' => array('title' => $this->request->data["KidpreneurToolkit"]["title"]))))) {
                $result = array("result" => "error", 'message' => 'Specified title already exists. Please choose another title.');
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            }
        } elseif (isset($this->request->data["title"]) && $this->request->data["title"] != "") {
            if (count($this->KidpreneurToolkit->find('all', array('conditions' => array('title' => $this->request->data["title"]))))) {
                $result = array("result" => "error", 'message' => 'Specified title already exists. Please choose another title.');
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            }
        }
        $uploadFolder = "files";
        //full path to upload folder
        $uploadPath = WWW_ROOT . $uploadFolder;
        $outPut = array();
        $this->KidpreneurToolkit->create();
        if (isset($this->request->data["KidpreneurToolkit"]["type"]) && ($this->request->data["KidpreneurToolkit"]["type"] == "youtube" || $this->request->data["KidpreneurToolkit"]["type"] == "link")) {
            
            $this->request->data["KidpreneurToolkit"]["parent_id"] = $this->request->data["folder_id"];
            $this->request->data["KidpreneurToolkit"]["short_description"] = $this->request->data["KidpreneurToolkit"]["short_description"];
            $this->request->data["KidpreneurToolkit"]["name"] = (isset($this->request->data["KidpreneurToolkit"]["video_url"]))?$this->request->data["KidpreneurToolkit"]["video_url"]:$this->request->data["KidpreneurToolkit"]["link_url"];
            $this->request->data["KidpreneurToolkit"]["title"] = $this->request->data["KidpreneurToolkit"]["title"];
            $this->request->data["KidpreneurToolkit"]["short_description"] = $this->request->data["KidpreneurToolkit"]["short_description"];
            $this->request->data["KidpreneurToolkit"]["type"] = $this->request->data["KidpreneurToolkit"]["type"];
            $this->request->data["KidpreneurToolkit"]["extension"] = "";
            $this->request->data["KidpreneurToolkit"]["added_by"] = $this->Session->read('user_id');
            $this->request->data["KidpreneurToolkit"]["created_date"] = date('Y-m-d H:i:s');
            
            if (!$this->KidpreneurToolkit->save($this->request->data)) {
//                                $errors = $this->KidpreneurToolkit->invalidFields(); ;
//                pr($errors);
//                echo $this->KidpreneurToolkit->getLastQuery();
//                die;
                $result = array("result" => "error", 'message' => 'File could not be uploaded.');
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            }
            $this->update_folder_modified_date($this->KidpreneurToolkit->getLastInsertID());
            echo $this->getListFiles();
            exit;
        } else {
            foreach ($_FILES as $k => $files) {
                $fileTypes = $files["type"];

                // to find first args of fileType 
                $args = explode('/', $fileTypes);
                $fileType = @$args[0];
                $fileName = $this->validName($files["name"]);

                $fileTempName = $files['tmp_name'];

                $fileFullPath = $uploadFolder . '/' . $fileName;
                $arrName = explode(".", $fileName);
                $extn = $arrName[count($arrName) - 1];
                if (move_uploaded_file($fileTempName, $fileFullPath)) {
                    $this->KidpreneurToolkit->create();
                    $this->request->data["KidpreneurToolkit"]["parent_id"] = $this->request->data["folder_id"];
                    $this->request->data["KidpreneurToolkit"]["title"] = $this->request->data["title"];
                    $this->request->data["KidpreneurToolkit"]["short_description"] = $this->request->data["short_desc"];
                    $this->request->data["KidpreneurToolkit"]["name"] = $fileName;
                    $this->request->data["KidpreneurToolkit"]["type"] = $fileType;
                    $this->request->data["KidpreneurToolkit"]["extension"] = $extn;
                    $this->request->data["KidpreneurToolkit"]["added_by"] = $this->Session->read('user_id');
                    $this->request->data["KidpreneurToolkit"]["created_date"] = date('Y-m-d H:i:s');
                    if ($this->KidpreneurToolkit->save($this->request->data)) {
                        $this->update_folder_modified_date($this->KidpreneurToolkit->getLastInsertID());
                        //$result = array("result" => "success", 'message' => 'File is uploaded succesfully.');
                        echo $this->getListFiles();
                        exit;
                    } else {
                        $result = array("result" => "error", 'message' => 'File could not be uploaded.');
                        header("Content-type: application/json"); // not necessary
                        echo json_encode($result);
                        exit;
                    }
                } else {
                    $result = array("result" => "error", 'message' => 'File could not uploaded.');
                }
            }
        }
        //echo json_encode($outPut);
    }

    public function edit_file($id = null) {
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->KidpreneurToolkit->exists($this->request->data["KidpreneurToolkit"]['id'])) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            } else {
                $toolkit = $this->KidpreneurToolkit->findById($this->request->data["KidpreneurToolkit"]['id']);

                if (count($this->KidpreneurToolkit->find('all', array('conditions' => array('id NOT' => $this->request->data["KidpreneurToolkit"]['id'], 'title' => $this->request->data["KidpreneurToolkit"]['title'], 'type NOT' => 'folder')))) > 0) {
                    $result = array("result" => "error", 'message' => 'There is already a file with same title.');
                } else {
                    $this->request->data["KidpreneurToolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
                    if ($this->KidpreneurToolkit->save($this->request->data)) {
                        $this->update_folder_modified_date($this->request->data["KidpreneurToolkit"]['id']);
                        echo $this->getListFiles();
                        exit;
                    } else {
                        $result = array("result" => "error", 'message' => 'File information couldnot updated.');
                        header("Content-type: application/json"); // not necessary
                        echo json_encode($result);
                        exit;
                    }
                }
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        } else {
            $options = array('conditions' => array('Toolkit.' . $this->KidpreneurToolkit->primaryKey => $id));
            $this->request->data = $this->KidpreneurToolkit->find('first', $options);
        }
    }

    public function delete_file() {
        if (strpos($this->request->data["id"], "~") !== false) {
            $arrFilesId = explode("~", $this->request->data["id"]);
        } else {
            $arrFilesId = $this->request->data["id"];
        }

        $filelist = ($this->KidpreneurToolkit->find('all', array('conditions' => array('id' => $arrFilesId))));
        
        foreach ($filelist as $k => $v) {
            if ($v["KidpreneurToolkit"]["type"] != "youtube") {
                if (!unlink(WWW_ROOT . "files" . DS . $v["KidpreneurToolkit"]["name"])) {
                    $result = "Error to remove files";
                }
            }
        }

        if ($this->KidpreneurToolkit->deleteAll(array('id' => $arrFilesId))) {
            echo $this->getListFiles();
            exit;
        } else {
            $result = array("result" => "error", 'message' => 'Folder could not deleted.');
        }
        header("Content-type: application/json"); // not necessary
        echo json_encode($result);
        exit;
    }

    public function download_file($id = null) {
        if ($id != null) {
            $toolkit = $this->KidpreneurToolkit->findAllById($id);
            $fullname = $toolkit[0]["KidpreneurToolkit"]["name"];
            $nameArr = explode('.', $fullname);
            $extension = $nameArr[count($nameArr) - 1];
            $name = substr($fullname, 0, (strlen($fullname) - (strlen($extension)) - 1));
        }
        $this->viewClass = 'Media';
        // Download app/outside_webroot_dir/example.zip
        $params = array(
            'id' => $fullname,
            'name' => $name,
            'extension' => $toolkit[0]["KidpreneurToolkit"]["extension"],
            'download' => true,
            'path' => 'webroot' . DS . 'files' . DS  // file path
        );
        $this->set($params);
    }

    public function validName($fullname) {
        $nameArr = explode('.', $fullname);
        $extension = $nameArr[count($nameArr) - 1];
        $name = substr($fullname, 0, (strlen($fullname) - (strlen($extension)) - 1));

        if (count($this->KidpreneurToolkit->find('all', array('conditions' => array('name' => $fullname))))) {
            $file = $this->KidpreneurToolkit->find('all', array('conditions' => array('name LIKE ' => "$name-copy%", 'extension' => $extension), 'order' => 'id DESC', 'LIMIT' => 1));

            if (count($file)) {
                $tmpName = ($name . "-" . "copy" . (count($file) + 2));
            } else {
                $tmpName = $name . "-" . "copy2";
            }
            $tmpName .= "." . $extension;
        } else {
            $tmpName = $fullname;
        }
        return $tmpName;
    }

    public function search_files($type = null) {
        //Verify that file is exist with same name
        if ($this->request->is(array('post', 'put'))) {
            if ($type == 1) {
                $this->set('type', $type);
            }
            if ($this->request->data["text"] != "") {
                $arrFiles = $this->KidpreneurToolkit->find('all', array('conditions' => array('title LIKE' => "%" . trim($this->request->data["text"]) . "%")));
            } else {
                echo $this->getListFiles();
                exit;
            }
            if (count($arrFiles) > 0) {
                $this->set('arrFiles', $arrFiles);
                /*if ($type == 1) {
                    $this->set('type', $type);
                }*/
                return $result = $this->render('/Elements/search_kid_result_list_elements');
                exit;
            } else {
                $result = array("result" => "error", 'message' => 'No record found.');
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            }
        }
    }

    public function edit_description() {
        if ($this->request->is(array('post', 'put'))) {
            if ($this->request->data["KidpreneurToolkit"]["id"] != "" && $this->request->data["KidpreneurToolkit"]["description"] != "") {
                $this->request->data["KidpreneurToolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
                $this->KidpreneurToolkit->save($this->request->data);
            }
            echo $this->getListFiles();
            exit;

            /* if (count($arrFiles) > 0) {
              $this->set('arrFiles', $arrFiles);
              return $result = $this->render('/Elements/search_result_list_elements');
              exit;
              } else {
              $result = array("result" => "error", 'message' => 'No record found.');
              header("Content-type: application/json"); // not necessary
              echo json_encode($result);
              exit;
              } */
        }
    }
    
    public function update_folder_modified_date($file_id)
    {
        $arrToolkit = $this->KidpreneurToolkit->find('list', array('conditions' => array('id'=>$file_id), 'fields'=>array('parent_id')));
        $this->KidpreneurToolkit->query('UPDATE kidpreneur_toolkits SET last_modified_date="'.date('Y-m-d H:i:s').'" WHERE id IN ('.$arrToolkit[$file_id].')');
    }


}
