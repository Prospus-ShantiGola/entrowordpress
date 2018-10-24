<?php

$flag = true;
if(isset($type) && $type==1) {
    $flag = false;
}

foreach ($arrFile as $k => $v) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="list_block">
                <div class="flex_container">
                    <div class="first_col">
                        <?php if($flag) {?>
                        <span class="custom_checkbox"><input type="checkbox" id="cbFolder-<?= $k ?>" data-id="<?= $k ?>"><label for="cbFolder-<?= $k ?>"></label></span>
                        <?php } ?>
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
                            <span class="image-preview-input-title"><small>+</small>File</span>
                            <!-- <input type="file" name="input-file-preview"/> -->
                        </div>
                    </div>
                    <div class="fourth_col">
                        <small><em>
                                <?php echo ($v["last_modified_date"] == "0000-00-00 00:00:00") ? date('d F Y', strtotime($v["created_date"])) : date('d F Y', strtotime($v["last_modified_date"])); ?>
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
                                        <?php if($flag) {?>
                                        <span class="custom_checkbox"><input type="checkbox" id="cbFile-<?= $key ?>" data-id="<?= $key ?>"><label for="cbFile-<?= $key ?>"></label></span>
                                        <?php }?>
                                        <?php if ($val["type"] != "youtube" && $val["type"] != "link") { ?>
                                            <i class="icons <?=$val["extension"]?>"></i>
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
                                                'controller' => 'Toolkits',
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
                                                <?php echo ($val["last_modified_date"] == "0000-00-00 00:00:00") ? date('d F Y', strtotime($val["created_date"])) : date('d F Y', strtotime($val["last_modified_date"])); ?>
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