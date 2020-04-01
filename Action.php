<?php
class XmlRpcAid_Action extends Typecho_Widget implements Widget_Interface_Do
{
  public function action()
    { 
      $this->on($this->request->is('do=Update'))->UpxmlRpc(); 
    }
    public function UpxmlRpc(){
        $mrequest = $this->request->from('ver');
        if(!$this->widget('Widget_User')->pass('administrator'));
        {
          $this->widget('Widget_Notice')->set("无权限", 'fail' ); 
        }
        $isup=XmlRpcAid_Plugin::UpdateXmlRpc($mrequest['ver']); 

        switch($isup){
          case 0:
          $this->widget('Widget_Notice')->set("更新完成", 'success' );
          break;
          case 1:
          $this->widget('Widget_Notice')->set("解压失败", 'fail' );
          break; 
        }
       // var_dump($isup);
        /** 转向原页 */
         $this->response->goBack();
      }
    }