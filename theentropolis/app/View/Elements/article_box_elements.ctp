
<div class="explore">
<ul class="list links">
    <?php
    foreach ($articleList as $article) {
        ?>
        <li><span></span><a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'articleDetail', $article['HelpTopic']['id'])) ?>"><?php echo $article['HelpTopic']['topic'] ?> </a></li><?php
}
    ?>
</ul>
<a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'articleListing')) ?>" class="anchor-right">View All</a>
</div>