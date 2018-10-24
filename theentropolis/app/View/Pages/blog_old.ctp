<?php
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

$my_local_ip = get_client_ip();

function get_youtube_id_from_url($url) {
    if (stristr($url, 'youtu.be/')) {
        preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID);
        return $final_ID[4];
    } else {
        @preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD);
        return $IDD[5];
    }
}

?>
<style>
.page-loading {
    bottom: 10px;
    height: 58px;
    opacity: 0.2;
    display: none!important;
}
</style>

<div class="page-loading" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif'); ?></div>

<div class="header">
    <div class="headerHead H1-white">
        The Scoop
    </div>
</div>
<div style="clear:both"></div>
<div class="container blog-container">
    <div class="blog-header">
        <h1 class="H1 blog-head">Blog</h1>
    </div>
    <div class="row blog_outer_row">
        <div class="col-sm-7">
            <div class="blogBlock">
                <div class="blogFeaturedImgWrap">
                    <!--div class="vidPlay">
                        <a href="javascript:void(0)">
                          <?php
                          $videoUrl = $this->Common->parseVideos($tourVideo_blog['TourVideo']['video_url']);
                          //echo$this->Html->image("video-play-white.png", array('alt' => '', 'border' => '0', 'class' => 'play-video-popup', 'data-toggle' => 'modal', 'data-target' => '#blogVideoPopup', 'data-video'=>$videoUrl[0]['url'], 'data-title'=>$tourVideo_blog['TourVideo']['title'])); ?>                    </a>
                    </div-->
                    <!--?php
                    //print_r($tourVideo_blog);exit;video_url
                    if ($tourVideo_blog['TourVideo']['upload_thumbnail'] != '') {
                        echo $this->Html->image("../" . $tourVideo_blog['TourVideo']['upload_thumbnail'], array('alt' => '', 'style' => 'width: 100%'));
                    } else {
                        echo $this->Html->image('blog-sample.jpg', array('alt' => '', 'style' => 'width: 100%'));
                    }
                    ?-->
                    <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="<?=$videoUrl[0]['url']?>" height="400"></iframe>
                    </div>

                </div>
                
                <div class="blogMainTitle"><?= $tourVideo_blog['TourVideo']['title'] ?></div>
                <div class="blogAuthor"><?= ($tourVideo_blog['User']['first_name'] . ' ' . $tourVideo_blog['User']['last_name']) ?></div>
                <div class="blogAuthor">Team heading </div>
                <div class="blogTxt  more">
                    <?= $tourVideo_blog['TourVideo']['blog_detail'] ?>
                </div>
                <!--a href="" class="more fontMed">Read More</a-->
                <div style="margin:1.5em 0 1.5em;">
                    <a href="https://www.facebook.com/Trepicity/" target="_blank"> <?php echo $this->Html->image('facebook-blog.png', array('data-alt-src' => 'img/facebook-over.png', 'class' => 'imgswop', 'border' => '0')); ?></a>&nbsp;
                    <a href="https://twitter.com/TrepicityHQ" target="_blank"><?php echo $this->Html->image('twitter-blog.png', array('data-alt-src' => 'twitter-over.png', 'class' => 'imgswop', 'border' => '0')); ?></a>&nbsp;
                    <a href="" class="disabled"><?php echo $this->Html->image('youtube-play-blog.png', array('data-alt-src' => 'youtube-play-over.png', 'class' => 'imgswop', 'border' => '0')); ?></a>&nbsp;
                    <a href="" class="disabled"><?php echo $this->Html->image('linkedin-blog.png', array('class' => 'imgswop', 'data-alt-src' => 'linkedin-over.png', 'border' => '0')); ?></a>
                </div>
                
                <?php
                if($this->Session->read('user_id')) {?>
                    <div class="blogComments">
                        <?php echo $this->Form->create('Comment', array('class' => 'comment-blog', 'id' => 'AddBlogComment')); ?>
                    <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                    <input type="hidden" name="data[Comment][blog_id]" class = "comment_obj_id" value="<?php echo $tourVideo_blog['TourVideo']['id'] ?>">
                    <input type="hidden" name="type" id= "comment_obj_type" value="blog">
                    <?php echo $this->Form->textarea('comments', array('class' => 'blogtxtArea form-control', 'placeholder' => 'Add a Comment', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
                    <div align="right">
                    <?php echo $this->Form->Button('Send', array('div' => false, 'class' => 'buttonG', 'type' => 'submit')); ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                <?php } else {?>
                    <div class="blogComments">
                    <?php echo $this->Form->create('Comment', array('class' => 'comment-blog', 'id' => 'AddBlogComment')); ?>
                    <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                    <input type="hidden" name="data[Comment][blog_id]" class = "comment_obj_id" value="<?php echo $tourVideo_blog['TourVideo']['id'] ?>">
                    <input type="hidden" name="type" id= "comment_obj_type" value="blog">
                    <?php echo $this->Form->textarea('comments', array('class' => 'blogtxtArea form-control', 'placeholder' => 'Add a Comment', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required', 'disabled'=>'disabled')); ?>
                    <div align="right">
                    <?php echo $this->Form->Button('Send', array('div' => false, 'class' => 'buttonG', 'type' => 'submit', 'disabled'=>'disabled')); ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                <?php } ?>
                    
                    
                    <div id="added_comment"></div>
                    <div class="blog_comment_wrap custom_scroll">
                    <?php
                    foreach ($blog_comment as $k=>$v) { ?>
                        <div style="margin:0 0 1.5em;">
                            <div class="commentAVT">
                                <?php echo $this->Html->image("../".$v["User"]["user_image"], array('alt' => '', 'width' => '100%', 'border' => '0')); ?>
                            </div>
                            <div class="commentTXT">
                                <div class="blogHeadR">
                                    <div style="margin:0 0 0.5em;"><em><?=($v["User"]["first_name"]." ".$v["User"]["last_name"])?></em></div>
                                    <?=$v["Comment"]["comments"]?>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="sidebar-module sidebar-module-inset">
                <h4 class="blogCat">TrepiCity HQ</h4>
                <div class="blog_media_wrap custom_scroll">
                <?php
                foreach ($blog_list as $k => $v) {
                    if ($v['Advice']['blog_type'] == 2) {
                        $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);
                        ?>
                            <a href="javascript:void(0);" class ="get-new-modal" data-type="advice" data-id ="<?php echo $v['Advice']['id'] ;?>" data-advice-type="<?php echo $v['Advice']['blog_type'];?>"data-advice-type="TrepiCity HQ" data-counterid="11" data-clickcount="3">
                            <div class="margin_bottom_space">
                                <div class="sideL">
                                     <?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                </div>
                                <div class="sideR">
                                    <span class="blogHead"><?php echo $v['Advice']['advice_title'] ?></span>
                                    <div class="blogHeadR">
                                         <?php echo $user_info[0]['users']['first_name'] . " " . $user_info[0]['users']['last_name'] ?>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            </a>
                        <?php
                    }
                }
                ?>
                </div>
                <h4 class="blogCat">CLUB KIDPRENEUR HQ</h4>
                <div class="blog_media_wrap custom_scroll">
                <?php
                foreach ($blog_list as $k => $v) {
                    if ($v['Advice']['blog_type'] == 3) {
                        $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);
                        ?>
                            <a href="javascript:void(0);" class ="get-new-modal" data-type="advice" data-id ="<?php echo $v['Advice']['id'] ;?>" data-advice-type="<?php echo $v['Advice']['blog_type'];?>"data-advice-type="CLUB KIDPRENEUR HQ" data-counterid="11" data-clickcount="3">
                            <div class="margin_bottom_space">
                                <div class="sideL">
                                    <?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                </div>
                                <div class="sideR">
                                    <span class="blogHead"><?php echo $v['Advice']['advice_title'] ?></span>
                                    <div class="blogHeadR">
                                        <?php echo $user_info[0]['users']['first_name'] . " " . $user_info[0]['users']['last_name'] ?>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            </a>
                        <?php
                    }
                }
                ?> 
                </div>
                <!--                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Blog Title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Team heading
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                
                                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Blog Title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Team heading
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                
                                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Blog Title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Team heading
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>-->


                <h4 class="blogCat">LATEST POSTS</h4>
                <div class="blog_media_wrap custom_scroll">
                <?php
                $i=0;
                foreach ($blog_list as $k => $v) {
                    /*if ($v['Advice']['blog_type'] == 5) {
                    if($i>2) {
                        break;
                    }
                    if ($v['Advice']['blog_type'] != null) {
                        $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);
                        $catch_user_click = "";
                        $class = "";$catch_user_click ="";$loggedIn="";$datatype="";
                        ?>
                        <a href="javascript:void(0);" class ="get-new-modal" data-type="advice" data-logged="<?php echo $loggedIn;?>" data-id ="<?php echo $v['Advice']['id'] ;?>" data-advice-type="<?php echo $v['Advice']['blog_type'];?>"data-advice-type="Latest Posts" data-counterid="11" data-clickcount="3">
                            <div class="margin_bottom_space">
                                <div class="sideL">
                                    <?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                </div>
                                <div class="sideR">
                                    <span class="blogHead"><?php echo $v['Advice']['advice_title'] ?></span>
                                    <div class="blogHeadR">
                                         <?php echo $user_info[0]['users']['first_name'] . " " . $user_info[0]['users']['last_name'] ?><br />
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </a>
                        <?php
                        $i++;
                    }*/
                    if ($v['Advice']['blog_type'] == 4) {
                        $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);
                        ?>
                            <a href="javascript:void(0);" class ="get-new-modal" data-type="advice" data-id ="<?php echo $v['Advice']['id'] ;?>" data-advice-type="<?php echo $v['Advice']['blog_type'];?>"data-advice-type="Archived Post" data-counterid="11" data-clickcount="3">
                            <div class="margin_bottom_space">
                                <div class="sideL">
                                     <?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                </div>
                                <div class="sideR">
                                    <span class="blogHead"><?php echo $v['Advice']['advice_title'] ?></span>
                                    <div class="blogHeadR">
                                        <?php echo $user_info[0]['users']['first_name'] . " " . $user_info[0]['users']['last_name'] ?>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            </a>
                        <?php
                    }
                }
                ?>
                </div>
                <!--                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Post title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Date
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                
                                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Post title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Date
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                
                                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Post title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Date
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>-->

                
                <h4 class="blogCat">ARCHIVED POSTS</h4>
                <div class="blog_media_wrap custom_scroll">
                <?php
                foreach ($blog_list as $k => $v) {
                    if ($v['Advice']['blog_type'] == 5) {
                        $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);
                        ?>
                            <a href="javascript:void(0);" class ="get-new-modal" data-type="advice" data-id ="<?php echo $v['Advice']['id'] ;?>" data-advice-type="<?php echo $v['Advice']['blog_type'];?>"data-advice-type="Archived Post" data-counterid="11" data-clickcount="3">
                            <div class="margin_bottom_space">
                                <div class="sideL">
                                     <?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                </div>
                                <div class="sideR">
                                    <span class="blogHead"><?php echo $v['Advice']['advice_title'] ?></span>
                                    <div class="blogHeadR">
                                        <?php echo $user_info[0]['users']['first_name'] . " " . $user_info[0]['users']['last_name'] ?>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            </a>
                        <?php
                    }
                } ?>
                </div>
                <!--                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Post title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Team heading
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                
                                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Post title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Team heading
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                
                                <div style="margin:0 0 1.5em;">
                                    <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                    </div>
                                    <div class="sideR">
                                        <span class="blogHead">Post title</span><br />
                                        <div class="blogHeadR">
                                            First name and last name heading<br />
                                            Team heading
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>-->

            </div>
        </div>
        <div style="clear:both"></div>

        <div class="blog-header">
            <h1 class="H1 blog-head-pad">MEDIA AND PR</h1>
        </div>
        <div class="inner-row">
            <div class="col-sm-7">
                <div class="mediaL  blog_media_space">
                    <?php
                    foreach ($blog_list as $k => $v) {
                        if ($v['Advice']['blog_type'] == 6) {
                            $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);?>
                            <a href="javascript:void(0);" class ="get-new-modal" data-type="advice" data-id ="<?php echo $v['Advice']['id'] ;?>" data-advice-type="<?php echo $v['Advice']['blog_type'];?>"data-advice-type="Archived Post" data-counterid="11" data-clickcount="3">
                            <?php echo (($v['Advice']['advice_image'] == "") ? $this->Html->image("blog-sample.jpg", array('alt' => '', 'border' => '0', 'width' => '100%')) : $this->Html->image("../".str_replace("thumb_", "", $v['Advice']['advice_image']), array('alt' => '', 'border' => '0', 'width' => '100%')));
                            break;?>
                            
                        <?php }
                    }
                    ?>
