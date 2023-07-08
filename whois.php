<?php

// 定义顶级域名和对应的 WHOIS 服务器
$whois_servers = array(
    "com" => "whois.verisign-grs.com",
    "net" => "whois.verisign-grs.com",
    "org" => "whois.publicinterestregistry.net",
    "xin" => "whois.nic.xin",
    "edu" => "whois.educause.edu",
    "gov" => "whois.dotgov.gov",
    "cn" => "whois.cnnic.cn",
    "uk" => "whois.nic.uk",
    "de" => "whois.denic.de",
    "jp" => "whois.jprs.jp",
    "au" => "whois.audns.net.au",
    "ca" => "whois.ca",
    "gay" => "whois.nic.gay",
    "shop" => "whois.nic.shop",
    // 添加更多的域名和对应的 WHOIS 服务器
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = $_POST['domain'];
    $domain_parts = explode(".", $domain);
    $tld = strtolower(end($domain_parts)); // 获取顶级域名

    if (isset($whois_servers[$tld])) {
        $whois_server = $whois_servers[$tld];
        $whois_query = $domain;

        // 连接 WHOIS 服务器
        $whois_socket = fsockopen($whois_server, 43);
        if (!$whois_socket) {
            die("无法连接到 WHOIS 服务器");
        }

        // 发送查询请求
        fwrite($whois_socket, $whois_query . "\r\n");

        // 读取响应并去除空行
        $response = '';
        while (!feof($whois_socket)) {
            $line = trim(fgets($whois_socket, 128));
            if (!empty($line)) {
                $response .= $line . PHP_EOL;
            }
        }

        // 关闭连接
        fclose($whois_socket);

        // 输出响应
        echo nl2br($response);
    } else {
        echo "不支持查询该顶级域名的 WHOIS 信息";
    }
}
