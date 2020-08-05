<?php
error_reporting(0);
if($_POST["PHPSESSID"]!="")
{
	session_id($_POST["PHPSESSID"]);
	//session_name("your_session_name"); uncomment this if your session has a name
	session_start();
}
if($_POST["action"]=="upload")
{
	if(!empty($_FILES))
	{
		$result = array();
		$tempFile = $_FILES["Filedata"]["tmp_name"];
		
		require_once("../../../wp-config.php");
		$wp->init();
		$wp->parse_request();
		$wp->query_posts();
		$wp->register_globals();
		$wp->send_headers();
		$uploadsInfo = wp_upload_dir();
		$targetPath = "../../uploads" . $uploadsInfo["subdir"] . "/";
		
		$pathinfo = pathinfo($_FILES['Filedata']['name']);
		$fileExt = $pathinfo["extension"];
		//if($fileExt!="php" && $fileExt!="php5" && $fileExt!="php4" && $fileExt!="php3" && $fileExt!="html" && $fileExt!="htm" && $fileExt!="js")//if you want to prevent from upload the files with given extensions uncomment this line
		//{//if you want to prevent from upload the files with given extensions uncomment this line
			$fileName = stripslashes($pathinfo["filename"])/* . time()*/;
			$targetFile =  $targetPath . $fileName . "." . $fileExt;
			$realPath = realpath($targetPath);
			$documentRoot = realpath($_SERVER["DOCUMENT_ROOT"]);
			$realTargetPath = str_replace($documentRoot, "", $realPath) . "/";
			
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			//echo $realTargetPath;
			//if(move_uploaded_file($tempFile, $targetFile))
			$overrides = array( 'test_form' => false );
			//move image to the WP defined upload directory and set correct permissions
			if($_POST["thumbnails"]!="")
			{
				$thumbnailsExplode = explode(",", $_POST["thumbnails"]);
				if($_POST["thumbnailsCrop"]!="")
					$thumbnailsCropExplode = explode(",", $_POST["thumbnailsCrop"]);
				for($i=0; $i<count($thumbnailsExplode); $i++)
				{
					$dimensions = explode("x", trim($thumbnailsExplode[$i]));
					add_image_size('amu_thumbnail_' . $i, (int)$dimensions[0], (int)$dimensions[1], ($thumbnailsCropExplode[$i]=="true" ? true : false));
				}
			}
			//add_image_size('test', 180, 180, true);
			if($file = wp_handle_upload($_FILES["Filedata"], $overrides ))
			{
				$pathinfo = pathinfo($file["url"]);
				$targetFile = $pathinfo["dirname"] . "/" . $pathinfo["filename"] . "." . $pathinfo["extension"];
				//$image = wp_get_image_editor($uploadsInfo["path"] . "/" . $pathinfo["filename"] . "." . $pathinfo["extension"]);
				//error_log($uploadsInfo["path"] . "/" . $pathinfo["filename"] . "." . $pathinfo["extension"] , 3, "log.txt");
				//$image->resize(700, null, true);
				//$image->save($uploadsInfo["path"] . "/" . $pathinfo["filename"] . "." . $pathinfo["extension"]);
				//watermark
				$watermarks = array();
				$i = 0;
				while($_POST["watermark_path".$i]!="")
				{
					$watermarks[$i]["path"] = $_POST["watermark_path".$i];
					$watermarks[$i]["bottom"] =  $_POST["watermark_bottom".$i];
					$watermarks[$i]["right"] =  $_POST["watermark_right".$i];
					$i++;
				}
				if(count($watermarks))
				{
					require_once("functions.php");
					$imagesize = getimagesize($targetFile);
					$width = $imagesize[0];
					$height = $imagesize[1];
					/*$image = wp_get_image_editor(plugin_dir_path(__FILE__) . 'watermark.png');
					error_log(plugin_dir_path(__FILE__) . 'watermark.png', 3, "log.txt");
					$image->resize($width, $height, true);
					$image->save(plugin_dir_path(__FILE__) . 'watermark-' . $width . 'x' . $height . '.png');
					$watermarks[0]["path"] = plugin_dir_path(__FILE__) . 'watermark-' . $width . 'x' . $height . '.png';*/
					//resizeImage($width, $height, $file["file"], $file["file"], $watermarks);
				}
				
				$wp_filetype = wp_check_filetype(basename($realTargetPath . $fileName . "." . $fileExt), null );
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($realTargetPath . $fileName . "." . $fileExt)),
					'post_content' => '',
					'post_status' => 'inherit',
					'post_author' => $_POST["userId"]
				);
				if((int)$_POST["postId"]>0 && $_POST["attachimages"]=="currentPost")
					$attach_id = wp_insert_attachment( $attachment, $file["file"], (int)$_POST["postId"] );
				else
					$attach_id = wp_insert_attachment( $attachment, $file["file"], null );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file["file"] );
				wp_update_attachment_metadata( $attach_id,  $attach_data );
				
				$attached_file = get_attached_file($attach_id);
				//error_log($attached_file, 3, "log.txt");
				$thumbs = wp_get_attachment_metadata($attach_id);
		
				//error_log($uploadsInfo["path"] . "/" . $thumbs["sizes"]["test"]["file"], 3, "log.txt");
				
				//generate thumbnails after the main file is uploaded
				if($_POST["thumbnails"]!="")
				{
					$result["thumbnails"] = array();
					for($i=0; $i<count($thumbnailsExplode); $i++)
					{
						$watermarks[0]["path"] = "watermark-" . $_POST["option"] . ".png";
						$watermarks[0]["bottom"] = 0;
						$watermarks[0]["right"] = 0;
						require_once("functions.php");
						$dimensions = explode("x", trim($thumbnailsExplode[$i]));
					
						resizeImage((int)$dimensions[0], (int)$dimensions[1], $uploadsInfo["path"] . "/" . $thumbs["sizes"]['amu_thumbnail_' . $i]["file"], $uploadsInfo["path"] . "/" . $thumbs["sizes"]['amu_thumbnail_' . $i]["file"], $watermarks);

						$result["thumbnails"][] = (isset($attach_data["sizes"]['amu_thumbnail_' . $i]["file"]) ? $attach_data["sizes"]['amu_thumbnail_' . $i]["file"] : $pathinfo["filename"] . "." . $pathinfo["extension"]);
					}
				}
			}
			else
				$result["error"] .= " Upload failed!";
		/*}
		else
			$result["error"] .= " Cannot upload " . $fileExt . " files!";
		//if you want to prevent from upload the files with given extensions uncomment this block
		*/
		$current_user = wp_get_current_user();
		$result["userID"] = $current_user->ID;
		$result["path"] = $pathinfo["dirname"] . "/";
		$result["filename"] = $pathinfo["filename"] . "." . $pathinfo["extension"];
		$result["extension"] = $pathinfo["extension"];
		$result["attach_id"] = $attach_id;
		
		/*$result["path"] = $realTargetPath;
		$result["filename"] = $fileName . "." . $fileExt;
		$result["extension"] = $fileExt;
		$result["attach_id"] = $attach_id;*/
		echo json_encode($result);
		exit();
	}
}
else if($_POST["action"]=="remove")
{
	require_once("../../../wp-config.php");
	$wp->init();
	$wp->parse_request();
	$wp->query_posts();
	$wp->register_globals();
	$wp->send_headers();
	$uploadsInfo = wp_upload_dir();
	$targetPath = "../../uploads" . $uploadsInfo["subdir"] . "/";
	$message = "";
	
	wp_delete_attachment($_POST["attach_id"]);
	echo $message;

	//$message = "";
	/*if you uploading files to other than files directory, you've got to change it in three below lines
	in function pathinfo, in if statement and in unlink function*/
	/*$pathInfo = pathinfo("files/".stripslashes($_POST["filename"]));
	if($pathInfo['dirname']=="files")
	{
		if(!@unlink("files/".stripslashes($_POST["filename"])))
			 $message = "Error - file not found! ";
	}
	else
		$message = "Security error!";
	echo $message;*/
}
?>