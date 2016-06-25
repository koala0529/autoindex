<?php

/**
 * @package AutoIndex
 *
 * @copyright Copyright (C) 2002-2004 Justin Hagstrom
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL)
 *
 * @link http://autoindex.sourceforge.net
 */

/*
   AutoIndex PHP Script is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   AutoIndex PHP Script is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!defined('IN_AUTOINDEX') || !IN_AUTOINDEX)
{
	die();
}

/**
 * Represents URLs. Deals with special characters and redirection/downloading.
 *
 * @author Justin Hagstrom <JustinHagstrom@yahoo.com>
 * @version 1.0.4 (November 9, 2007)
 * @package AutoIndex
 */
class Url
{
	/**
	 * @var string
	 */
	private $url;
	
	/**
	 * Rawurlencodes $uri, but not slashes.
	 *
	 * @param string $uri
	 * @return string
	 */
	public static function translate_uri($uri)
	{
		$uri = rawurlencode(str_replace('\\', '/', $uri));
		return str_replace(rawurlencode('/'), '/', $uri);
	}
	
	/**
	 * Returns the string with correct HTML entities so it can be displayed.
	 *
	 * @param string $str
	 * @return string
	 */
	public static function html_output($str)
	{
		return htmlentities($str, ENT_QUOTES, 'UTF-8');
	}
	
	/**
	 * Checks input for hidden files/folders, and deals with ".."
	 *
	 * @param string $d The URL to check
	 * @return string Safe version of $d
	 */
	private static function eval_dir($d)
	{
		$d = str_replace('\\', '/', $d);
		if ($d == '' || $d == '/')
		{
			return '';
		}
		$dirs = explode('/', $d);
		for ($i = 0; $i < count($dirs); $i++)
		{
			if (DirectoryList::is_hidden($dirs[$i], false))
			{
				array_splice($dirs, $i, 1);
				$i--;
			}
			else if (preg_match('/^\.\./', $dirs[$i])) //if it starts with two dots
			{
				array_splice($dirs, $i-1, 2);
				$i = -1;
			}
		}
		$new_dir = implode('/', $dirs);
		if ($new_dir == '' || $new_dir == '/')
		{
			return '';
		}
		if ($d{0} == '/' && $new_dir{0} != '/')
		{
			$new_dir = '/' . $new_dir;
		}
		if (preg_match('#/$#', $d) && !preg_match('#/$#', $new_dir))
		{
			$new_dir .= '/';
		}
		else if (DirectoryList::is_hidden(Item::get_basename($new_dir)))
		//it's a file, so make sure the file itself is not hidden
		{
			return DirItem::get_parent_dir($new_dir);
		}
		return $new_dir;
	}
	
	/**
	 * @param string $url The URL path to check and clean
	 * @return string Resolves $url's special chars and runs eval_dir on it
	 */
	public static function clean_input($url)
	{
		$url = rawurldecode( $url );
		$newURL = '';
		for ( $i = 0; $i < strlen( $url ); $i++ ) //loop to remove all null chars
		{
			if ( ord($url[$i]) != 0 )
			{
				$newURL .= $url[$i];
			}
		}
		return self::eval_dir( $newURL );
	}
	
	/**
	 * Sends the browser a header to redirect it to this URL.
	 */
	public function redirect()
	{
		$site = $this -> url;
		header("Location: $site");
		die(simple_display('Redirection header could not be sent.<br />'
		. "Continue here: <a href=\"$site\">$site</a>"));
	}
	
