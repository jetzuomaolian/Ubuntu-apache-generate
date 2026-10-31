<?php

$domainnames=trim($_GET["domainname"]);
$domainnames = preg_replace('/\s+/', ' ', $domainnames);
$domainnames=strtolower($domainnames); //所有字母全部转小写

$firstname=explode('.', $domainnames)[0];

//var_dump($domainnames);
//var_dump($firstname);

if (isset($_GET['flexwwwChecked'])) {
    //echo "复选框已选中，值为：" . $_GET['flexCheckChecked'];
    $domainnames.=' www.'.$domainnames;
}
//var_dump($domainnames);

//查找第一个空格的位置，分成两段
$pos = strpos($domainnames, ' ');

$miandomainname='';
$subdomainnames='';

if ($pos !== false) {
    $miandomainname = substr($domainnames, 0, $pos);
    $subdomainnames = substr($domainnames, $pos + 1);

}

//var_dump($miandomainname);
//var_dump($subdomainnames);

//exit;


$rootpath="/var/www/$firstname";

if (isset($_GET['flexCheckChecked'])) {
    //echo "复选框已选中，值为：" . $_GET['flexCheckChecked'];
    $rootpath.="/public";
}
//var_dump($rootpath);

//读nginx模板
$moban="moban/apacheTemplate";

$content=@file_get_contents($moban);

//替换
$content=str_replace("{{miandomainname}}", $miandomainname, $content);
$content=str_replace("{{subdomainnames}}", $subdomainnames, $content);


$content=str_replace("{{rootpath}}", $rootpath, $content);

//var_dump($content);

$outputname="$firstname.conf";

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $outputname . '"');
header('Content-Length: ' . strlen($content));

echo $content;

