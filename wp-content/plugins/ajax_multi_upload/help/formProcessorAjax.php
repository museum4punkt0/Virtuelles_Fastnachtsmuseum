<?php
$message = "";
$message .= "The form has been sent!<br />";
$message .= "Name: " . $_POST["name"];
$message .= "<br />Surname: " . $_POST["surname"];
if(count($_POST["AMUFiles"]))
{
	$message .= "<br />Uploaded files: ";
	for($i=0; $i<count($_POST["AMUFiles"]); $i++)
		$message .= "<br />" . $_POST["AMUFiles"][$i];
}
$result = array();
$result["message"] = $message;
echo "amu_start" . json_encode($result) . "amu_end";
?>