	/**
	 * @param string $file_dl
	 * @param bool $headers
	 */
	public static function force_download($file_dl, $headers = true)
	{
		if (!@is_file($file_dl))
		{
			header('HTTP/1.0 404 Not Found');
			throw new ExceptionDisplay('The file <em>'
			. self::html_output($file_dl)
			. '</em> could not be found on this server.');
		}
		if (!($fn = @fopen($file_dl, 'rb')))
		{
			throw new ExceptionDisplay('<h3>Error 401: permission denied</h3> you cannot access <em>'
			. Url::html_output($file_dl) . '</em> on this server.');
		}
		if ($headers)
		{
			$outname = Item::get_basename($file_dl);
			$size = @filesize($file_dl);
			if ($size !== false)
			{
				header('Content-Length: ' . $size);
			}
			$mime = new MimeType($outname);
			header('Content-Type: ' . $mime -> __toString() . '; name="' . $outname . '"');
			header('Content-Disposition: attachment; filename="' . $outname . '"');
		}
		global $speed;
		while (true)
		{
			$temp = @fread($fn, (int)($speed * 1024));
			if ($temp === '')
			{
				break;
			}
			echo $temp;
			flush();
			if (BANDWIDTH_LIMIT)
			{
				sleep(1);
			}
		}
		fclose($fn);
	}

public	function big_download($fileurl)
{
//exdownload($fileurl);
//return;
$sourceFile = $fileurl; //要下载的临时文件名  
$file_extension = strtolower(substr(strrchr($sourceFile, "."), 1)); //获取文件扩展名  
//echo $sourceFile;  
//if (!ereg("[tmp|txt|rar|pdf|doc]", $file_extension))exit ("非法资源下载");  
//检测文件是否存在  
if (!is_file($sourceFile)) { 
	echo "test...";
    die("<b>404 File not found!</b>");  
}  
$len = filesize($sourceFile); //获取文件大小  
$size = $len;
if($size < 33554432)
{
	$this -> redirect();
	return;
}
$filename = basename($sourceFile); //获取文件名字  
$outFile = $filename;
$outFile_extension = strtolower(substr(strrchr($outFile, "."), 1)); //获取文件扩展名  
//根据扩展名 指出输出浏览器格式  
switch ($outFile_extension) {  
    case "exe" :  
        $ctype = "application/octet-stream";  
        break;  
    case "zip" :  
        $ctype = "application/zip";  
        break;  
    case "mp3" :  
        $ctype = "audio/mpeg";  
        break;  
    case "mpg" :  
        $ctype = "video/mpeg";  
        break;  
    case "avi" :  
        $ctype = "video/x-msvideo";  
        break;  
    default :  
        $ctype = "application/force-download";  
}  
//Begin writing headers  
header("Cache-Control:"); 
header("Cache-Control: public");  
$mime = new MimeType($outFile);
$ctype=$mime -> __toString();
//设置输出浏览器格式  
//header("Content-Type: $ctype"); 
header("Content-Type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=" . $outFile);  
header("Accept-Ranges: bytes");  
	
//如果有$_SERVER['HTTP_RANGE']参数  
if (isset ($_SERVER['HTTP_RANGE'])) {  
    /*Range头域 　　Range头域可以请求实体的一个或者多个子范围。  
    例如，  
    表示头500个字节：bytes=0-499  
    表示第二个500字节：bytes=500-999  
    表示最后500个字节：bytes=-500  
    表示500字节以后的范围：bytes=500- 　　  
    第一个和最后一个字节：bytes=0-0,-1 　　  
    同时指定几个范围：bytes=500-600,601-999 　　  
    但是服务器可以忽略此请求头，如果无条件GET包含Range请求头，响应会以状态码206（PartialContent）返回而不是以200 （OK）。  
    */  
    // 断点后再次连接 $_SERVER['HTTP_RANGE'] 的值 bytes=4390912-  
    list ($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);  
    //if yes, download missing part  
    str_replace($range, "-", $range); //这句干什么的呢。。。。  
    $size2 = $size -1; //文件总字节数  
    $new_length = $size2 - $range; //获取下次下载的长度  
    header("HTTP/1.1 206 Partial Content");  
    header("Content-Length: $new_length"); //输入总长  
    header("Content-Range: bytes $range$size2/$size"); //Content-Range: bytes 4908618-4988927/4988928   95%的时候  
} else {  
    //第一次连接  
    //$size2 = $size -1;  
    //header("Content-Range: bytes 0-$size2/$size"); //Content-Range: bytes 0-4988927/4988928
	//header('HTTP/1.1 200 OK'); 
    //header("Content-Length: " . $size); //输出总长 
	$size2 = $size - 1;
	header ( "Content-Range: bytes 0-{$size2}/{$size}" ); //Content-Range: bytes 0-4988927/4988928
	header ( "Content-Length: " . $size ); //输出总长
}  
//打开文件  
$fp = fopen("$sourceFile", "rb");  
//设置指针位置  
fseek($fp, $range);  
//虚幻输出  
while (!feof($fp)) {  
    //设置文件最长执行时间  
    set_time_limit(0);  
    print (fread($fp, 1024 * 8)); //输出文件  
    flush(); //输出缓冲  
    ob_flush();  
}  
fclose($fp);  
exit (); 
	
}
	/**
	 * Downloads the URL on the user's browser, using either the redirect()
	 * or force_download() functions.
	 */
	public function download()
	{
		if (FORCE_DOWNLOAD)
		{
			@set_time_limit(0);
			self::force_download(self::clean_input($this -> url));
			die();
		}
		//$this -> redirect();
		self::big_download(self::clean_input($this -> url));
	}
	
	/**
	 * @param string $text_url The URL to create an object from
	 * @param bool $special_chars If true, translate_uri will be run on the url
	 */
	public function __construct($text_url, $special_chars = false)
	{
		if ($special_chars)
		{
			$text_url = self::translate_uri($text_url);
		}
		$this -> url = $text_url;
	}
	
	/**
	 * @return string Returns the URL as a string
	 */
	public function __toString()
	{
		return $this -> url;
	}
}

?>