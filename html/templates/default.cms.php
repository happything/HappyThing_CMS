<?php
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $browser = substr("$browser", 25, 8);
    $username = "";
    if(isset($_SESSION["user_name"])) $username = $_SESSION["user_name"];
    
    if($browser == "MSIE 6.0" || $browser == "MSIE 7.0" || $browser == "MSIE 8.0"){
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /happycms/noie");
        exit();
    }
?>
<!DOCTYPE html>
<!--[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
<head>
    <title>HappyCMS - <?= $title ?></title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="/css/set.css" />
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap-image-gallery.min.css" />
    <link rel="stylesheet" href="/css/cms-style.css" />
    <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="top-bar clearfix">
        <div class="main-menu">
            <span class="logo sep">
                <a href="/happycms/"><img src="/img/cms-logo.png" alt=""/></a>
            </span>
            <?= $menu->show("cms"); ?>            
        </div>
        <div class="general-tools">
            <div class="tools sep">
                <a class="img-tool" id="img-tool">Sub-menu</a>
                <div class="sub-menu hidden">
                    <ul>                        
                        <li><i class="icon-book"></i><a href="/happycms/pages">Pages</a></li>
                        <li>
                            <i class="icon-user"></i>
                            Users
                            <ul class="level2">
                                <li><i class="icon-search"></i><a href="/happycms/users">View</a></li>
                                <li><i class="icon-user"></i> <a href="/happycms/users/user">New User</a></li>
                            </ul>
                        </li>
                        <li>
                            <i class="icon-list-alt"></i>
                            Options
                            <ul class="level2">
                                <li><i class="icon-info-sign"></i><a href="/happycms/info">Site info</a></li>                                
                            </ul>
                        </li>
                        <li><i class="icon-picture"></i><a href="/happycms/media">Media</a></li>
                        <li><i class="icon-question-sign"></i><a href="/happycms/help">Help</a></li>
                        <li><i class="icon-question-sign"></i><a href="/happycms/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="prof-info">
                <span>                    
                    <span>Hi,</span>
                    <span class="us-prof-name"><?= utf8_encode($username) ?></span>
                </span>
            </div>
        </div>
    </div>
    <div class="main-content container-fluid">
        <?= $content; ?>
    </div>
    <div class="main-footer">
        <span>Developed by Happything.</span>
        <ul>
            <li><a href="/happycms/media">Media</a></li>
            <li><a href="/happycms/pages">Pages</a></li>
            <li><a href="/happycms/users">Users</a></li>
            <li><a href="/happycms/info">Site Info</a></li>
            <li><a href="/happycms/help">Help</a></li>
        </ul>
    </div>
    
    <script charset="utf-8">
        var sub_menu_selected = false;
        $("#img-tool").click(function(){
            if(!sub_menu_selected) { $(this).addClass("selected"); $(".sub-menu").removeClass("hidden"); sub_menu_selected = true; } else { $(this).removeClass("selected"); $(".sub-menu").addClass("hidden"); sub_menu_selected = false; }            
        });
    </script>
</body>
</html>