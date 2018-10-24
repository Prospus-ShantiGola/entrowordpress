<?php //include_once 'header.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" dir="ltr">
    <head>
        <title><?php echo 'User :: '; ?></title>
        <!--==============================meta tag================================-->
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <meta name="viewport" content="width=device-width" />

            <!--==============================css files================================-->
            <link type="text/css" rel="stylesheet" media="all" href="/naex/css/jquery-ui.css" />
            <link type="text/css" rel="stylesheet" media="all" href="/naex/css/bootstrap.min.css" />
            <link type="text/css" rel="stylesheet" media="all" href="/naex/css/bootstrap-modal.css" />
            <link type="text/css" rel="stylesheet" media="all" href="/naex/css/custom.css" />
            <link type="text/css" rel="stylesheet" media="all" href="/naex/css/style.css" />
            <link type="text/css" rel="stylesheet" media="all" href="/naex/css/browser.css" />

            <!--==============================js files================================-->
            <?php echo $this->Html->script('jquery-1.9.1');?>
            <?php echo $this->Html->script('jquery-ui');?>
            <?php echo $this->Html->script('bootstrap.min');?>
            <?php echo $this->Html->script('bootbox');?>
            <?php echo $this->Html->script('bootstrap-modal');?>
            <?php echo $this->Html->script('bootstrap-modalmanager');?>
            <?php echo $this->Html->script('browser');?>
          
            <script type="text/javascript">
                $(document).ready(function() {
                    $('li').has('ul').mouseover(function() {
                        $(this).children('ul').show();
                    }).mouseout(function() {
                        $(this).children('ul').hide();
                    });
                });
            </script>

    </head>
    <body>
        

        <!--==============================header end================================-->

        <?php echo $content_for_layout; ?>	
        
        
       
	
	
        <!--==============================content end================================-->		

        <footer>
            <div id="footer" class="container">
                <div class="section">

                </div>
            </div>	
        </footer>
        <!--==============================footer end================================-->
        <?php echo $this->Html->script('script');?>
        <?php echo $this->Html->script('custom');?>
        <!--==============================scripts here================================-->	
        <?php //echo $this->element('sql_dump'); ?>
        <?php echo $this->Js->writeBuffer();?>
       
    </body>
</html>