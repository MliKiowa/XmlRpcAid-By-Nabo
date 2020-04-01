<?
//测试token 49e22b37f6795a9264909642c5afcc123cc4e2fb
//https://api.github.com/users/solomonxie
function api_get($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'User-Agent: GitStatic'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($ch);
    curl_close ($ch);
    return $result;
  }

  function user_info($username) {return json_decode(api_get("https://api.github.com/users/".$username)); }
    //不存在会返回一个message Not Found 获取用户基本信息

    function repos_all($username) {return json_decode(api_get("https://api.github.com/users/".$username."/repos")); }
      //获取所有repos
      function repos_info($username,$reposname) {return json_decode(api_get("https://api.github.com/repos/".$username."/".$reposname)); }
        //获取repos info
        function repos_path($username,$reposname,$path) {return json_decode(api_get("https://api.github.com/repos/".$username."/".$reposname."/contents/".$path)); }
          //获取repos 目录内容
          function get_sha($username,$repos,$path){$json=(array)repos_path($username,$repos,$path); return $json["sha"]; }
            //获取文件sha
            function releases_lastest($username,$reposname) {return json_decode(api_get("https://api.github.com/repos/".$username."/".$reposname."/releases/latest")); }
              //拉取最新打包文件
              function releases_s($username,$reposname) {return json_decode(api_get("https://api.github.com/repos/".$username."/".$reposname."/releases")); }
               /* $releasearr=releases_s("kraity","typecho-xmlrpc");
                foreach( $releasearr as $vermain){
               $vermain=(array)$vermain;
                 echo "tag:".$vermain["tag_name"];
                  echo "name:".$vermain["name"];
                  echo "zipball_url:".$vermain["zipball_url"];
                  echo "body:".$vermain["body"];
                  //var_dump($vermain);
                }
              */