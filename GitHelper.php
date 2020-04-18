<?
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
   function releases_s($username,$reposname,$api) {return json_decode(api_get($api."https://api.github.com/repos/".$username."/".$reposname."/releases"));} 
