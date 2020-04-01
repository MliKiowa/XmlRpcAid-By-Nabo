<?
/**
 * 我们的征程可是星辰大海
 *
 *
 * @package XmlRpcAid
 * @author 乔千
 * @version 1.7.0
 * @link https://blog.mumuli.cn
 */
require_once dirname(__FILE__) . "/ZipHelper.php";

class XmlRpcAid_Plugin implements Typecho_Plugin_Interface
{
    /** @var bool 请求适配器 */
    private static $_adapter = false;
    const action = 'XmlRpcUp';
    const panel = 'XmlRpcAid/console.php';

    public static function activate()
    {
        if (false == XmlRpcAid_Plugin::isAvailable()) {
            throw new Typecho_Plugin_Exception(_t('对不起, 您的主机没有打开 allow_url_fopen 功能而且不支持 php-curl 扩展, 无法正常使用此功能'));
        }

        if (false == XmlRpcAid_Plugin::isWritable(dirname(__FILE__) . '/temp/')) {
            throw new Typecho_Plugin_Exception(_t('对不起，插件目录不可写，无法正常使用此功能'));
        }
        Helper::addAction(XmlRpcAid_Plugin::action, 'XmlRpcAid_Action');
        Helper::addPanel(1, XmlRpcAid_Plugin::panel, 'XmlRpc更新', 'XmlRpc更新控制台', 'administrator');
        return _t("QAQ Loading...");
    }

    public static function deactivate()
    {
        Helper::removeAction(XmlRpcAid_Plugin::action);
        Helper::removePanel(1, XmlRpcAid_Plugin::panel);
        return _t('iwi Unloaded...');
    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $t = new Typecho_Widget_Helper_Form_Element_Radio(
            'Back',
            array('true' => _t('是'), 'false' => _t('否')),
            'true',
            _t('更新前备份相关文件'),
            _t('若启用升级前会备份相关文件')
        );
        $form->addInput($t);
        $t = new Typecho_Widget_Helper_Form_Element_Text('apiUrl', null, null, _t('代理加速api'), _t('作用：加速更新检测 不排查减速 可以使用https://bird.ioliu.cn/v2/?url='));
        $form->addInput($t);
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {

    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public static function UpdateXmlRpc($Identification)
    {
        $Back = Typecho_Widget::widget('Widget_Options')->plugin('XmlRpcAid')->Back;
        $file = dirname(dirname(dirname(dirname(__FILE__)))) . "/var/Widget/XmlRpc.php";
        XmlRpcAid_Plugin::downCurl("https://codeload.github.com/kraity/typecho-xmlrpc/legacy.zip/" . $Identification, dirname(__FILE__) . "/temp/xml.zip");
        // echo dirname(__FILE__)."/temp.zip";
        //echo $Identification;
        $zipXml = new ZipFolder();
        // var_dump($zip);
        $isZipOk = $zipXml->unzip(dirname(__FILE__) . "/temp/xml.zip", dirname(__FILE__) . "/temp");
        if (!$isZipOk) {
            return 1;
        }
        if ($Back) {
            rename($file, $file . $Identification . ".bak");
        } else {
            unlink($file);
        }
        $zipList = ($zipXml->fileList(dirname(__FILE__) . "/temp/xml.zip"));
        rename(dirname(__FILE__) . "/temp/" . $zipList["dirs"][0] . "XmlRpc.php", $file);
        return 0;
    }

    public static function downCurl($url, $filePath)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //打开文件描述符
        $fp = fopen($filePath, 'w+');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 20);
        curl_setopt($curl, CURLOPT_REFERER, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('User-Agent: Plugin(typecho)'));
        curl_setopt($curl, CURLOPT_FILE, $fp);
        //这个选项是意思是跳转，如果你访问的页面跳转到另一个页面，也会模拟访, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        //执行命令
        curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //关闭文件描述符
        fclose($fp);
    }

    public static function isAvailable()
    {
        function_exists('ini_get') && ini_get('allow_url_fopen') && (self::$_adapter = 'Socket');
        false == self::$_adapter && function_exists('curl_version') && (self::$_adapter = 'Curl');

        return self::$_adapter;
    }

    /**
     * 检测 是否可写
     * @param $file
     * @return bool
     */
    public static function isWritable($file)
    {
        if (is_dir($file)) {
            $dir = $file;
            if ($fp = @fopen("$dir/check_writable", 'w')) {
                @fclose($fp);
                @unlink("$dir/check_writable");
                return true;
            }
            return false;
        } else {
            if ($fp = @fopen($file, 'a+')) {
                @fclose($fp);
                return true;
            }
            return false;
        }
    }
}
