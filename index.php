<?php
    require "common.php";
    require "config.php";

    /*$file = __DIR__.'/index.json';
    if(file_exists($file) and time()-filemtime($file)<8*3600 ){
        $res = json_decode( file_get_contents(__DIR__.'/index.json') ,true);
        $r = array_chunk($res,30);
    }else{*/
        $url = 'http://ssapi.liangmlk.cn/Pan-hotwords-ak-'.$ak.'.html';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        file_put_contents($file, $res);
        $res = json_decode( $res ,true);
        $r = array_chunk($res,30);
    //}
?>
<!doctype html>
<html>
    <head>
        <meta charset='utf-8'/>
        <title><?php echo $title; ?></title>
        <link rel="icon" type="image/x-icon" href="<?php echo $icon; ?>">
        <meta content="width=device-width,initial-scale=1.0" name="viewport">
        <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap/3.0.0/css/bootstrap.min.css">
        <script type="text/javascript" src="//img.liangmlk.top/Public/Js/jquery.min.js"></script>
        <script type="text/javascript" src="//img.liangmlk.top/Public/Js/bootstrap.min.js"></script>
        <meta name="keywords"    content="<?php echo $keyword; ?>">
        <meta name="description" content="<?php echo $description; ?>">
    </head>
    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header" style="min-width:60%">
                    <button type="button" id="navbar_toggle_btn" class="navbar-toggle btn btn-default btn-lg" data-toggle="collapse" data-target="#nav_collapse" style="margin-top:13px;margin-bottom:13px">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/index.php" id="tlogo" style='padding:0px;'>
                        <img src="http://img.liangmlk.top/Public/Images/logo-bq.png"/> 
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="nav_collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="http://passport.liangmlk.cn/Login-index.html" target='_blank'>
                            登录
                            </a>
                        </li>
                        <li>
                            <a href="http://passport.liangmlk.cn/Register-index.html" target='_blank'>
                            注册
                            </a>
                        </li> 
                    </ul>
                </div>
            </div>
        </div>
                
        <div class="container" style="margin-top:280px; margin-bottom:30px;">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">   
                    <div class="input-group col-xs-12">
                        <form  action="/query.php" method="get" id='form'>
                            <div class="input-group">
                              <input autofocus placeholder="请输入资源名" id='kw' name="q" type="text"  class="form-control" />
                              <span class="input-group-btn">
                                <button type='button'  class="btn" style="background:#3385ff;border-bottom:1px solid #2d78f4;padding-right:10px;padding-left:16px;color:#fff;" onclick="show()"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;</button>
                              </span>
                            </div>
                        </form>      
                    </div>
                </div>
            </div>
            <br/><br/>
            <script>
                function show(){
                    if($('#kw').val() == ''){
                        alert('关键字不能为空');
                        return false;
                    }
                    $('#form').submit()
                }
            </script>

            <div class='row' >
                <div class="col-md-8 col-md-offset-2" style='border: 0px solid #ccc;'> 
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active"><a href="#dy" data-toggle="tab">电影</a></li>
                        <li><a href="#dsj" data-toggle="tab">电视剧</a></li>
                        <li><a href="#zy" data-toggle="tab">综艺</a></li>
                        <li><a href="#dm" data-toggle="tab">动漫</a></li>
                        <li><a href="#xs" data-toggle="tab">小说</a></li>
                        <li><a href="#mv" data-toggle="tab">美女</a></li>
                        
                    </ul>
                    <div id="myTabContent" class="tab-content" >
                        <div class="tab-pane fade in active" id="dy">
                            <?php foreach($r[0] as $k=>$v){ ?>
                                <div class='col-md-4' style='padding:2px;'><span class="label label-primary"><?php echo $k+1;?></span> &nbsp; <a href='/query.php?q=<?php echo $v;?>'><?php echo $v;?></a></div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="dsj">
                            <?php foreach($r[1] as $k=>$v){ ?>
                                <div class='col-md-4' style='padding:2px;'><span class="label label-success"><?php echo $k+1;?></span> &nbsp; <a href='/query.php?q=<?php echo $v;?>'><?php echo $v;?></a></div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="zy">
                            <?php foreach($r[2] as $k=>$v){ ?>
                                <div class='col-md-4' style='padding:2px;'><span class="label label-info"><?php echo $k+1;?></span> &nbsp; <a href='/query.php?q=<?php echo $v;?>'><?php echo $v;?></a></div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="dm">
                            <?php foreach($r[3] as $k=>$v){ ?>
                                <div class='col-md-4' style='padding:2px;'><span class="label label-warning"><?php echo $k+1;?></span> &nbsp; <a href='/query.php?q=<?php echo $v;?>'><?php echo $v;?></a></div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="xs">
                            <?php foreach($r[4] as $k=>$v){ ?>
                                <div class='col-md-4' style='padding:2px;'><span class="label label-danger"><?php echo $k+1;?></span> &nbsp; <a href='/query.php?q=<?php echo $v;?>'><?php echo $v;?></a></div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="mv">
                            <?php foreach($r[5] as $k=>$v){ ?>
                                <div class='col-md-4' style='padding:2px;'><span class="label label-default"><?php echo $k+1;?></span> &nbsp; <a href='/query.php?q=<?php echo $v;?>'><?php echo $v;?></a></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style='margin:10 auto;'></div>

        <div class='alert alert-success text-center' style='margin-bottom:-10px;'>
            声明：本站搜索结果来自自定义搜索，不存储任何网盘内容，只提供信息检索服务。如果有侵犯的地方，联系我们及时整改。
        </div>
    
    </body>
</html>
