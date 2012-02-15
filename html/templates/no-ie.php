<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?= $title ?></title>
        <link rel="stylesheet" href="/css/set.css" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <style type="text/css">
            @font-face {
                font-family: 'Antipasto';
                src: url('/css/fontface/cms/antipasto-webfont.eot');
                src: url('/css/fontface/cms/antipasto-webfont.eot?#iefix') format('embedded-opentype'),
                     url('/css/fontface/cms/antipasto-webfont.woff') format('woff'),
                     url('/css/fontface/cms/antipasto-webfont.ttf') format('truetype'),
                     url('/css/fontface/cms/antipasto-webfont.svg#AntipastoRegular') format('svg');
                font-weight: normal;
                font-style: normal;
            }

            body{ font-family: 'Antipasto',Georgia,Helvetica,Arial,sans-serif; font-size: 32px; background: url('/css/img-cms/texture.jpg') repeat; }
            .container{ width: 740px; margin: 0 auto; }
            .head{ padding-bottom: 40px; border-bottom: 1px solid #d4d4d4; }
            .head span.block{ display: block; }
            .hide{ display: none; }
            h1, h2{ text-align: center; }
            h2{ color: #0199ca; }
            h2 span.block span{ color: #0d4673; }
            span.arrows{ background: url("/css/img-cms/browser-arrows.png") no-repeat; display: inline-block; height: 76px; left: 190px; position: relative; width: 302px; }
            .head ul{ margin: 0 auto; width: 380px; }
            .head ul li{ float: left; font-size: 20px; margin: 0 5px; }
            .head ul li a{ display: inline-block; text-align: center; color: #959595; }
            .head ul li a:hover{ color: #0d4673; }
            .head ul li a img{ display: block; }
            .head p{ margin-top: 20px; color: #0d4673; font-size: 18px; font-family: Georgia,Times New Roman,sans-serif; font-style: italic; text-align: center; }
            .head p span.block a{ color: #000; text-decoration: underline; }
            .body{ padding-top: 40px; border-top: 1px solid #fff; margin-bottom: 60px;}
            .body ol li{ margin-bottom: 20px; }
            .body ol li p{ text-align: center; color: #333333; }
            .body ol li p span{ color: #0199ca; }
            .body ol li a{ color: #0199ca; text-decoration: underline; text-align: center; display: block; font-family: Georgia,Times New Roman,sans-serif; font-size: 16px; font-style: italic; }
            .foot{ border-top: 1px solid #d4d4d4; width: 300px; margin: 0 auto; }
            .foot ul li{ float: left; margin: 0 5px; }
            .foot ul li a{ color: #959595; font-family: Georgia,Times New Roman,sans-serif; font-size: 14px; font-style: italic; }
            .foot ul li a:hover{ text-decoration: underline; color: #0199ca; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="head">
                <h1>
                    <span class="ir">Happy CMS</span>
                    <img src="/img/cms/noie-logo.png" alt="Happy CMS" />
                </h1>
                <h2>¿Eres feliz usando Internet Explorer? <span class="block">Prueba alguna de estas <span>opciones</span> y lo serás aún más.</span></h2>
                <span class="arrows"></span>
                <ul class="clearfix">
                    <li>
                        <a href="http://www.google.com/chrome" target="_blank" rel="nofollow"><img src="/img/cms/chrome-logo.png" alt="Chrome" />Chrome</a>
                    </li>
                    <li>
                        <a href="http://www.mozilla.org/es-MX/firefox/fx/" target="_blank" rel="nofollow"><img src="/img/cms/firefox-logo.png" alt="Firefox" />Firefox</a>
                    </li>
                    <li>
                        <a href="http://www.apple.com/safari/download/" target="_blank" rel="nofollow"><img src="/img/cms/safari-logo.png" alt="Safari" />Safari</a>
                    </li>
                    <li>
                        <a href="http://www.opera.com/download/" target="_blank" rel="nofollow"><img src="/img/cms/opera-logo.png" alt="Opera" />Opera</a>
                    </li>
                </ul>
                <p>Si te preguntas ¿por qué recomendamos estas excelentes opciones? <span class="block">Mejor te decimos <a href="#">por qué no usar Internet Explorer</a></span></p>
            </div>
            <div class="body hide">
                <ol>
                    <li>
                        <p><span>1)</span> Es inseguro. Muchos "huecos" de seguridad han sido descubiertos hasta ahora y constantemente se descubren mas.</p>
                        <a href="#" target="_blank">Mira lo que la gente dice</a>
                    </li>
                    <li>
                        <p><span>2)</span> Está por detrás de muchos navegadores en cuanto a cumplimiento de estándares, esto obstaculiza a los diseñadores web para que usen trucos muy buenos para sus sitios. Esto se debe por muchos errores que tiene.</p>
                        <a href="#">¿Quiéres ver un ejemplo?</a>
                    </li>
                    <li>
                        <p><span>3)</span> No tiene muchas de las características de usabilidad de los navegadores más modernos como Chrome, Firefox, Safari u Opera. Usa uno de estos por un tiempo y no querrás volver atrás</p>
                        <a href="#">:truestory:</a>
                    </li>
                </ol>
            </div>
            <div class="foot">
                <ul class="clearfix">
                    <li><a href="#">Ir arriba</a></li>
                    <li><a href="http://www.google.com/chrome" target="_blank" rel="nofollow">Chrome</a></li>
                    <li><a href="http://www.mozilla.org/es-MX/firefox/fx/" target="_blank" rel="nofollow">Firefox</a></li>
                    <li><a href="http://www.apple.com/safari/download/" target="_blank" rel="nofollow">Safari</a></li>
                    <li><a href="http://www.opera.com/download/" target="_blank" rel="nofollow">Opera</a></li>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.head').css('border-bottom', 'none');
                $('.head p a').click(function(){
                    $('.head').css('border-bottom', '1px solid #d4d4d4');
                    $('.body').slideDown('slow').show();
                })
            })
        </script>
    </body>
</html>