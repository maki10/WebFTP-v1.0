<?php

require "Classes/WebFTP.php";

#TODO class ftpFile extends Database

$ftp = new ftpFile('IP ADRESS', 'PORT', 'USER','PASS');
$ftp->Patch('$_GET['patch']'.'/'); //----- Patch to your folder

?>
/* UPLOAD FILE FORM
<form action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="upload_file" value="yes" />
<input type="file" name="file" class="filename" size="25" /> 
<input type="image" src="template/images/upload_button.png" class="upload_button" />
</form>
<?php

$ftp->Upload($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]); //----- Upload file form

$ftp->CreateFolder('maki10_folder'); //---- Create Folder

$ftp->DeleteFile('logo.png'); //---- Delete file

$ftp->DeleteFolder('maki10_folder'); //---- If the folder is not empty it will first delete the files and then folder

$ftp->Read('sss.txt'); //--- Read a file

$ftp->Write('sss.txt','Who is you boss?'); //---- Write file, some text