</a>
                </div>
                <br>
                <h4 class="blogCat featureBlogHead">Featured Blog</h4>
                <div class="blog_media_wrap featured_blog_wrap">
                <?php
                foreach ($blog_list as $k => $v) {
                    if ($v['Advice']['blog_type'] == 0) {
                        $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);
                        ?>
                            <a href="javascript:void(0);" class ="get-new-modal" data-type="advice" data-id ="<?php echo $v['Advice']['id'] ;?>" data-advice-type="<?php echo $v['Advice']['blog_type'];?>"data-advice-type="Archived Post" data-counterid="11" data-clickcount="3">
                            <div class="margin_bottom_space featureBlogSpace">
                                <div class="sideL">
                                     <?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                </div>
                                <div class="sideR">
                                    <span class="blogHead"><?php echo $v['Advice']['advice_title'] ?></span>
                                    <div class="blogHeadR">
                                        <?php echo $user_info[0]['users']['first_name'] . " " . $user_info[0]['users']['last_name'] ?>
                                    </div>
                                    <div class="blogAuthor"><em class="fontMed"><?php echo date('d M, Y', strtotime($v['Advice']['advice_update_date'])) ?></em></div>
                                    <a href="<?= $v['Advice']['source_url'] ?>" class="more fontMed" target="blank">Link goes in here</a>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            </a>
                        <?php
                    }
                    break;
                } ?>
                </div>
            </div>
            
            <div class="col-sm-5">
                <div class="sidebar-module sidebar-module-inset media_Sidebar_Module">
                    <div class="blog_media_wrap custom_scroll">
                        <?php
                        foreach ($blog_list as $k => $v) {
                            if ($v['Advice']['blog_type'] == 6) {
                                $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);
                                ?>
                                <a href="javascript:void(0);" class ="get-new-modal" data-type="advice" data-id ="<?php echo $v['Advice']['id'] ;?>" data-advice-type="<?php echo $v['Advice']['blog_type'];?>"data-advice-type="Archived Post" data-counterid="11" data-clickcount="3">
                                    <div class="margin_bottom_space">
                                        <div class="sideL">
                                            <?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'width' => '100%', 'border' => '0')); ?>
                                        </div>
                                        <div class="sideR">
                                            <span class="blogHead"><?php echo $v['Advice']['advice_title'] ?></span>
                                            <div class="blogHeadR">
                                                <?php echo $user_info[0]["users"]['first_name']." ".$user_info["users"]['last_name'] ?><br />
                                                <em><?php echo date('d M, Y', strtotime($v['Advice']['advice_update_date'])) ?></em><br/>
                                                <a href="<?= $v['Advice']['source_url'] ?>" class="more fontMed" target="blank">Link goes in here</a>
                                            </div>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                
                                <?php
                            }
                        }
                        ?></a>
                    </div>

                    <!--                    <div style="margin:0 0 2em;">
                                            <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'border' => '0')); ?>
                                            </div>
                                            <div class="sideR">
                                                <span class="blogHead">Title</span><br />
                                                <div class="blogHeadR">
                                                    Publication<br />
                                                    <em>Date</em><br />
                                                    <a href="" class="more fontMed">Link goes in here</a>
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                        </div>
                    
                                        <div style="margin:0 0 2em;">
                                            <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'border' => '0')); ?>
                                            </div>
                                            <div class="sideR">
                                                <span class="blogHead">Title</span><br />
                                                <div class="blogHeadR">
                                                    Publication<br />
                                                    <em>Date</em><br />
                                                    <a href="" class="more fontMed">Link goes in here</a>
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                        </div>
                    
                                        <div style="margin:0 0 2em;">
                                            <div class="sideL">
