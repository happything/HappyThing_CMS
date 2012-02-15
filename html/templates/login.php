<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
<head>
    <title>HappyCMS - Login</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="" />    
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="/css/set.css" />    
    <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/libs/jquery-1.6.2.min.js"><\/script>')</script>
    <style>
        body { background: url(/css/img-cms/login-shadow.jpg) repeat-x; text-align: center; font-family: Helvetica; }
        .content { width: 800px; margin:15px auto; text-align: left; }        
        .logo { margin: 0px 0 10px 0; }
        .left,.login { width: 360px; padding: 20px 20px 20px 0; float:left; }
        .left { background: url(/css/img-cms/login-left-shadow.jpg) no-repeat right top; height: 274px; width: 340px; padding-right: 20px; }
        .left .title { color:#0d4673; letter-spacing: 1px; font-size: 12px; margin-bottom: 10px; }
        .left .features { color:#5694a8; font-size: 18px; font-style: italic; }
        .left .features p { margin-bottom: 15px; padding: 10px 0 0 70px; }
        .login h1 { width: 273px; height: 33px; background: url(/css/img-cms/start-the-fun.jpg) no-repeat; overflow: hidden; text-indent: -1000px; margin-bottom: 20px; }
        .login div { color:#0d4673; }
        .login .input { margin-bottom: 0px; }
        .login div input.error { border:1px solid #df8989; }
        .login div span .error { color:#df8989; }
        .login div label { display: block; margin-bottom: 0; }
        .login div input { border:1px solid #ccc; width: 320px; height: 24px; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; -o-border-radius:3px; font-size: 12px; }
        .login a { font-family: georgia; font-style: italic; color:#0199ca; display: block; margin-bottom: 10px; text-decoration: underline; }
        .login a:hover { text-decoration: none; color:#0d4673; }
        
        
    </style>    
</head>
<body>
    <div class="content">
        <div class="logo">
            <img src="/img/happycms-logo-login.png" alt="HappyCMS" title="HappyCMS" />
        </div>        
        
        <div class="alert-message alert alert-block alert-error fade in" style="display: none;"></div>

        <div class="left">
            <p class="title"> This is for you, the best way to manage all the content of your website. You only need login and voila! Enjoy all the features that gonna make you happy. </p>
            <div class="features">
                <p style="font-size: 18px;">
                    <img src="" alt="" />
                    Create, modify or remove anything easily.
                </p>
                <p style="font-size: 18px;">
                    <img src="" alt="" />
                    Manage every corner of your website.
                </p>
                <p style="font-size: 18px; position: relative;">
                    <img src="" alt="" />
                    Simple + Beauty = <img src="/img/happy-label.jpg" alt="happy" title="happy" style="position: absolute; right: 40px; top:10px;"/>
                </p>
            </div>
        </div>
        <div class="login">
            <h1>Start the fun!</h1>
            <form action="/happycms/login/processing" method="post" id="login">
                <div class="input">
                    <label>User</label>
                    <input type="text" name="username" id="username" class="required user" placeholder="Here the username" />
                    <span class="help-inline"></span>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="required" placeholder="Here the password" />
                    <span class="help-inline"></span>
                </div>
                <a href="">Oh no! I don’t remember my password</a>
                <input class="btn" type="submit" value="Login" />                
            </form>
        </div>    
    </div>   
    <script src="/js/libs/validate.js"></script>
    <script>
        
        $(document).ready(function(){
            jQuery.validator.addMethod('user', function(value, element){
                return this.optional(element) || /^[a-zA-Z0-9-_]+$/.test(value);
            }, "The user is dosen't allowed");
           $('#login').validate({
                errorElement   : 'span',
                errorPlacement : function(error, element){
                    error.appendTo(element.next('.help-inline'));
                }            
            }); 
        });
        
        <?php if(isset($get) && $get != false && is_array($get) && count($get) >= 2){ ?>
            
        $(document).ready(function(){
            <?php if($get[1] == 1) { ?>                    
                $(".alert-message").html("Where are the user and password? I can't see it, type it again please.").fadeIn(200);            
            <?php } else if($get[1] == 2){ ?>
                $(".alert-message").html("The user or password doesn't exist, don't you remember it?. Try again or ask for them.").fadeIn(200);
            <?php } ?>
        });
        
        <?php } ?>
    </script>    
</body>
</html>