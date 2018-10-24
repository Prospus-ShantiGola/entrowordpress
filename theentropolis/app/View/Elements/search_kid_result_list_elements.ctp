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
                                <span class="custom_checkbox"><input type="checkbox" id="cbFile-<?= $v["KidpreneurToolkit"]["id"] ?>" data-id="<?= $v["KidpreneurToolkit"]["id"] ?>"><label for="cbFile-<?= $v["KidpreneurToolkit"]["id"] ?>"></label></span>
                                <?php } ?>
                                <?php
                                if (trim(strtolower($v["KidpreneurToolkit"]["type"])) == "youtube" && $v["KidpreneurToolkit"]["type"] != "link") {?>
                                    <i class="icons movie"></i>
                               <?php } else if($v["KidpreneurToolkit"]["type"] == "link") { ?>
                                            <i class="icons blog-big"></i>
                                                            <?php } else { ?>
                                    <i class="icons <?= $v["KidpreneurToolkit"]["extension"] ?>"></i>
                                <?php } ?>
                                <div class="file_name">
                                    <span><?= $v["KidpreneurToolkit"]["title"] ?></span>
                                    <small><?= $v["KidpreneurToolkit"]["short_description"] ?></small>
                                </div>
                            </div>
                            <div class="second_col"></div>
                            <div class="flex_item third_col file_actions">
                                <?php
                                if ($v["KidpreneurToolkit"]["type"] != "youtube" && $v["KidpreneurToolkit"]["type"] != "link") {
                                    $path = "../files" . DS . $v["KidpreneurToolkit"]["name"];
                                } else {
                                    $path = $v["KidpreneurToolkit"]["name"];
                                }
                                ?>
                                <a href="<?= $path ?>" target="_blank"><i class="icons view-big"></i></a>

                                <?php
                                if ($v["KidpreneurToolkit"]["type"] != "youtube" && $v["KidpreneurToolkit"]["type"] != "link") {
                                    echo $this->Html->link(
                                            'Download', array(
                                        'controller' => 'KidpreneurToolkits',
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
                                        <?php echo ($v["KidpreneurToolkit"]["last_modified_date"]=="0000-00-00 00:00:00")?date('d F Y', strtotime($v["KidpreneurToolkit"]["created_date"])): date('d F Y', strtotime($v["KidpreneurToolkit"]["last_modified_date"]));?>
                                </em></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>