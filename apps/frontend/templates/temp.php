
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <meta name="format-detection" content="telephone=no"/>
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/css/grid.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/camera.css"/>
        <link rel="stylesheet" href="/css/owl-carousel.css"/>
        <link rel="stylesheet" href="/css/touch-touch.css"/>
        <link rel="stylesheet" href="/css/google-map.css"/>
        <link rel="stylesheet" href="/css/search.css"/>

        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto+Slab:400,700">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,700">

        <link rel="stylesheet" href="/css/font-awesome.min.css">

        <script src="/js/jquery.js"></script>
        <script src="/js/jquery-migrate-1.2.1.js"></script>

        <!--[if lt IE 9]>
        <html class="lt-ie9">
        <div style=' clear: both; text-align:center; position: relative;'>
            <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
                <img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
                     alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
            </a>
        </div>
        <script src="/js/html5shiv.js"></script>
        <![endif]-->

        <script src='/js/device.min.js'></script>
    </head>
    <body>
        <div class="page">

            <!--========================================================
                                      HEADER
            =========================================================-->
            <?php include_partial('default/header') ?> 
            <!--========================================================
                                      CONTENT
            =========================================================-->
            <main>
                <?php echo $sf_content ?>
            </main>

            <!--========================================================
                                      FOOTER
            =========================================================-->
            <?php include_partial('default/footer') ?>  
        </div>
        <script src="/js/script.js"></script>
    </body>
</html>