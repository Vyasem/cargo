<!DOCTYPE html>
<html>
    <head>
        <meta charset="windows-1251">
        <title><?=$title?></title>
        <link rel="stylesheet" href="views/css/style.css" type="text/css">
        <script src="views/js/common.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <div id="header_inner">
                <a class="main" href="/">На главную</a>
                <?php if(isset($link)){?>
                    <?=$link?>
                <?php }?>
                <?php if(isset($status)){?>
                    <span>
                        <?=$status?>
                    <span>
                <?php }?>
            </div>
        </header>
        <div id="wrapper">
            <?=$data?>
        </div>
        <footer>

        </footer>
    </body>
</html>