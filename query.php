<?php
		require "common.php";
		require "config.php";
		require "Page.class.php";
		$kw   = $_GET['q'];
		$p    = isset($_GET['p']) ? intval($_GET['p']) :1;
		$url = 'http://ssapi.liangmlk.cn/Pan-query-q-'.$kw.'-p-'.$p.'-ak-'.$ak.'.html';
		$res = curl_http($url,'get');
		$msg = '';
		if(preg_match('/error/',$res)){
			$error = json_decode($res,true);
			$msg = $error['msg'];
		}
		preg_match('/list(.*?)\}\)/',$res,$out);
		$str = "{\"list".$out[1].'}';
		$res = json_decode($str,true);
		$page = new Pagination($res['list']['count'], 10);
		$page->pagerCount = 8;

?>
<!doctype html>
<html>
        <head>
            <meta charset='utf-8'/>
            <title><?php echo $title; ?>-<?php echo $kw;?>-第<?php echo $p;?>页</title>
            <meta content="width=device-width,initial-scale=1.0" name="viewport">
            <link rel="icon" type="image/x-icon" href="<?php echo $icon; ?>">
            <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.0.0/css/bootstrap.min.css">
            <script type="text/javascript" src="//img.liangmlk.top/Public/Js/jquery.min.js"></script>
            <script type="text/javascript" src="//img.liangmlk.top/Public/Js/bootstrap.min.js"></script>
            <script type="text/javascript" src="tag.js"></script>
            <link rel="stylesheet" type="text/css" href="page.css">
            <meta name="keywords"    content="<?php echo $kw;?>|<?php echo $keyword; ?>">
            <meta name="description" content="<?php echo $kw;?>,<?php echo $description; ?>">
            <style>
            	a {
            		text-decoration: none;
            	}
        	</style>
        </head>
        <body>	
        		<?php if(empty($kw)) die('<p class="alert alert-danger">搜索关键词不能空!<a href="/index.php">返回</a></p>'); ?>
        		<div class="container" style="margin-top:80px;; margin-bottom:10px;">
	                <div class="row">
	                    <div class="col-md-6 col-md-offset-3">   
	                        <div class="input-group col-xs-12">
	                            <form  action="query.php" method="get" id='form'>
	                                <div class="input-group">
	                                	<input autofocus placeholder="请输入资源名" name="q" type="text" id='kw'  class="form-control" value='<?php echo $kw;?>' />
	                                	<span class="input-group-btn">
	                                    	<button type="button" class="btn" onclick='show()' style="background:#3385ff;border-bottom:1px solid #2d78f4;padding-right:10px;padding-left:16px;color:#fff;"><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;</button>
	                                  	</span>
	                                </div>
	                            </form>      
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <script>
	            	function show(){
                        if($('#kw').val() == ''){
                            alert('关键字不能为空');
                            return false;
                        }
	                    $('#form').submit()
                    }
	            </script>

        		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
					<div class="container">
						<div class="navbar-header" style="min-width:60%">
							<button type="button" id="navbar_toggle_btn" class="navbar-toggle btn btn-default btn-lg" data-toggle="collapse" data-target="#nav_collapse" style="margin-top:13px;margin-bottom:13px">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="/index.php" id="tlogo" style='padding:0px;'><img src="http://img.liangmlk.top/Public/Images/logo-bq.png" alt=""></a>
						</div>
						<div class="collapse navbar-collapse" id="nav_collapse">
							<ul class="nav navbar-nav navbar-right">
								<li class="">
									<a href="http://passport.liangmlk.cn/Login-index.html" target='_blank'>
									登录
									</a>
								</li>
								<li class="">
									<a href="http://passport.liangmlk.cn/Register-index.html" target='_blank'>
									注册
									</a>
								</li> 
							</ul>
						</div>
					</div>
				</div>
				<script>
        			function redict(url,title,des){
        				document.cookie="title="+title;
        				document.cookie="des="+des; 
        				window.location.href=url;
        			}
        		</script>
                <div class='container' style=''>
                		<div class='row'>
                			<div class='alert alert-danger'>
                				<?php if(!empty($msg)){ ?>
                				<?php echo $msg; ?>
                				<?php }else{  ?>
                					为您找到"<?php echo  $kw;?>"相关结果约 <?php echo $res['list']['count']?> 个
                				<?php } ?>
                			</div>
                		</div>
                		<?php foreach($res['list']['data'] as $k=>$v){ ?>
                		<?php $url = str_replace(array('http://yun.baidu.com/s/','http://pan.baidu.com/s/','https://pan.baidu.com/s/'),'',$v['blink']);   ?>
                		<div class='row'>
                				<div class='col-md-12'>
									<h3><a onclick="redict('/detail.php?url=<?php echo $url; ?>','<?php echo $v['title'];?>','<?php echo empty($v['des'])?'暂无信息':$v['des']; ?>')" target='_blank'><?php echo $v['title'];?></a></h3>
	                				<div class='' style='color:red;'><?php echo empty($v['des'])?'暂无信息':$v['des']; ?></div>
	                			</div>
                		</div>
                		<br/>
                		<?php } ?>

                		<br />
                		<div class='row'>
                			<div class='col-md-12 text-center'>
                				<?php echo $page->links(); ?>
                			</div>
                		</div>

                </div>
            	<script>
            		$(function(){
            			$('select[name="pageSize"]').remove();
            		});
            	</script>
        		<div style='margin-top:20px;'></div>

	            <div class='alert alert-success text-center' style=''>
	               声明：本站搜索结果来自自定义搜索，不存储任何网盘内容，只提供信息检索服务。如果有侵犯的地方，联系我们及时整改。
	            </div>
        </body>
</html>
