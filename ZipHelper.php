<?php
class ZipFolder
{
  protected $zip;
  protected $root;
  protected $ignored_names;
  public function __construct(){
      $this->zip = new ZipArchive;
    }
    /**
    * 解压zip文件到指定文件夹
    *
    * @access public
    * @param string $zipfile 压缩文件路径
    * @param string $path 压缩包解压到的目标路径
    * @return booleam 解压成功返回 true 否则返回 false
    */
    public function unzip ($zipfile, $path) {
        if ($this->zip->open($zipfile) === true) {
          $file_tmp = @fopen($zipfile, "rb");
          $bin = fread($file_tmp, 15); //只读15字节 各个不同文件类型，头信息不一样。
          fclose($file_tmp);
          /* 只针对zip的压缩包进行处理 */
          if (true === $this->getTypeList($bin))
          {
            $result = $this->zip->extractTo($path);
            $this->zip->close();
            return $result;
          }
        else
          {
            return false;
          }
        }
        return false;
      }
    
          /**
          * 读取压缩包文件与目录列表
          *
          * @access public
          * @param string $zipfile 压缩包文件
          * @return array 文件与目录列表
          */
          public function fileList($zipfile) {
              $file_dir_list = array();
              $file_list = array();
              if ($this->zip->open($zipfile) == true) {
                for ($i = 0; $i < $this->zip->numFiles; $i++) {
                  $numfiles = $this->zip->getNameIndex($i);
                  if (preg_match('/\/$/i', $numfiles))
                  {
                    $file_dir_list[] = $numfiles;
                  }
                else
                  {
                    $file_list[] = $numfiles;
                  }
                }
              }
              return array('files'=>$file_list, 'dirs'=>$file_dir_list);
            }
            /**
            * 得到文件头与文件类型映射表
            *
            * @author wengxianhu
            * @date 2013-08-10
            * @param $bin string 文件的二进制前一段字符
            * @return boolean
            */
            private function getTypeList ($bin)
              {
                $array = array(
                array("504B0304", "zip")
                );
                foreach ($array as $v)
                {
                  $blen = strlen(pack("H*", $v[0])); //得到文件头标记字节数
                  $tbin = substr($bin, 0, intval($blen)); ///需要比较文件头长度
                  if(strtolower($v[0]) == strtolower(array_shift(unpack("H*", $tbin))))
                  {
                    return true;
                  }
                }
                return false;
              }
            }
