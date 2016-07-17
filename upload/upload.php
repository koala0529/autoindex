<?php
header("Content-Type:text/html;charset=utf-8");
//$filename = $_FILES['file']['name'];
// $key = $_POST['key'];
// $key2 = $_POST['key2'];
// if ($filename) {
//     move_uploaded_file($_FILES["file"]["tmp_name"],
//       "uploads/" . $filename);
// }
// echo $key;
// echo $key2;


//$filename = $_FILES['file']['name'];
//header('Content-type: application/octet-stream;charset=UTF-8'); 
$filename = $_POST['fileName'];
$fileSize = $_POST['fileSize'];
$dir = $_POST['dir'];
$syn = $_POST['syn'];
$uploadDone=$_POST['uploadDone'];
if(empty($dir))
{
	$dir="../";
}
else
{
	$dir="../".$dir;
}
$array = array();
if ($filename) {
    //$filename = iconv('UTF-8', 'GBK', $filename);
	/*$xmlstr =  $GLOBALS[HTTP_RAW_POST_DATA];//$_POST["data"];//
	if(empty($xmlstr)) $xmlstr = file_get_contents('php://input');
	$raw = $xmlstr;//得到post过来的二进制原始数据*/
    //file_put_contents('uploads/'.$filename,$_FILES["file"]["tmp_name"],FILE_APPEND);
	if($syn=="false")
	{
		if(file_exists($dir.$filename.".tmp"))
			$array['size'] = filesize($dir.$filename.".tmp");
		else
			$array['size']= 0;
		$array['syn']= "true";
		echo json_encode($array);
	}
	else
	{
		if($uploadDone=="false")
		{
			file_put_contents($dir.$filename.".tmp",file_get_contents($_FILES["file"]["tmp_name"]),FILE_APPEND);
			$array['size'] = filesize($dir.$filename.".tmp");
			$array['syn']= "true";
			echo json_encode($array);
		}
			
		else
			rename($dir.$filename.".tmp",$dir.$filename);
		
	}
	
    //$array['getsize'] = $_FILES['file']['size'];
    //$array['file'] =  file_get_contents('php://input');
    //$array['success'] = true;
		//$array['size'] = filesize($dir.$filename.".tmp");
		//$array['syn']= $syn;
		//echo json_encode($array);
    
}


?>