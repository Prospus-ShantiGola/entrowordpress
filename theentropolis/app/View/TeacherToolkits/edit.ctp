<?php
if (count($arrPage)) {
    $page_id = $arrPage["Page"]["id"];
    if ($arrPage["Page"]["title"] != "") {
        $page_title = $arrPage["Page"]["title"];
    } else {
        $page_title = "KIDPRENEUR CHALLENGE CURRICULUM TOOLKIT";
    }

    if ($arrPage["Page"]["description"] != "") {
        $page_description = $arrPage["Page"]["description"];
    } else {
        $page_description = "In this toolkit you will find curated entrepreneurship and STEM resources and content to help you gain the knowledge and confidence to embed an entrepreneurial mindset and build capability in your your students.";
    }
}
?>

<!-- KC HQ TOOLKIT END HERE -->
<div class="col-md-10 content-wraaper black-dot kidpreneur_toolkit " >
    <div class="sage-dash-wrap  full-wrap">
        <div class="title dashboard-title fixed-ipad-top">
            <h2 class="main_title title dashboard-title toolkit_title">
            <div class="col-md-10 padding_zero"><i class="icons hq-dashboard fl"></i><span><?php echo $page_title; ?></span> </div>
            <div class="col-md-2 padding_zero">
                <?php if ($this->Session->read('isAdmin')) { ?>
            <button type="btn" class="btn right" id="editPageTitleBtn" data-toggle="modal" data-target="#EditpagePopup">Edit</button></div>
            <?php } ?>
            </h2>
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title_text relative toolkit_desc">
                    <p><?php echo $page_description; ?></p>
                    <?php if ($this->Session->read('isAdmin')) { ?>
                    <button class="btn" id="editPageDescBtn" data-toggle="modal" data-target="#EditpagePopup">Edit</button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="search-bar clearfix margin_top_15 margin_bottom_15 padding_zero">
                    <div class="toolkit_search">
                        <input type="text" placeholder="Search" class="form-control " name="txtSearch" id="txtSearchEdit"/>
                        <a href="#" id="btnSearchEdit">GO</a>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->Session->read('isAdmin')) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="upload_conatiner pull-left">
                    <div class="toolkit_actionpanel">
                        <div class="col-md-6 folderManipulationBtnjs">
                            <a href="#" data-toggle="modal" data-target="#newFolderPopup"><i class="icons plus-line"></i>New Folder</a>
                            <a href="#" class="inactiveActions" id="editFolder" data-toggle="modal" data-target="#EditFolderPopup"><i class="icons edit-grey-icon"></i>Edit Folder</a>
                            <a href="#" class="inactiveActions" id="deleteFolder"><i class="icons delete-icon"></i>Delete Folder</a>
                        </div>
                        <div class="col-md-6 align_right fileManipulationBtnjs">
                            <form id="upload_files" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#uploadFile" id="fileselector" class="inactiveActions">
                                    <span class="fileinput-button ">
                                        <label class="btn btn-default" for="upload-file-selector">
                                            <input id="upload-file-selector" name="upload-file-selector" type="file">
                                            <i class="icons upload-icon"></i>upload file
                                        </label>
                                    </span>
                                </a>
                                <a href="#" data-toggle="modal" data-target="#EditFilePopup" id="editFile" class="opacity0"><i class="icons edit-grey-icon"></i>Edit File</a>
                                <a href="#" id="deleteFile" class="opacity0"><i class="icons delete-icon"></i>Delete File</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="flex_container list_header">
                    <div class="first_col">
                        <span class="custom_checkbox"><input type="checkbox" id="chkSelect"><label for="chkSelect"></label></span>
                        <h3 class="dash_titles">Folder</h3>
                    </div>
                    <div class="second_col">
                        <h3 class="dash_titles">Description
                        <?php if ($this->Session->read('isAdmin')) { ?>
                        <button class="btn desc_edit inactiveActions" data-toggle="modal" data-target="#EditDescPopup" id="editDescription">edit</button></h3>
                        <?php } ?>
                    </div>
                    <div class="third_col">
                        <h3 class="dash_titles">Action</h3>
                    </div>
                    <div class="fourth_col">
                        <h3 class="dash_titles">Last Modified</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="custom_scroll ">
                    <div class="listing_container accordionContainer">
                        <?php
                        
                        if(count($arrFile)<=0){?>
                        <div class="row"><div class="col-md-12">Your Kidpreneur Challenge Toolkit is empty. Try creating a new folder</div></div>
                        <?php }
                        
                        foreach ($arrFile as $k => $v) {
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="list_block">
                                    <div class="flex_container">
                                        <div class="first_col">
                                            <span class="custom_checkbox"><input type="checkbox" id="cbFolder-<?= $k ?>" data-id="<?= $k ?>"><label for="cbFolder-<?= $k ?>"></label></span>
                                            <i class="icons folder accordionTitle"></i>
                                            <div class="folder_name">
                                                <span><?= $v["name"] ?></span>
                                                <small><?= $v["short_description"] ?></small>
                                            </div>
                                        </div>
                                        <div class="second_col">
                                            <span class="folder_short_desc"><?= $v["description"] ?></span>
                                        </div>
                                        <div class="third_col">
                                            <div class="btn line_button image-preview-input openFileUpload">
                                                <span class="image-preview-input-title"><small>+</small> File</span>
                                                <!-- <input type="file" name="input-file-preview"/> -->
                                            </div>
                                        </div>
                                        <div class="fourth_col">
                                            <small><em>
                                            <?php echo ($v["last_modified_date"]=="0000-00-00 00:00:00")?date('d F Y', strtotime($v["created_date"])): date('d F Y', strtotime($v["last_modified_date"]));?>
                                            </em></small>
                                        </div>
                                    </div>
                                    <div class="sublist accordionBox">
                                        <?php
                                        if (array_key_exists("child", $v)) {
                                        foreach ($v["child"] as $key => $val) {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="first_col">
                                                    <span class="custom_checkbox"><input type="checkbox" id="cbFile-<?= $key ?>" data-id="<?= $key ?>"><label for="cbFile-<?= $key ?>"></label></span>
                                                    <?php
                                                    if ($val["type"] != "youtube" && $val["type"] != "link") {?>
                                                    <i class="icons <?= $val["extension"] ?>"></i>
                                                    <?php } else if($val["type"] == "link") { ?>
                                            <i class="icons blog-big"></i>
                                                    <?php } else { ?>
                                                    <i class="icons movie"></i>
                                                    <?php } ?>
                                                    <div class="file_name">
                                                        <span><?= $val["title"] ?></span>
                                                        <small><?= $val["short_description"] ?></small>
                                                    </div>
                                                </div>
                                                <div class="second_col"></div>
                                                <div class="flex_item third_col file_actions">
                                                    <?php
                                                    if ($val["type"] != "youtube" && $val["type"] != "link") {
                                                    $path = "../files" . DS . $val["name"];
                                                    } else {
                                                    $path = $val["name"];
                                                    }
                                                    ?>
                                                    <a href="<?= $path ?>" target="_blank"><i class="icons view-big"></i></a>
                                                    <?php
                                                    if ($val["type"] != "youtube" && $val["type"] != "link") {
                                                    echo $this->Html->link(
                                                    'Download', array(
                                                    'controller' => 'TeacherToolkits',
                                                    'action' => 'download_file/' . $key,
                                                    'full_base' => true,
                                                    ), array(
                                                    'label' => false,
                                                    'class' => "btn btn-style line_button",
                                                    ));
                                                    }
                                                    ?>
                                                </div>
                                                <div class="fourth_col">
                                                    <small><em>
                                                    <?php echo ($val["last_modified_date"]=="0000-00-00 00:00:00")?date('d F Y', strtotime($val["created_date"])): date('d F Y', strtotime($val["last_modified_date"]));?>
                                                    </em></small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <?php echo $this->element('footer_payment_elements');?>
<!-- KC HQ TOOLKIT END HERE -->

<div class="menu-bg-overlay"></div>


<!-- ADD NEW FOLDER START HERE -->
<div class="modal fade " id="newFolderPopup" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">New Folder</h4>
            </div>
            <?php
                echo $this->Form->create('TeacherToolkit', array('id' => 'ToolkitAddForm'));
            ?>
            <div class="modal-body clearfix">
                <?php
                echo '<div class="form-group clearfix"><div class="col-sm-12">';
                echo $this->Form->input('name', array('label' => false, 'maxlength' => '100', 'class' => 'form-control', 'placeholder' => 'Folder Title*', 'required'=>false));
                echo '</div></div>';
                echo '<div class="form-group clearfix"><div class="col-sm-12">';
                echo $this->Form->input('short_description', array('label' => false, 'maxlength' => '200', 'class' => 'form-control', 'placeholder' => 'Sub Title'));
                echo '</div></div>';
                echo '<div class="form-group clearfix"><div class="col-sm-12">';
                echo $this->Form->input('description', array('type' => 'textarea', 'maxlength' => '400', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Description', 'required'=>false));
                echo '</div></div>';
                ?>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn" value="submit" />
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<!-- EDIT FOLDER START HERE -->
<div class="modal fade " id="EditFolderPopup" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Edit Folder</h4>
            </div>
            <?php
            echo $this->Form->create('TeacherToolkit', array('id' => 'ToolkitEditForm'));
            ?>
            <div class="modal-body clearfix">
                <?php
                echo '<div class="form-group clearfix"><div class="col-sm-12">';
                echo $this->Form->input('id', array('value' => 1));
                echo $this->Form->input('name', array('label' => false, 'maxlength' => '100', 'class' => 'form-control', 'placeholder' => 'Folder Title*', 'value' => 'test', 'required' => false));
                echo '</div></div>';
                echo '<div class="form-group clearfix margin-bottom-zero"><div class="col-sm-12">';
                echo $this->Form->input('short_description', array('type' => 'textarea', 'maxlength' => '200', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Sub Title*', 'value' => 'test', 'required' => false));
                echo '</div></div>';
                ?>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn" value="submit" />
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<!-- EDIT FILE START HERE -->
<div class="modal fade " id="EditFilePopup" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Edit File</h4>
            </div>
            <?php
            echo $this->Form->create('TeacherToolkit', array('id' => 'ToolkitEditFileForm'));
            ?>
            <div class="modal-body clearfix">
                <?php
                echo '<div class="clearfix"><div class="col-sm-12">';
                echo $this->Form->input('id', array('value' => 11));
                echo '</div></div>';
                echo $this->Form->input('old_title', array('name' => "data[TeacherToolkit][old_title]", 'id' => 'old_name', 'type' => 'hidden', 'value' => 'test.jpg'));
                echo '<div class="form-group clearfix"><div class="col-sm-12">';
                echo $this->Form->input('title', array('label' => false, 'maxlength' => '100', 'class' => 'form-control', 'placeholder' => 'Title*'));
                echo '</div></div>';
                echo '<div class="form-group clearfix margin-bottom-zero"><div class="col-sm-12">';
                echo $this->Form->input('short_description', array('type' => 'textarea', 'maxlength' => '200', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Subtitle*'));
                echo '</div></div>';
                ?>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn" value="submit" />
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!-- start edit Descripton popup -->
<div class="modal fade " id="EditDescPopup" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Edit Description</h4>
            </div>
            <?php
            echo $this->Form->create('TeacherToolkit', array('id' => 'ToolkitEditDescription'));
            ?>
            <div class="modal-body clearfix">
                <?php
                echo $this->Form->input('id', array('id' => 'ToolkitEditDescriptionId'));
                echo '<div class="form-group clearfix"><div class="col-sm-12">';
                echo $this->Form->input('description', array('type' => 'textarea', 'maxlength' => '400', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Description'));
                echo '</div></div>';
                ?>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn" value="submit" />
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!-- end edit description popup -->

<!-- start edit page title popup -->
<div class="modal fade " id="EditpagePopup" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Edit Page </h4>
            </div>
            <?php
            echo $this->Form->create('page', array('id' => 'pagetitleform'));
            ?>
            <div class="modal-body clearfix">
                <?php
                echo $this->Form->input('id', array('label' => false, 'class' => 'form-control hide', 'placeholder' => 'Toolkit Title', 'value' => $page_id));
                echo '<div class="form-group clearfix margin-bottom-zero"><div class="col-sm-12">';
                echo $this->Form->input('title', array('label' => false, 'maxlength' => '50', 'class' => 'form-control hide', 'placeholder' => 'Toolkit Title'));
                echo '</div></div>';
                echo '<div class="form-group clearfix margin-bottom-zero"><div class="col-sm-12">';
                echo $this->Form->input('description', array('type' => 'textarea', 'label' => false, 'class' => 'form-control hide', 'placeholder' => 'Toolkit Description'));
                echo '</div></div>';
                ?>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn" value="submit" />
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<div class="modal fade " id="progressBarPopup" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">File Uploaded </h4>
            </div>

            <div class="modal-body clearfix">
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
            </div>

            <!-- <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
            </div> -->
        </div>
    </div>
</div>

<!-- Upload File Start Here -->
<div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">New file upload</h4>
            </div>

            <div class="modal-body clearfix">
                <div class="form-group form-check ">
                    <div class="col-md-3">
                        <label class="control control--radio fileuploadRadio">PDF
                            <input type="radio" name="pdfradio" value="1"/>
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="control control--radio fileuploadRadio">Video
                            <input type="radio" name="pdfradio" checked="checked" value="2"/>
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <label class="control control--radio fileuploadRadio">Link
                            <input type="radio" name="pdfradio" value="3"/>
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>
                <div class="uploadPdfFields">
                    <?php
                    echo $this->Form->create('TeacherToolkit', array('id' => 'ToolkitAddPdfForm'));
                    ?>
                    <div class="form-group clearfix">
                        <div class="col-sm-12 browse_file">
                            <!-- <label for="fileupload" id="filetext">No file chosen
                            </label> -->
                            <input class="filestyle" id="fileupload" type="file" name="files[]">
                            <label id="fileupload-error" class="fileupload-error-fields" for="fileupload" style="display:none"></label>
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        <div class="col-sm-12">
                            <input type="text" name="title" id="pdfTitle" placeholder="Title*" class="form-control" maxlength="100" />
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-12">
                            <textarea name="" placeholder="Short Description" class="form-control" id="file_short_desc" maxlength="200" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn" value="submit" id="fileuploadbtn"/>
                        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
                <div class="uploadVideoFields">
                    <?php
                    echo $this->Form->create('TeacherToolkit', array('id' => 'ToolkitAddVideoForm'));
                    ?>
                    <div class="clearfix">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('type', array('placeholder' => 'Url*', 'class' => "form-control", 'label' => false, 'value' => "youtube", 'type' => 'hidden')); ?>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('video_url', array('placeholder' => 'Url* (Eg: http://www.TrepiCity.com)', 'class' => "form-control", 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('title', array('placeholder' => 'Title*', 'maxlength' => '100', 'class' => "form-control", 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('short_description', array('type' => 'textarea', 'maxlength' => '200', 'placeholder' => 'Short Description', 'class' => "form-control", 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn" value="submit" />
                        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
                <div class="uploadLinkFields">
                    <?php
                    echo $this->Form->create('TeacherToolkit', array('id' => 'ToolkitAddLinkForm'));
                    ?>
                    <div class="clearfix">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('type', array('placeholder' => 'Url*', 'class' => "form-control", 'label' => false, 'value' => "link", 'type' => 'hidden')); ?>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('link_url', array('placeholder' => 'Url* (Eg: http://www.TrepiCity.com)', 'class' => "form-control", 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('title', array('placeholder' => 'Title*', 'maxlength' => '100', 'class' => "form-control", 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('short_description', array('type' => 'textarea', 'maxlength' => '200', 'placeholder' => 'Short Description', 'class' => "form-control", 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn" value="submit" />
                        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- Upload File End Here -->
<?php
echo $this->Html->script('jquery.validate');
echo $this->Html->script('additional-methods');
echo $this->Html->script('script');
echo $this->Html->script('teachertoolkit');

?>
<!-- ADD NEW FOLDER END HERE -->
