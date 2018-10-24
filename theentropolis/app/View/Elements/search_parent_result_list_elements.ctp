<?php
$flag = true;
if(isset($type) && $type==1) {
    $flag = false;
}
foreach ($arrFiles as $k => $v) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="list_block">
                <div class="sublist">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="first_col">
                                <?php
                                if($flag) {?>
                                <span class="custom_checkbox"><input type="checkbox" id="cbFile-<?= $v["ParentToolkit"]["id"] ?>" data-id="<?= $v["ParentToolkit"]["id"] ?>"><label for="cbFile-<?= $v["ParentToolkit"]["id"] ?>"></label></span>
                                <?php } ?>
                                <?php
                                if (trim(strtolower($v["ParentToolkit"]["type"])) == "youtube" && $v["ParentToolkit"]["type"] != "link") {?>
                                    <i class="icons movie"></i>
                               <?php } else if($v["ParentToolkit"]["type"] == "link") { ?>
                                            <i class="icons blog-big"></i>
                                                            <?php } else { ?>
                                    <i class="icons <?= $v["ParentToolkit"]["extension"] ?>"></i>
                                <?php } ?>
                                <div class="file_name">
                                    <span><?= $v["ParentToolkit"]["title"] ?></span>
                                    <small><?= $v["ParentToolkit"]["short_description"] ?></small>
                                </div>
                            </div>
                            <div class="second_col"></div>
                            <div class="flex_item third_col file_actions">
                                <?php
                                if ($v["ParentToolkit"]["type"] != "youtube" && $v["ParentToolkit"]["type"] != "link") {
                                    $path = "../files" . DS . $v["ParentToolkit"]["name"];
                                } else {
                                    $path = $v["ParentToolkit"]["name"];
                                }
                                ?>
                                <a href="<?= $path ?>" target="_blank"><i class="icons view-big"></i></a>

                                <?php
                                if ($v["ParentToolkit"]["type"] != "youtube" && $v["ParentToolkit"]["type"] != "link") {
                                    echo $this->Html->link(
                                            'Download', array(
                                        'controller' => 'ParentToolkits',
                                        'action' => 'download_file/' . $k,
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
                                        <?php echo ($v["ParentToolkit"]["last_modified_date"]=="0000-00-00 00:00:00")?date('d F Y', strtotime($v["ParentToolkit"]["created_date"])): date('d F Y', strtotime($v["ParentToolkit"]["last_modified_date"]));?>
                                </em></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>