<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{config:language}">
<head>
	<title>{words:index of} {info:dir}</title>
	<link href="{config:template}default.css" rel="stylesheet" title="AutoIndex Default" type="text/css" />
	<link rel="icon" href="/favicon.png">
	<link href="{config:template}alternate.css" rel="alternate stylesheet" title="AutoIndex Alternate" type="text/css" />
	<link rel="stylesheet" type="text/css" href="upload/Huploadify.css"/>
	<script type="text/javascript" src="upload/jquery.js"></script>
	<script type="text/javascript" src="upload/jquery.Huploadify.js.php?dir={info:subdir}"></script>
	<script type="text/javascript">
		$(function(){
			var up = $('#upload').Huploadify({
				auto:false,
				fileTypeExts:'*.*',
				multi:true,
				fileSizeLimit:99999999,
				breakPoints:true,
				saveInfoLocal:true,
				showUploadedPercent:true,//是否实时显示上传的百分比，如20%
				showUploadedSize:true,
				removeTimeout:9999999,
				uploader:'upload/upload.php',
				onUploadStart:function(){
					//up.settings('formData', {aaaaa:'1111111',bb:'2222'});
					up.Huploadify('settings','formData', {aaaaa:'1111111',bb:'2222'});
				},
				onUploadSuccess:function(file){
					//alert('上传成功');
				},
				onUploadComplete:function(){
					//alert('上传完成');
				},
				/*getUploadedSize:function(file){
					var data = {
						data : {
							fileName : file.name,
							lastModifiedDate : file.lastModifiedDate.getTime()
						}
					};
					var url = 'http://49.4.132.173:8080/admin/uploadfile/index/';
					var uploadedSize = 0;
					$.ajax({
						url : url,
						data : data,
						async : false,
						type : 'POST',
						success : function(returnData){
							returnData = JSON.parse(returnData);
							uploadedSize = returnData.uploadedSize;
						}
					});
					return uploadedSize;
				}	*/	
			});

			$('#btn1').click(function(){
				up.stop();
			});
			$('#btn2').click(function(){
				up.upload('*');
			});
			$('#btn3').click(function(){
				up.cancel('*');
			});
			$('#btn4').click(function(){
				//up.disable();
				up.Huploadify('disable');
			});
			$('#btn5').click(function(){
				up.ennable();
			});
			$('#btn6').click(function(){
				up.destroy();
			});

		});
</script>
</head>
<body class="autoindex_body">