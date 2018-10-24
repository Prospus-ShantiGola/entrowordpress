<?php

App::uses('AppController', 'Controller');

/**
 * Toolkits Controller
 *
 * @property Toolkit $Toolkit
 * @property PaginatorComponent $Paginator
 */
class ToolkitsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Session', 'RequestHandler', 'Paginator');

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
         
        $this->layout = 'challenger_new_layout';
        $userId = $this->Session->read('user_id');
        $context_ary = $this->Session->read('context-array');
        $this->set('title_for_layout', 'Kidpreneur challenge toolkit');
        $this->layout = "challenger_new_layout";
    }

    public function index() {
        $this->Toolkit->recursive = 0;
        $toolkits = $this->Toolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));
       // pr($toolkits);
        
        foreach ($toolkits as $key => $val) {
            if ($val["Toolkit"]["parent_id"] <= 0) {
                $arrFile[$val["Toolkit"]["id"]]["name"] = $val["Toolkit"]["name"];
                $arrFile[$val["Toolkit"]["id"]]["short_description"] = $val["Toolkit"]["short_description"];
                $arrFile[$val["Toolkit"]["id"]]["description"] = $val["Toolkit"]["description"];
                $arrFile[$val["Toolkit"]["id"]]["created_date"] = $val["Toolkit"]["created_date"];
                $arrFile[$val["Toolkit"]["id"]]["last_modified_date"] = $val["Toolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["title"] = $val["Toolkit"]["title"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["type"] = $val["Toolkit"]["type"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["name"] = $val["Toolkit"]["name"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["short_description"] = $val["Toolkit"]["short_description"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["extension"] = $val["Toolkit"]["extension"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["description"] = $val["Toolkit"]["description"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["created_date"] = $val["Toolkit"]["created_date"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["last_modified_date"] = $val["Toolkit"]["last_modified_date"];
            }
        }
        $allowedPayment=false;
        if($this->Session->read('isAdmin') || strtoupper($this->Session->read('roles')) == strtoupper("parent")){
            $allowedPayment=true;
        }
       // echo "--->";
        uasort($arrFile, function($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        });
        $this->set('arrFile', $arrFile);
        
       // pr($arrFile);
       // die;
        $this->loadModel('Page');
        $arrPage = $this->Page->findById(16);
        $this->set('arrPage', $arrPage);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Toolkit->exists($id)) {
            throw new NotFoundException(__('Invalid toolkit'));
        }
        $options = array('conditions' => array('Toolkit.' . $this->Toolkit->primaryKey => $id));
        $this->set('toolkit', $this->Toolkit->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Toolkit->create();

            if (count($this->Toolkit->findByName($this->request->data["Toolkit"]["name"]))) {
                $result = array("result" => "error", 'message' => 'A folder already exists by this name. Please enter a different folder name.');
            } else {
                if (!isset($this->request->data["Toolkit"]["parent_id"])) {
                    $this->request->data["Toolkit"]["parent_id"] = 0;
                    $this->request->data["Toolkit"]["type"] = "folder";
                    $this->request->data["Toolkit"]["extension"] = "";
                    $this->request->data["Toolkit"]["added_by"] = $this->Session->read('user_id');
                    $this->request->data["Toolkit"]["created_date"] = date('Y-m-d H:i:s');
                }
                if ($this->Toolkit->save($this->request->data)) {
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
        $toolkits = $this->Toolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));

        foreach ($toolkits as $key => $val) {
            if ($val["Toolkit"]["parent_id"] <= 0) {
                $arrFile[$val["Toolkit"]["id"]]["name"] = $val["Toolkit"]["name"];
                $arrFile[$val["Toolkit"]["id"]]["short_description"] = $val["Toolkit"]["short_description"];
                $arrFile[$val["Toolkit"]["id"]]["description"] = $val["Toolkit"]["description"];
                $arrFile[$val["Toolkit"]["id"]]["created_date"] = $val["Toolkit"]["created_date"];
                $arrFile[$val["Toolkit"]["id"]]["last_modified_date"] = $val["Toolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["name"] = $val["Toolkit"]["name"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["title"] = $val["Toolkit"]["title"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["type"] = $val["Toolkit"]["type"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["short_description"] = $val["Toolkit"]["short_description"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["extension"] = $val["Toolkit"]["extension"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["description"] = $val["Toolkit"]["description"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["created_date"] = $val["Toolkit"]["created_date"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["last_modified_date"] = $val["Toolkit"]["last_modified_date"];
            }
        }
        uasort($arrFile, function($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        });
        $this->set('arrFile', $arrFile);
        return $result = $this->render('/Elements/file_list_elements');
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit() {
        
        $this->Toolkit->recursive = 0;
        $toolkits = $this->Toolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));

        foreach ($toolkits as $key => $val) {
            if ($val["Toolkit"]["parent_id"] <= 0) {
                $arrFile[$val["Toolkit"]["id"]]["name"] = $val["Toolkit"]["name"];
                $arrFile[$val["Toolkit"]["id"]]["short_description"] = $val["Toolkit"]["short_description"];
                $arrFile[$val["Toolkit"]["id"]]["description"] = $val["Toolkit"]["description"];
                $arrFile[$val["Toolkit"]["id"]]["created_date"] = $val["Toolkit"]["created_date"];
                $arrFile[$val["Toolkit"]["id"]]["last_modified_date"] = $val["Toolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["title"] = $val["Toolkit"]["title"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["type"] = $val["Toolkit"]["type"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["name"] = $val["Toolkit"]["name"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["short_description"] = $val["Toolkit"]["short_description"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["extension"] = $val["Toolkit"]["extension"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["description"] = $val["Toolkit"]["description"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["created_date"] = $val["Toolkit"]["created_date"];
                $arrFile[$val["Toolkit"]["parent_id"]]["child"][$val["Toolkit"]["id"]]["last_modified_date"] = $val["Toolkit"]["last_modified_date"];
            }
        }
        uasort($arrFile, function($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        });
        $this->set('arrFile', $arrFile);
        $this->loadModel('Page');
        $arrPage = $this->Page->findById(16);
        $this->set('arrPage', $arrPage);
    }
    
    public function edit_folder($id = null) {
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->Toolkit->exists($this->request->data["Toolkit"]['id'])) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            }
            $this->request->data["Toolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
            if (count($this->Toolkit->find('list', array('conditions' => array('id NOT' => $this->request->data["Toolkit"]['id'], 'name' => $this->request->data["Toolkit"]['name']))))) {
                $result = array("result" => "error", 'message' => 'Folder name should be unique. Already exists with name "' . $this->request->data["Toolkit"]["name"] . '"');
            } elseif ($this->Toolkit->save($this->request->data)) {
                echo $this->getListFiles();
                exit;
            } else {
                $result = array("result" => "error", 'message' => 'Folder information couldnot updated.');
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        } else {
            $options = array('conditions' => array('Toolkit.' . $this->Toolkit->primaryKey => $id));
            $this->request->data = $this->Toolkit->find('first', $options);
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

        //$this->Toolkit->id = $this->request->data['id'];
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->Toolkit->exists()) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            }

            $this->request->onlyAllow('post', 'delete');
            $filelist = ($this->Toolkit->find('list', array('conditions' => array('parent_id' => $arrFilesId, 'type NOT'=>'youtube'))));
            foreach ($filelist as $k => $v) {
                if (!unlink(WWW_ROOT . "files" . DS . $v)) {
                    $result = "Error to remove files";
                }
            }
            $this->Toolkit->deleteAll(array('parent_id' => $arrFilesId));
            if ($this->Toolkit->deleteAll(array('id' => $arrFilesId))) {
                echo $this->getListFiles();
                exit;
            } else {
                $result = array("result" => "error", 'message' => 'Folder could not deleted.');
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        } else {
            $options = array('conditions' => array('Toolkit.' . $this->Toolkit->primaryKey => $id));
            $this->request->data = $this->Toolkit->find('first', $options);
        }
    }

    public function add_file() {
        
        if (isset($this->request->data["Toolkit"]["title"]) && $this->request->data["Toolkit"]["title"] != "") {
            if (count($this->Toolkit->find('all', array('conditions' => array('title' => $this->request->data["Toolkit"]["title"]))))) {
                $result = array("result" => "error", 'message' => 'Specified title already exists. Please choose another title.');
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            }
        } elseif (isset($this->request->data["title"]) && $this->request->data["title"] != "") {
            if (count($this->Toolkit->find('all', array('conditions' => array('title' => $this->request->data["title"]))))) {
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
        $this->Toolkit->create();
        if (isset($this->request->data["Toolkit"]["type"]) && ($this->request->data["Toolkit"]["type"] == "youtube" || $this->request->data["Toolkit"]["type"] == "link")) {
            
            $this->request->data["Toolkit"]["parent_id"] = $this->request->data["folder_id"];
            $this->request->data["Toolkit"]["short_description"] = $this->request->data["Toolkit"]["short_description"];
            $this->request->data["Toolkit"]["name"] = (isset($this->request->data["Toolkit"]["video_url"]))?$this->request->data["Toolkit"]["video_url"]:$this->request->data["Toolkit"]["link_url"];
            $this->request->data["Toolkit"]["title"] = $this->request->data["Toolkit"]["title"];
            $this->request->data["Toolkit"]["short_description"] = $this->request->data["Toolkit"]["short_description"];
            $this->request->data["Toolkit"]["type"] = $this->request->data["Toolkit"]["type"];
            $this->request->data["Toolkit"]["extension"] = "";
            $this->request->data["Toolkit"]["added_by"] = $this->Session->read('user_id');
            $this->request->data["Toolkit"]["created_date"] = date('Y-m-d H:i:s');
            
            if (!$this->Toolkit->save($this->request->data)) {
//                                $errors = $this->Toolkit->invalidFields(); ;
//                pr($errors);
//                echo $this->Toolkit->getLastQuery();
//                die;
                $result = array("result" => "error", 'message' => 'File could not be uploaded.');
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            }
            $this->update_folder_modified_date($this->Toolkit->getLastInsertID());
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
                    $this->Toolkit->create();
                    $this->request->data["Toolkit"]["parent_id"] = $this->request->data["folder_id"];
                    $this->request->data["Toolkit"]["title"] = $this->request->data["title"];
                    $this->request->data["Toolkit"]["short_description"] = $this->request->data["short_desc"];
                    $this->request->data["Toolkit"]["name"] = $fileName;
                    $this->request->data["Toolkit"]["type"] = $fileType;
                    $this->request->data["Toolkit"]["extension"] = $extn;
                    $this->request->data["Toolkit"]["added_by"] = $this->Session->read('user_id');
                    $this->request->data["Toolkit"]["created_date"] = date('Y-m-d H:i:s');
                    if ($this->Toolkit->save($this->request->data)) {
                        $this->update_folder_modified_date($this->Toolkit->getLastInsertID());
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
            if (!$this->Toolkit->exists($this->request->data["Toolkit"]['id'])) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            } else {
                $toolkit = $this->Toolkit->findById($this->request->data["Toolkit"]['id']);

                if (count($this->Toolkit->find('all', array('conditions' => array('id NOT' => $this->request->data["Toolkit"]['id'], 'title' => $this->request->data["Toolkit"]['title'], 'type NOT' => 'folder')))) > 0) {
                    $result = array("result" => "error", 'message' => 'There is already a file with same title.');
                } else {
                    $this->request->data["Toolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
                    if ($this->Toolkit->save($this->request->data)) {
                        $this->update_folder_modified_date($this->request->data["Toolkit"]['id']);
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
            $options = array('conditions' => array('Toolkit.' . $this->Toolkit->primaryKey => $id));
            $this->request->data = $this->Toolkit->find('first', $options);
        }
    }

    public function delete_file() {
        if (strpos($this->request->data["id"], "~") !== false) {
            $arrFilesId = explode("~", $this->request->data["id"]);
        } else {
            $arrFilesId = $this->request->data["id"];
        }

        $filelist = ($this->Toolkit->find('all', array('conditions' => array('id' => $arrFilesId))));
        
        foreach ($filelist as $k => $v) {
            if ($v["Toolkit"]["type"] != "youtube") {
                if (!unlink(WWW_ROOT . "files" . DS . $v["Toolkit"]["name"])) {
                    $result = "Error to remove files";
                }
            }
        }

        if ($this->Toolkit->deleteAll(array('id' => $arrFilesId))) {
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
            $toolkit = $this->Toolkit->findAllById($id);
            $fullname = $toolkit[0]["Toolkit"]["name"];
            $nameArr = explode('.', $fullname);
            $extension = $nameArr[count($nameArr) - 1];
            $name = substr($fullname, 0, (strlen($fullname) - (strlen($extension)) - 1));
        }
        $this->viewClass = 'Media';
        // Download app/outside_webroot_dir/example.zip
        $params = array(
            'id' => $fullname,
            'name' => $name,
            'extension' => $toolkit[0]["Toolkit"]["extension"],
            'download' => true,
            'path' => 'webroot' . DS . 'files' . DS  // file path
        );
        $this->set($params);
    }

    public function validName($fullname) {
        $nameArr = explode('.', $fullname);
        $extension = $nameArr[count($nameArr) - 1];
        $name = substr($fullname, 0, (strlen($fullname) - (strlen($extension)) - 1));

        if (count($this->Toolkit->find('all', array('conditions' => array('name' => $fullname))))) {
            $file = $this->Toolkit->find('all', array('conditions' => array('name LIKE ' => "$name-copy%", 'extension' => $extension), 'order' => 'id DESC', 'LIMIT' => 1));

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
                $arrFiles = $this->Toolkit->find('all', array('conditions' => array('title LIKE' => "%" . trim($this->request->data["text"]) . "%")));
            } else {
                echo $this->getListFiles();
                exit;
            }
            if (count($arrFiles) > 0) {
                $this->set('arrFiles', $arrFiles);
                /*if ($type == 1) {
                    $this->set('type', $type);
                }*/
                return $result = $this->render('/Elements/search_result_list_elements');
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
            if ($this->request->data["Toolkit"]["id"] != "" && $this->request->data["Toolkit"]["description"] != "") {
                $this->request->data["Toolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
                $this->Toolkit->save($this->request->data);
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
        $arrToolkit = $this->Toolkit->find('list', array('conditions' => array('id'=>$file_id), 'fields'=>array('parent_id')));
        $this->Toolkit->query('UPDATE toolkits SET last_modified_date="'.date('Y-m-d H:i:s').'" WHERE id IN ('.$arrToolkit[$file_id].')');
    }

}
