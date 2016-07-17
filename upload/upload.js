var dirvar;
function SetDir(dir)
{
	dirvar=dir;
	//alert("ok");
}

function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}
$(function(){
			var up = $('#upload').Huploadify({
				auto:false,
				fileTypeExts:'*.*',
				multi:true,
				fileSizeLimit:99999999,
				breakPoints:true,
				saveInfoLocal:false,
				showUploadedPercent:true,//是否实时显示上传的百分比，如20%
				showUploadedSize:true,
				removeTimeout:1,
				currentdir:dirvar,
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