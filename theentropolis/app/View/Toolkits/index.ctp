<?php
if (count($arrPage)) {
    $page_id = $arrPage["Page"]["id"];
    if ($arrPage["Page"]["title"] != "") {
        $page_title = $arrPage["Page"]["title"];
    } else {
        $page_title = "KIDPRENEUR CHALLENGE PROGRAM TOOLKIT";
    }

    if ($arrPage["Page"]["description"] != "") {
        $page_description = $arrPage["Page"]["description"];
    } else {
        $page_description = "In this toolkit you will find everything you need to run the Kidpreneur Challenge with your students. Simply follow each step through by opening the Module Folder to find all relevant videos, lesson plans, worksheets and supplementary materials. Click on each file link and the pdf/movie will open in a new browser window. If you require any support, you can contact the Club Kidpreneur team directly in one of the following ways: Email: info@kidpreneurchallenge.com or Phone: 1300 464 388";
    }
}
?>

<!-- KC HQ TOOLKIT END HERE -->
<div class="col-md-10 content-wraaper black-dot kidpreneur_toolkit " >
    <div class="sage-dash-wrap  full-wrap">
        <div class="title dashboard-title fixed-ipad-top" >

            <h2 class="main_title title dashboard-title toolkit_title">
                <div class="col-md-10 padding_zero"><i class="icons hq-dashboard fl"></i><span><?php echo $page_title; ?></span> </div>
                <div class="col-md-2 padding_zero">
            </h2>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title_text relative toolkit_desc">
                    <p><?php echo $page_description; ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="search-bar clearfix margin_top_15 margin_bottom_15 padding_zero">
                    <div class="toolkit_search">
                        <input type="text" placeholder="Search" class="form-control " name="txtSearch" id="txtSearch"/>
                        <a href="#" id="btnSearch">GO</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="flex_container list_header">
                    <div class="first_col">
                        <h3 class="dash_titles">Folder</h3>
                    </div>
                    <div class="second_col">
                        <h3 class="dash_titles">Description
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
                <div class="custom_scroll"style="">
                    <div class="listing_container accordionContainer custom_scroll">
                        <?php
                        if (count($arrFile) <= 0) { ?>
                            <div class="row"><div class="col-md-12">Your Kidpreneur Challenge Toolkit is empty. Try creating a new folder</div></div>
                            <?php
                        }
                        foreach ($arrFile as $k => $v) {
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="list_block">
                                        <div class="flex_container">
                                            <div class="first_col">
                                                <i class="icons folder accordionTitle"></i>
                                                <div class="folder_name">
                                                    <span><?= $v["name"] ?></span>
                                                    <small><?= $v["short_description"] ?></small>
                                                </div>
                                            </div>
                                            <div class="second_col">
                                                <span class="folder_short_desc"><?= $v["description"] ?></span>
                                            </div>
                                            <div class="third_col file_actions">
                                                <span class="accordionTitle"><i class="icons view-md"></i></span>
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
                                                                <?php if ($val["type"] != "youtube" && $val["type"] != "link") { ?>
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
                                                                <a href="<?= $path ?>" target="_blank"><i class="icons view-md"></i></a>

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
                    </div>
                </div></div>

        </div>
    </div>
</div>
 <?php echo $this->element('footer_payment_elements');?>
<!-- KC HQ TOOLKIT END HERE -->

<div class="menu-bg-overlay"></div>

<!-- Upload File End Here -->
<?php
echo $this->Html->script('jquery.validate');
echo $this->Html->script('additional-methods');
echo $this->Html->script('script');
echo $this->Html->script('toolkit');

echo $this->element('advice_all_modal_element');
echo $this->element('blog_js_element');
?>
