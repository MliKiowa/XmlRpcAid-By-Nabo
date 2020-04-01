<?php

class XmlRpcAid_Action extends Typecho_Widget implements Widget_Interface_Do
{
    public function action()
    {
        $this->on($this->request->is('do=Update'))->UpxmlRpc();
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function UpxmlRpc()
    {
        $mreQuest = $this->request->from('ver');
        if (!$this->widget('Widget_User')->pass('administrator')) {
            $this->widget('Widget_Notice')->set("无权限", 'fail');
        }
        $able = XmlRpcAid_Plugin::UpdateXmlRpc($mreQuest['ver']) == 0;
        $this->widget('Widget_Notice')->set($able ? "更新完成" : "解压失败", $able ? 'success' : 'fail');
        /** 转向原页 */
        $this->response->goBack();
    }
}