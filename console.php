<?php
include 'header.php';
include 'menu.php';
include dirname(__FILE__)."/GitHelper.php";
$releasearr=releases_s("kraity","typecho-xmlrpc",Typecho_Widget::widget('Widget_Options')->plugin('XmlRpcAid')->apiurl);
$isapex=file_exists(dirname(dirname(dirname(dirname(__FILE__))))."/admin/ApexUi.php");
if($isapex)include 'ApexUi.php';
?>
<div class="container-fluid mt--6">
<div class="row">
<div class="main col">
<div class="body container card">
<div class="card-header"> 
<h3 class="mb-0"> 
<?php include 'page-title.php'; ?>
</h3> 
</div>
<table class="table align-items-center table-flush table-hover typecho-list-table">
<colgroup>
<col width="25%"/>
<col width="45%"/>
<col width="15%"/>
</colgroup>
<thead class="thead-light"> 
<tr class="nodrag">
<tr>
<th>版本</th>
<th>描述</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php
if(!$isapex){
  foreach((array)$releasearr as $vermain)
  {
    $vermain=(array)$vermain;
    echo '<tr id="XmlRpc-'.$vermain["tag_name"].'">';
    echo "<td>".$vermain["name"]."</td>";
    echo "<td>".$vermain["body"]."</td>";
    echo' <td><a lang="你确认要更新 XmlRpc 到 '.$vermain["name"].'吗?" href="';
    $options->index("action/XmlRpcUp");
    echo "?do=Update&ver=".$vermain["name"].'">更新</a> </td>';
    echo "</tr>";
  }
}else{
  foreach( $releasearr as $vermain)
  {
    $vermain=(array)$vermain; 
    echo '<tr id="XmlRpc-'.$vermain["tag_name"].'">'; 
    echo '<td>    <span class="badge badge-pill badge-default" style="padding-left: 1px;padding-bottom: 1px;padding-top: 1px;">    <font style="vertical-align: inherit;"><font style="text-transform:capitalize vertical-align: inherit;" >   <img class="avatar rounded-circle" src="'.Typecho_Common::gravatarUrl($user->mail, 220,'X','mm', $request->isSecure()).'" width="10" height="10" style="margin-right:5px;height:35px;width:35px;"></a>    南博'.$vermain["name"]."</font></font></span></td>"; echo "<td>".$vermain["body"]."</td>"; 
    echo' <td><a class="btn btn-danger btn-sm text-white" lang="你确认要更新 XmlRpc 到 '.$vermain["name"].'吗?" href="'; $options->index("action/XmlRpcUp"); 
    echo "?do=Update&ver=".$vermain["name"].'">更新</a></td>';
    echo "</tr>";
  }
}
?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<?php
$isapex?:include 'copyright.php';
include 'common-js.php';
include ($isapex? 'Apexfooter.php':'footer.php');
?>
