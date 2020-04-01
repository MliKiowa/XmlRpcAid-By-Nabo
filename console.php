<? 
include 'header.php';
include 'menu.php';
include dirname(__FILE__)."/GitHelper.php";
$releasearr=releases_s("kraity","typecho-xmlrpc");
$current = $request->get('act', 'index');
?>
<div class="main">
<div class="body container">

<div class="typecho-page-title">
<h2>更新设置</h2>
</div>

<table class="typecho-list-table">
<colgroup>
<col width="25%"/>
<col width="45%"/>
<col width="15%"/>
</colgroup>
<thead>
<tr>
<th>版本</th>
<th>描述</th>
<th>操作</th>
</tr>
</thead>
<tbody>
<?php
foreach( $releasearr as $vermain){
  $vermain=(array)$vermain;
  echo '<tr id="XmlRpc-'.$vermain["tag_name"].'">';
  echo "<td>".$vermain["name"]."</td>";
  echo "<td>".$vermain["body"]."</td>";
  echo' <td><a lang="你确认要更新 XmlRpc 到 '.$vermain["name"].'吗?" href="';
  $options->index("action/XmlRpcUp");
  echo "?do=Update&ver=".$vermain["name"].'">更新</a> </td>';
  echo "</tr>";
}
?>
</tbody>
</table>

</div>
</div>
</div>
<?php
include 'copyright.php';
include 'common-js.php';
include 'footer.php';
?>