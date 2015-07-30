<?php

class ftpFile
{
	protected $_conn; //Connect to ip and port ftp
	protected $_user; // Connect user to ftp
	public $put;
	
	//************ Connect to ftp
	public function __construct($ftp_server, $ftp_port, $username, $pass)
	{
		$this->_conn = ftp_connect($ftp_server, $ftp_port);
		$this->_user = ftp_login($this->_conn, $username, $pass);
	}
	
	public function Patch($patch)
	{
		$this->put = $patch;
		return ftp_chdir($this->_conn, $patch);
	}
	
	public function Upload($file,$file_Name)
	{
		$put = '/'.$this->put .'/'. $file_Name;
		if (ftp_put($this->_conn, $put, $file, FTP_ASCII)) {
			echo "Succesfuly upload file!";
		}else{
			echo "There are some error while uploading process!";
		}
	}
	
	public function CreateFolder($folderName)
	{
		if(ftp_chdir($this->_conn, '/'.$this->put.'/'.$folderName) == 1){
			echo "Folder exist!";
		}else{
			ftp_mkdir($this->_conn, $folderName);
			echo "Folder $folderName is create!";
		}
	}
	
	public function DeleteFile($d_file)
	{
		if(ftp_delete($this->_conn,$d_file) == 1){
			echo "Succesfuly delete file!";
		}else{
			echo "There is some error while deleting file $d_file !";
		}
	}

	protected $_sizeOf;
	protected $_fileName;
	
	//----Folder must be empty to delete
	public function DeleteFolder($folderDel)
	{
		$this->_sizeOf = ftp_nlist($this->_conn, $folderDel);
		if(is_array($this->_sizeOf)){
			for($i=0;$i<sizeof($this->_sizeOf);$i++){
				$this->_fileName = basename($this->_sizeOf[$i]);
			if(ftp_size($this->_conn, $folderDel.'/'.$this->_fileName) == -1){ 
				$this->DeleteFolder($folderDel.'/'.$this->_fileName); 
			}else{
				ftp_delete($this->_conn, $folderDel.'/'.$this->_fileName);
				}
			}
		}
		ftp_rmdir($this->_conn, $folderDel);
		echo "Succesfuly deleted folder $folderDel and everthing insaide!";
		return true;
	}
	
	protected $_read;
	public $readText;
	
	public function Read($RFile){
		$this->_read = fopen($RFile, "r");
		$this->readText = fread($this->_read, filesize($RFile));
		return $this->readText;
	}
	
	protected $_write;
	
	public function Write($Wfile, $Wtext){
		$this->_write = fopen($Wfile, "w+");
		fwrite($this->_write, stripslashes($Wtext));
		return true;
	}
	
	
}