<?php echo $this->Html->image('blog-article-icon.png', array('alt' => '', 'class' => 'blogIco', 'border' => '0')); ?>
                                            </div>
                                            <div class="sideR">
                                                <span class="blogHead">Title</span><br />
                                                <div class="blogHeadR">
                                                    Publication<br />
                                                    <em>Date</em><br />
                                                    <a href="" class="more fontMed">Link goes in here</a>
                                                </div>
                                            </div>
                                            <div style="clear:both"></div>
                                        </div>-->
                </div>
            </div>
            <div style="clear:both"></div>
            <div class="vidMainBlock">
                <div class="blog-header">
                    <h1 class="H1">Videos</h1>
                </div>
                <div class="blog-box clearfix">
                    <div class="blog-post-box">
                        <?php
                        $i=0;
                        $videoUrl = array();
                        foreach ($blog_list as $k => $v) {
                            if ($v['Advice']['blog_type'] == 7) {
                                $user_info = $this->User->getUserData($v['Blog']['user_id_creator']);
                                $videoUrl = $this->Common->parseVideos($v['Advice']['source_url']);

                                ?>

                                <div class="col-sm-6 vidblock">
                                    <div class="col-sm-5 vidleft">
                                        <div class="vidPlay">
                                                <a href="javascript:void(0)">
    <?php echo$this->Html->image("video-play-white.png", array('alt' => '', 'border' => '0', 'class' => 'play-video-popup', 'data-toggle' => 'modal', 'data-target' => '#blogVideoPopup', 'data-video'=>$videoUrl[0]['url'], 'data-title'=>$v['Advice']['advice_title'])); ?>
                                                </a>
                                        </div>
        <?php echo (($v['Advice']['advice_image'] == "") ? $this->Html->image("sample.jpg", array('alt' => '', 'border' => '0')) : $this->Html->image("../".$v['Advice']['advice_image'], array('alt' => '', 'class' => 'vidPic', 'border' => '0'))); ?>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="blogAuthor"><?= $v['Advice']['advice_title'] ?></div>
                                        <div class="blogAuthor"><em class="fontMed"><?php echo date('d M, Y', strtotime($v['Advice']['advice_update_date'])) ?></em></div>
                                        <div class="blogHeadR fontMed lineH12">
                                            
                                            <?php
                                            echo $this->Text->truncate(
                                                    $v['Advice']['feature_blog'], 500, array(
                                                'ellipsis' => '...',
                                                'exact' => false
                                                    )
                                            );
                                            ?>
                                        </div>
                                    </div>
                                    <!--div style="clear:both"></div-->
                                </div>
                            <?php 
                                $i++;
                                if($i%2 == 0) {
                                    echo "<div style='clear:both'></div>";
                                }
                            }
                        }
                        ?>
                        <div style="clear:both"></div>
                    </div>
                    
                    <div style="clear:both"></div>
                    <div class="campaign">
                        <div class="blog-header">
                            <h1 class="H1 noPadBlog">CAMPAIGN</h1>
                        </div>
                        <div id="cf4a">
                            <?php echo $this->Html->image('campaign-banner-3.png', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?>
                            <?php echo $this->Html->image('campaign-banner-2.png', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?>
<?php echo $this->Html->image('campaign-banner.png', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
</div>
</div>
        <div class="modal fade modal-para-gap modalLoginWrap" id="show-modal" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header no-bg-modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-dismiss="modal"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">To view more Advices or Wisdom:</h4>
                    </div>
                    <div class="modal-body modal-center-body">
                        <a class="btn btn-Orange centerBtnBlock loginModalShow" data-dismiss="modal" data-toggle="modal" href="#myModal">Log In</a>
                        <div class="or-box"> 
                            <div class="or-wrap"></div>
                        </div>

                        <a  href="<?php echo Router::url(array('controller' => 'users', 'action' => 'register')); ?>"  class="btn btn-Orange centerBtnBlock">BECOME A CITIZEN</a>
                    </div>
                    <!--div class="modal-footer model-footer1 ">
                        <button type="button" class="btn btn-black" data-dismiss="modal" id="">OK</button>
                        <button type="button" class="btn btn-black" data-dismiss="modal" >Cancel</button>
                    </div-->
                </div>
            </div>
        </div>
    </div>
</div>

        <script type="text/javascript">
            $(document).ready(function () {
                $('body').on('click', '.play-video-popup', function () {
                    var $this = $(this);
                    var video = $this.data('video');
                    var title = $this.data('title');
                    $(".embed-responsive-item").attr('src', video);
                    $("#blogVideoPopup .modal-title").text(title);
                });

                /*	$('.loginModalShow').click(function(){
                 
                 $(".modalCloseWrapper").css("display","block").find("body").addClass("modal-open");
                 
                 });*//*hidden.bs.modal*/
                /*$('#myModal').on('shown.bs.modal', function () {
                    $("body").css("overflow-y", "hidden");
                });
                $('#myModal').on('hidden.bs.modal', function () {
                    $("body").addClass("modal-open");
                    $("body").css("overflow-y", "scroll");
                });
                $('#show-modal').on('shown.bs.modal', function () {
                    $("body").addClass("modal-open");
                    $("body").css("overflow-y", "hidden");
                });
                $('#show-modal').on('hidden.bs.modal', function () {
                    $("body").css("overflow-y", "scroll");
                });

                $('.loginModalShow').click(function () {

                    $('body').css('overflow-y', 'hidden');

                });*/
                /*	$("body").on('click','.loginModalShow',function(){
                 $(".modalLoginWrap").hide();
                 $(".roboto_light ul li:first a").click();
                 $("a[href='#myModal']").click();
                 });*/
            });

        </script>



<!-- video-popup-starts -->

<div class="modal fade front-blog-popup" id="blogVideoPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icons close-icon"></i></button>
        <h4 class="modal-title" id="myModalLabel">Test Video1</h4>
      </div>
      <div class="modal-body">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="//www.youtube.com/embed/zpOULjyy-n8?rel=0"></iframe>
            </div>
      </div>
    </div>
  </div>
</div>

<!-- video-popup-starts -->