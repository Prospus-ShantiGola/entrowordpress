<div class="explore">
<ul class="list links list-adjst">
    <?php
    foreach ($faqlist as $faq) {
        ?>
        <li><span></span><a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'faqListing', $faq['Faq']['id'])) ?>"><?php echo $faq['Faq']['question'] ?> </a></li><?php
}
    ?>
</ul>
<a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'faqListing')) ?>" class="anchor-right">View All</a>
</div>