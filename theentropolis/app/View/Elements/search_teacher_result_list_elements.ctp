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
                                <span class="custom_checkbox"><input type="checkbox" id="cbFile-<?= $v["TeacherToolkit"]["id"] ?>" data-id="<?= $v["TeacherToolkit"]["id"] ?>"><label for="cbFile-<?= $v["TeacherToolkit"]["id"] ?>"></label></span>
                                <?php } ?>
                                <?php
                                if (trim(strtolower($v["TeacherToolkit"]["type"])) == "youtube" && $v["TeacherToolkit"]["type"] != "link") {?>
                                    <i class="icons movie"></i>
                               <?php } else if($v["TeacherToolkit"]["type"] == "link") { ?>
                                            <i class="icons blog-big"></i>
                                                            <?php } else { ?>
                                    <i class="icons <?= $v["TeacherToolkit"]["extension"] ?>"></i>
                                <?php } ?>
                                <div class="file_name">
                                    <span><?= $v["TeacherToolkit"]["title"] ?></span>
                                    <small><?= $v["TeacherToolkit"]["short_description"] ?></small>
                                </div>
                            </div>
                            <div class="second_col"></div>
                            <div class="flex_item third_col file_actions">
                                <?php
                                if ($v["TeacherToolkit"]["type"] != "youtube" && $v["TeacherToolkit"]["type"] != "link") {
                                    $path = "../files" . DS . $v["TeacherToolkit"]["name"];
                                } else {
                                    $path = $v["TeacherToolkit"]["name"];
                                }
                                ?>
                                <a href="<?= $path ?>" target="_blank"><i class="icons view-big"></i></a>

                                <?php
                                if ($v["TeacherToolkit"]["type"] != "youtube" && $v["TeacherToolkit"]["type"] != "link") {
                                    echo $this->Html->link(
                                            'Download', array(
                                        'controller' => 'TeacherToolkits',
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
                                        <?php echo ($v["TeacherToolkit"]["last_modified_date"]=="0000-00-00 00:00:00")?date('d F Y', strtotime($v["TeacherToolkit"]["created_date"])): date('d F Y', strtotime($v["TeacherToolkit"]["last_modified_date"]));?>
                                </em></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>