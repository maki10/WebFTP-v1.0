<?php

class ftpFile
{
	public $_conn; //Connect to ip and port ftp
	protected $_user; // Connect user to ftp
	public $__ftp;
	public $put;
	
	//************ Connect to ftp
	public function __construct($ftp_server, $ftp_port, $username, $pass)
	{
		$this->_conn = ftp_connect($ftp_server, $ftp_port);
		$this->_user = ftp_login($this->_conn, $username, $pass);
		ftp_pasv($this->_conn, true);
		$this->__ftp = "ftp://$username:$pass@$ftp_server:$ftp_port";
	}
	
	public function Patch($patch)
	{
		return $this->put = chdir($patch);
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
	
	public function Read($RFile)
	{
		$this->_read = fopen($this->__ftp , "r");
		$this->readText = fread($this->_read, filesize($this->__ftp));
		echo $this->readText;
	}
	
	
	public static function Write($Wfile, $Wtext)
	{
		$context = stream_context_create(array('ftp'=>array('overwrite' => true)));
		$open = fopen($Wfile , "w", false, $context);
		return fwrite($open, $Wtext);
	}
	
	public $test;
	
	public function Give_file($file)
	{
		$array = ftp_rawlist($this->_conn, $file);
		$array2 = join("\n", $array);
		preg_match_all('/^([drwx+-]{10})\s+(\d+)\s+(\w+)\s+(\w+)\s+(\d+)\s+(.{12}) (.*)$/m', $array2, $this->test, PREG_SET_ORDER);
		return $this->test;
	}
	
	private $__create;
	
	public function Createfile($name)
	{
		$this->__create = fopen($name,"w+");
		fwrite($this->__create, "/* Storm Hosting New File */");
	}
	
	public function Promeni($njega)
	{
		$this->__ftp .=  $njega;
		return ($this->__ftp);
	}
}