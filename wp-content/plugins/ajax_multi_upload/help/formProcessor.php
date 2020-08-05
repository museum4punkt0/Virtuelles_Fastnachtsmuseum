<?php
echo "The form has been sent!<br />";
echo "Name: " . $_POST["name"];
echo "<br />Surname: " . $_POST["surname"];
if(count($_POST["AMUFiles"]))
{
	echo "<br />Uploaded files: ";
	for($i=0; $i<count($_POST["AMUFiles"]); $i++)
		echo "<br />" . $_POST["AMUFiles"][$i];
}
?>