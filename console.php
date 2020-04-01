<?php /** @noinspection PhpIncludeInspection */
include 'header.php';
include 'menu.php';
include dirname(__FILE__) . "/GitHelper.php";
$releaseArr = releases_s("kraity", "typecho-xmlrpc", Typecho_Widget::widget('Widget_Options')->plugin('XmlRpcAid')->apiUrl);
$isApex = file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . "/admin/ApexUi.php");
if ($isApex) include 'ApexUi.php';
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
                <div class="col-mb-12 typecho-list row">
                    <div class="col-mb-12 col-tb-12 row" role="main">
                        <form method="post" name="manage_posts" class="operate-form">
                            <div class="typecho-table-wrap">
                                <table class="typecho-list-table">
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
                                    if (!$isApex) {
                                        foreach ((array)$releaseArr as $verMain) {
                                            $verMain = (array)$verMain;
                                            ?>
                                            <tr id="XmlRpc-<?php echo $verMain["tag_name"] ?>'">
                                                <td><?php echo $verMain["name"] ?></td>
                                                <td><?php echo $verMain["body"] ?></td>
                                                <td><a lang="你确认要更新 XmlRpc 到 <?php echo $verMain["name"] ?> '吗?"
                                                       href="<?php $options->index("action/XmlRpcUp") ?>?do=Update&ver=<?php echo $verMain["name"] ?>
                                    ">更新</a></td>
                                            </tr>
                                            <?
                                        }
                                    } else {
                                        foreach ($releaseArr as $verMain) {
                                            $verMain = (array)$verMain; ?>
                                            <tr id="XmlRpc-<?php echo $verMain["tag_name"] ?>">
                                                <td><span class="badge badge-pill badge-default"
                                                          style="padding-left: 1px;padding-bottom: 1px;padding-top: 1px;">    <font
                                                                style="vertical-align: inherit;"><font
                                                                    style="text-transform:capitalize vertical-align: inherit;">   <img
                                                                        class="avatar rounded-circle"
                                                                        src="<?php Typecho_Common::gravatarUrl($user->mail, 220, 'X', 'mm', $request->isSecure()) ?>"
                                                                        width="10" height="10"
                                                                        style="margin-right:5px;height:35px;width:35px;"></a>
                                                                南博<?php echo $verMain["name"] ?></font></font></span>
                                                </td>
                                                <td><?php echo $verMain["body"] ?></td>
                                                <td><a class="btn btn-danger btn-sm text-white"
                                                       lang="你确认要更新 XmlRpc 到<?php echo $verMain["name"] ?>吗?"
                                                       href="<?php $options->index("action/XmlRpcUp"); ?>?do=Update&ver="<?php echo $verMain["name"] ?>
                                                    ">更新</a></td>
                                            </tr>
                                            <?
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$isApex ?: include 'copyright.php';
include 'common-js.php';
include($isApex ? 'Apexfooter.php' : 'footer.php');
?>
