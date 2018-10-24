<?php

App::uses('AppController', 'Controller');

/**
 * Toolkits Controller
 *
 * @property Toolkit $Toolkit
 * @property PaginatorComponent $Paginator
 */
class ParentToolkitsController extends AppController {

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

        $userId = $this->Session->read('user_id');
        $context_ary = $this->Session->read('context-array');
        $this->set('title_for_layout', 'Kidpreneur challenge toolkit');
        $this->layout = "challenger_new_layout";
    }

    public function index() {
        $this->ParentToolkit->recursive = 0;
        $toolkits = $this->ParentToolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));
       // pr($toolkits);
        foreach ($toolkits as $key => $val) {
            if ($val["ParentToolkit"]["parent_id"] <= 0) {
                $arrFile[$val["ParentToolkit"]["id"]]["name"] = $val["ParentToolkit"]["name"];
                $arrFile[$val["ParentToolkit"]["id"]]["short_description"] = $val["ParentToolkit"]["short_description"];
                $arrFile[$val["ParentToolkit"]["id"]]["description"] = $val["ParentToolkit"]["description"];
                $arrFile[$val["ParentToolkit"]["id"]]["created_date"] = $val["ParentToolkit"]["created_date"];
                $arrFile[$val["ParentToolkit"]["id"]]["last_modified_date"] = $val["ParentToolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["title"] = $val["ParentToolkit"]["title"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["type"] = $val["ParentToolkit"]["type"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["name"] = $val["ParentToolkit"]["name"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["short_description"] = $val["ParentToolkit"]["short_description"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["extension"] = $val["ParentToolkit"]["extension"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["description"] = $val["ParentToolkit"]["description"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["created_date"] = $val["ParentToolkit"]["created_date"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["last_modified_date"] = $val["ParentToolkit"]["last_modified_date"];
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
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->ParentToolkit->exists($id)) {
            throw new NotFoundException(__('Invalid toolkit'));
        }
        $options = array('conditions' => array('Toolkit.' . $this->ParentToolkit->primaryKey => $id));
        $this->set('toolkit', $this->ParentToolkit->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->ParentToolkit->create();

            if (count($this->ParentToolkit->findByName($this->request->data["ParentToolkit"]["name"]))) {
                $result = array("result" => "error", 'message' => 'A folder already exists by this name. Please enter a different folder name.');
            } else {
                if (!isset($this->request->data["ParentToolkit"]["parent_id"])) {
                    $this->request->data["ParentToolkit"]["parent_id"] = 0;
                    $this->request->data["ParentToolkit"]["type"] = "folder";
                    $this->request->data["ParentToolkit"]["extension"] = "";
                    $this->request->data["ParentToolkit"]["added_by"] = $this->Session->read('user_id');
                    $this->request->data["ParentToolkit"]["created_date"] = date('Y-m-d H:i:s');
                }
                if ($this->ParentToolkit->save($this->request->data)) {
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
        $toolkits = $this->ParentToolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));

        foreach ($toolkits as $key => $val) {
            if ($val["ParentToolkit"]["parent_id"] <= 0) {
                $arrFile[$val["ParentToolkit"]["id"]]["name"] = $val["ParentToolkit"]["name"];
                $arrFile[$val["ParentToolkit"]["id"]]["short_description"] = $val["ParentToolkit"]["short_description"];
                $arrFile[$val["ParentToolkit"]["id"]]["description"] = $val["ParentToolkit"]["description"];
                $arrFile[$val["ParentToolkit"]["id"]]["created_date"] = $val["ParentToolkit"]["created_date"];
                $arrFile[$val["ParentToolkit"]["id"]]["last_modified_date"] = $val["ParentToolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["name"] = $val["ParentToolkit"]["name"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["title"] = $val["ParentToolkit"]["title"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["type"] = $val["ParentToolkit"]["type"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["short_description"] = $val["ParentToolkit"]["short_description"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["extension"] = $val["ParentToolkit"]["extension"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["description"] = $val["ParentToolkit"]["description"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["created_date"] = $val["ParentToolkit"]["created_date"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["last_modified_date"] = $val["ParentToolkit"]["last_modified_date"];
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
        
        $this->ParentToolkit->recursive = 0;
        $toolkits = $this->ParentToolkit->find('all', array('order' => 'CAST(title AS UNSIGNED), CAST(name AS UNSIGNED)'));

        foreach ($toolkits as $key => $val) {
            if ($val["ParentToolkit"]["parent_id"] <= 0) {
                $arrFile[$val["ParentToolkit"]["id"]]["name"] = $val["ParentToolkit"]["name"];
                $arrFile[$val["ParentToolkit"]["id"]]["short_description"] = $val["ParentToolkit"]["short_description"];
                $arrFile[$val["ParentToolkit"]["id"]]["description"] = $val["ParentToolkit"]["description"];
                $arrFile[$val["ParentToolkit"]["id"]]["created_date"] = $val["ParentToolkit"]["created_date"];
                $arrFile[$val["ParentToolkit"]["id"]]["last_modified_date"] = $val["ParentToolkit"]["last_modified_date"];
            } else {
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["title"] = $val["ParentToolkit"]["title"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["type"] = $val["ParentToolkit"]["type"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["name"] = $val["ParentToolkit"]["name"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["short_description"] = $val["ParentToolkit"]["short_description"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["extension"] = $val["ParentToolkit"]["extension"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["description"] = $val["ParentToolkit"]["description"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["created_date"] = $val["ParentToolkit"]["created_date"];
                $arrFile[$val["ParentToolkit"]["parent_id"]]["child"][$val["ParentToolkit"]["id"]]["last_modified_date"] = $val["ParentToolkit"]["last_modified_date"];
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
    
    public function edit_folder($id = null) {
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->ParentToolkit->exists($this->request->data["ParentToolkit"]['id'])) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            }
            $this->request->data["ParentToolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
            if (count($this->ParentToolkit->find('list', array('conditions' => array('id NOT' => $this->request->data["ParentToolkit"]['id'], 'name' => $this->request->data["ParentToolkit"]['name']))))) {
                $result = array("result" => "error", 'message' => 'Folder name should be unique. Already exists with name "' . $this->request->data["ParentToolkit"]["name"] . '"');
            } elseif ($this->ParentToolkit->save($this->request->data)) {
                echo $this->getListFiles();
                exit;
            } else {
                $result = array("result" => "error", 'message' => 'Folder information couldnot updated.');
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        } else {
            $options = array('conditions' => array('Toolkit.' . $this->ParentToolkit->primaryKey => $id));
            $this->request->data = $this->ParentToolkit->find('first', $options);
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

        //$this->ParentToolkit->id = $this->request->data['id'];
        if ($this->request->is(array('post', 'put'))) {
            if (!$this->ParentToolkit->exists()) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            }

            $this->request->onlyAllow('post', 'delete');
            $filelist = ($this->ParentToolkit->find('list', array('conditions' => array('parent_id' => $arrFilesId, 'type NOT'=>'youtube'))));
            foreach ($filelist as $k => $v) {
                if (!unlink(WWW_ROOT . "files" . DS . $v)) {
                    $result = "Error to remove files";
                }
            }
            $this->ParentToolkit->deleteAll(array('parent_id' => $arrFilesId));
            if ($this->ParentToolkit->deleteAll(array('id' => $arrFilesId))) {
                echo $this->getListFiles();
                exit;
            } else {
                $result = array("result" => "error", 'message' => 'Folder could not deleted.');
            }
            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
        } else {
            $options = array('conditions' => array('Toolkit.' . $this->ParentToolkit->primaryKey => $id));
            $this->request->data = $this->ParentToolkit->find('first', $options);
        }
    }

    public function add_file() {
        
        if (isset($this->request->data["ParentToolkit"]["title"]) && $this->request->data["ParentToolkit"]["title"] != "") {
            if (count($this->ParentToolkit->find('all', array('conditions' => array('title' => $this->request->data["ParentToolkit"]["title"]))))) {
                $result = array("result" => "error", 'message' => 'Specified title already exists. Please choose another title.');
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            }
        } elseif (isset($this->request->data["title"]) && $this->request->data["title"] != "") {
            if (count($this->ParentToolkit->find('all', array('conditions' => array('title' => $this->request->data["title"]))))) {
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
        $this->ParentToolkit->create();
        if (isset($this->request->data["ParentToolkit"]["type"]) && ($this->request->data["ParentToolkit"]["type"] == "youtube" || $this->request->data["ParentToolkit"]["type"] == "link")) {
            
            $this->request->data["ParentToolkit"]["parent_id"] = $this->request->data["folder_id"];
            $this->request->data["ParentToolkit"]["short_description"] = $this->request->data["ParentToolkit"]["short_description"];
            $this->request->data["ParentToolkit"]["name"] = (isset($this->request->data["ParentToolkit"]["video_url"]))?$this->request->data["ParentToolkit"]["video_url"]:$this->request->data["ParentToolkit"]["link_url"];
            $this->request->data["ParentToolkit"]["title"] = $this->request->data["ParentToolkit"]["title"];
            $this->request->data["ParentToolkit"]["short_description"] = $this->request->data["ParentToolkit"]["short_description"];
            $this->request->data["ParentToolkit"]["type"] = $this->request->data["ParentToolkit"]["type"];
            $this->request->data["ParentToolkit"]["extension"] = "";
            $this->request->data["ParentToolkit"]["added_by"] = $this->Session->read('user_id');
            $this->request->data["ParentToolkit"]["created_date"] = date('Y-m-d H:i:s');
            
            if (!$this->ParentToolkit->save($this->request->data)) {
//                                $errors = $this->ParentToolkit->invalidFields(); ;
//                pr($errors);
//                echo $this->ParentToolkit->getLastQuery();
//                die;
                $result = array("result" => "error", 'message' => 'File could not be uploaded.');
                header("Content-type: application/json"); // not necessary
                echo json_encode($result);
                exit;
            }
            $this->update_folder_modified_date($this->ParentToolkit->getLastInsertID());
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
                    $this->ParentToolkit->create();
                    $this->request->data["ParentToolkit"]["parent_id"] = $this->request->data["folder_id"];
                    $this->request->data["ParentToolkit"]["title"] = $this->request->data["title"];
                    $this->request->data["ParentToolkit"]["short_description"] = $this->request->data["short_desc"];
                    $this->request->data["ParentToolkit"]["name"] = $fileName;
                    $this->request->data["ParentToolkit"]["type"] = $fileType;
                    $this->request->data["ParentToolkit"]["extension"] = $extn;
                    $this->request->data["ParentToolkit"]["added_by"] = $this->Session->read('user_id');
                    $this->request->data["ParentToolkit"]["created_date"] = date('Y-m-d H:i:s');
                    if ($this->ParentToolkit->save($this->request->data)) {
                        $this->update_folder_modified_date($this->ParentToolkit->getLastInsertID());
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
            if (!$this->ParentToolkit->exists($this->request->data["ParentToolkit"]['id'])) {
                $result = array("result" => "error", 'message' => 'Invalid folder detail.');
            } else {
                $toolkit = $this->ParentToolkit->findById($this->request->data["ParentToolkit"]['id']);

                if (count($this->ParentToolkit->find('all', array('conditions' => array('id NOT' => $this->request->data["ParentToolkit"]['id'], 'title' => $this->request->data["ParentToolkit"]['title'], 'type NOT' => 'folder')))) > 0) {
                    $result = array("result" => "error", 'message' => 'There is already a file with same title.');
                } else {
                    $this->request->data["ParentToolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
                    if ($this->ParentToolkit->save($this->request->data)) {
                        $this->update_folder_modified_date($this->request->data["ParentToolkit"]['id']);
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
            $options = array('conditions' => array('Toolkit.' . $this->ParentToolkit->primaryKey => $id));
            $this->request->data = $this->ParentToolkit->find('first', $options);
        }
    }

    public function delete_file() {
        if (strpos($this->request->data["id"], "~") !== false) {
            $arrFilesId = explode("~", $this->request->data["id"]);
        } else {
            $arrFilesId = $this->request->data["id"];
        }

        $filelist = ($this->ParentToolkit->find('all', array('conditions' => array('id' => $arrFilesId))));
        
        foreach ($filelist as $k => $v) {
            if ($v["ParentToolkit"]["type"] != "youtube") {
                if (!unlink(WWW_ROOT . "files" . DS . $v["ParentToolkit"]["name"])) {
                    $result = "Error to remove files";
                }
            }
        }

        if ($this->ParentToolkit->deleteAll(array('id' => $arrFilesId))) {
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
            $toolkit = $this->ParentToolkit->findAllById($id);
            $fullname = $toolkit[0]["ParentToolkit"]["name"];
            $nameArr = explode('.', $fullname);
            $extension = $nameArr[count($nameArr) - 1];
            $name = substr($fullname, 0, (strlen($fullname) - (strlen($extension)) - 1));
        }
        $this->viewClass = 'Media';
        // Download app/outside_webroot_dir/example.zip
        $params = array(
            'id' => $fullname,
            'name' => $name,
            'extension' => $toolkit[0]["ParentToolkit"]["extension"],
            'download' => true,
            'path' => 'webroot' . DS . 'files' . DS  // file path
        );
        $this->set($params);
    }

    public function validName($fullname) {
        $nameArr = explode('.', $fullname);
        $extension = $nameArr[count($nameArr) - 1];
        $name = substr($fullname, 0, (strlen($fullname) - (strlen($extension)) - 1));

        if (count($this->ParentToolkit->find('all', array('conditions' => array('name' => $fullname))))) {
            $file = $this->ParentToolkit->find('all', array('conditions' => array('name LIKE ' => "$name-copy%", 'extension' => $extension), 'order' => 'id DESC', 'LIMIT' => 1));

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
                $arrFiles = $this->ParentToolkit->find('all', array('conditions' => array('title LIKE' => "%" . trim($this->request->data["text"]) . "%")));
            } else {
                echo $this->getListFiles();
                exit;
            }
            if (count($arrFiles) > 0) {
                $this->set('arrFiles', $arrFiles);
                /*if ($type == 1) {
                    $this->set('type', $type);
                }*/
                return $result = $this->render('/Elements/search_parent_result_list_elements');
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
            if ($this->request->data["ParentToolkit"]["id"] != "" && $this->request->data["ParentToolkit"]["description"] != "") {
                $this->request->data["ParentToolkit"]["last_modified_date"] = date("Y-m-d H:i:s");
                $this->ParentToolkit->save($this->request->data);
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
        $arrToolkit = $this->ParentToolkit->find('list', array('conditions' => array('id'=>$file_id), 'fields'=>array('parent_id')));
        $this->ParentToolkit->query('UPDATE toolkits SET last_modified_date="'.date('Y-m-d H:i:s').'" WHERE id IN ('.$arrToolkit[$file_id].')');
    }

}
