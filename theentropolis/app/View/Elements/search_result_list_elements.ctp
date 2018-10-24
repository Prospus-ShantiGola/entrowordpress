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
                                <span class="custom_checkbox"><input type="checkbox" id="cbFile-<?= $v["Toolkit"]["id"] ?>"><label for="cbFile-<?= $v["Toolkit"]["id"] ?>"></label></span>
                                <?php } ?>
                                <?php
                                if (trim(strtolower($v["Toolkit"]["type"])) == "youtube" && $v["Toolkit"]["type"] != "link") {?>
                                    <i class="icons movie"></i>
                               <?php } else if($v["Toolkit"]["type"] == "link") { ?>
                                            <i class="icons blog-big"></i>
                                                            <?php } else { ?>
                                    <i class="icons <?= $v["Toolkit"]["extension"] ?>"></i>
                                <?php } ?>
                                <div class="file_name">
                                    <span><?= $v["Toolkit"]["title"] ?></span>
                                    <small><?= $v["Toolkit"]["short_description"] ?></small>
                                </div>
                            </div>
                            <div class="second_col"></div>
                            <div class="flex_item third_col file_actions">
                                <?php
                                if ($v["Toolkit"]["type"] != "youtube" && $v["Toolkit"]["type"] != "link") {
                                    $path = "../files" . DS . $v["Toolkit"]["name"];
                                } else {
                                    $path = $v["Toolkit"]["name"];
                                }
                                ?>
                                <a href="<?= $path ?>" target="_blank"><i class="icons view-big"></i></a>

                                <?php
                                if ($v["Toolkit"]["type"] != "youtube" && $v["Toolkit"]["type"] != "link") {
                                    echo $this->Html->link(
                                            'Download', array(
                                        'controller' => 'Toolkits',
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
                                        <?php echo ($v["Toolkit"]["last_modified_date"]=="0000-00-00 00:00:00")?date('d F Y', strtotime($v["Toolkit"]["created_date"])): date('d F Y', strtotime($v["Toolkit"]["last_modified_date"]));?>
                                </em></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>