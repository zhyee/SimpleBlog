<?php

class ExceptionCode{
	const CODE_NOT_WRITABLE = 101;
	const CODE_WRONG_FILETYPE = 102;
	const CODE_FILE_TOO_LARGE = 103;
	const CODE_COPY_ERROR = 104;
	const CODE_ACCESS_REFUSE = 105;
}


class FileUploader
{

    /**
     * @var null 文件对象
     */
    private $fileObj = NULL;
    /**
     * @var string  上传协议
     */
    private $protocol;

    /**
     * @var 网站域名
     */
    private $domain;

    /**
     * @var null 图片存放路径
     */
    private $path = NULL;

    public function __construct(FileObj $fileObj)
    {
        $this->fileObj = $fileObj;
		$protocol = explode('/', $_SERVER['SERVER_PROTOCOL']);
		$this->protocol = $protocol[0] ? strtolower($protocol[0]) . '://' : 'http://'; 
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->init();
    }

    public function init(){}

    public function setFileObj(FileObj $fileObj){
        $this->fileObj = $fileObj;
    }

    public function getFileObj(){
        return $this->fileObj;
    }

    /**
     * 设置协议
     * @param $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * 获取协议
     * @return string
     */
	public function getProtocol(){
		return $this->protocol;
	}

    /**
     * 设置域名
     * @param $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * 获取域名
     * @return 网站域名
     */
	public function getDomain(){
		return $this->domain;
	}

    /**
     * 获取文件保存的路径
     * @return null|string
     * @throws Exception
     */
    public function getPath()
    {
        if($this->path) return $this->path;
        $path = getcwd() . '/' . date('Ymd') . '/' . date('H');
        if(!is_dir($path)){
            if(!mkdir($path, 0777, true)){
                throw new Exception(getcwd() . '无可写权限', ExceptionCode::CODE_NOT_WRITABLE);
            }
        }
        return $this->path = ltrim(str_replace($_SERVER['DOCUMENT_ROOT'], '', $path), '/');
    }

    /**
     * 上传图片
     * @return string
     * @throws Exception
     */
    public function upload(){
        return $this->protocol . $this->domain . '/' . ltrim($this->fileObj->save($this->getPath()), '/');
    }
}

class FileObj
{

	/**
     * @var string  文件上传大小限制
     */
    const MAX_FILE_SIZE = 2097152;
	
	/**
     * @var string  通信密钥 用于数据验证
     */
    const SECRECT_KEY = 'yah^92j2dJHAJH*)#)!@!)MDS';
	
	/**
     * @var array   支持的图片扩展名
     */
	private $allowExtensions = ['jpg', 'jpeg', 'gif', 'png'];

    /**
     * @var 原始文件名
     */
    private $fileName;

    /**
     * @var  文件扩展名
     */
    private $extension;

    /**
     * @var 上传文件大小
     */
    private $fileSize;

    /**
     * @var 上传的错误码
     */
    private $errorCode;

    /**
     * @var 临时文件
     */
    private $tempFile;

    /**
     * @var 最终保存的文件名
     */
    private $saveName = NULL;

    public function __construct($file = NULL)
    {
		$timestamp = (int)$_POST['timestamp'];
		$token = trim($_POST['token']);
		
		if($token !== md5(self::SECRECT_KEY . $timestamp)){
			throw new Exception('您的请求已被服务器拒绝', ExceptionCode::CODE_ACCESS_REFUSE);
		}

        $this->loadFile($file);
        if(!in_array($this->extension, $this->allowExtensions)){
            throw new Exception('不合法的文件类型', ExceptionCode::CODE_WRONG_FILETYPE);
        }

        if($this->fileSize > self::MAX_FILE_SIZE){
            throw new Exception('文件大小超过限制', ExceptionCode::CODE_FILE_TOO_LARGE);
        }
    }

    /**
     * @return 原始文件名
     */
    public function getFileName(){
        return $this->fileName;
    }

    /**
     * @return 文件扩展名
     */
    public function getExtension(){
        return $this->extension;
    }

    /**
     * @return 上传文件大小
     */
    public function getFileSize(){
        return $this->fileSize;
    }

    /**
     * @return 上传的错误码
     */
    public function getErrorCode(){
        return $this->errorCode;
    }

    /**
     * @return 临时文件
     */
    public function getTempFile(){
        return $this->tempFile;
    }

    /**
     * @param null $file  加载上传文件信息
     */
    private function loadFile($file = NULL){
        if($file === NULL && $_FILES){
            $file = reset($_FILES);
        }

        if(is_array($file) && $file){
            $this->fileName = $file['name'];
            $this->extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $this->fileSize = $file['size'];
            $this->errorCode = $file['error'];
            $this->tempFile = $file['tmp_name'];
        }
    }

    /**
     * 生成保存的文件名
     */
    public function getSaveName(){
        if($this->saveName) return $this->saveName;
        $this->saveName = uniqid(mt_rand(1000, 9999)) . '.' . $this->extension;
        return $this->saveName;
    }

    /**
     * 把临时文件保存到某个位置
     * @param $path
     * @param bool|false $deleteTemp  是否删除临时文件
     * @return string  返回最终保存的路径和文件名
     * @throws Exception
     */
    public function save($path){
        if(!is_dir($path)){
            throw new Exception('文件夹' . $path . '不存在');
        }
        if(move_uploaded_file($this->tempFile, rtrim($path, '/') . '/' . $this->getSaveName())){
            return rtrim($path, '/') . '/' . $this->getSaveName();
        }else{
            throw new Exception('复制临时文件失败', ExceptionCode::CODE_COPY_ERROR);
        }
    }
}

try{

    $fileloader = new FileUploader(new FileObj());
	echo json_encode([
		'err_code' => 0,
		'url' => $fileloader->upload()
	]);
} catch (Exception $e) {
	echo json_encode([
		'err_code' => $e->getCode(),
		'msg' => $e->getMessage()
	]);
}




