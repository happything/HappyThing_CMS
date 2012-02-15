<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
<head>
    <title>Titulo :: <?= $title ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="/css/set.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/libs/jquery-1.6.2.min.js"><\/script>')</script>
</head>
<body>
    <div class="container">
        <header>                
            <nav>
                <!-- Main menú -->
            </nav>
        </header>

        <div class="main" role="main">
            
            <!-- Main content -->
            <?= $content ?>
        </div>

        <footer>
        </footer>
    </div>

    <!-- scripts concatenated and minified via ant build script-->
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    <!-- end scripts-->


    <!--[if lt IE 7 ]>
            <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
            <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
    <![endif]-->
</body>
</html>