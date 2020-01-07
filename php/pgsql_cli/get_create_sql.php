<?php
$a = " id                   | integer                     | not null
 advertiser_id        | character varying(50)       | not null
 campaign_id          | character varying(100)      | not null
 ad_id                | character varying(100)      | default ''::character varying
 ld_id                | integer                     | not null
 ios_appid            | character varying(50)       | not null default ''::character varying
 android_appid        | character varying(50)       | not null default ''::character varying
 android_download_url | character varying(200)      | not null default ''::character varying
 bnldm_id             | integer                     | not null
 name                 | character varying(100)      | not null default ''::character varying
 status               | character varying(50)       | default ''::character varying
 app_type             | character varying(50)       | default ''::character varying
 copy_ad_id           | character varying(100)      | default '0'::character varying
 delivery_range       | character varying(30)       | not null default 'DEFAULT'::character varying
 adduser              | character varying(50)       | not null default ''::character varying
 addtime              | timestamp without time zone | not null default '1970-01-01 00:00:00'::timestamp without time zone";

$a = str_replace("\n", "|", $a);

$a = explode('|', $a);

$b = [];
$c = [];
foreach ($a as $row) {
    $row = trim($row);
    $c[] = $row;
    if (count($c) === 3) {
        $b[] = $c;
        $c = [];
    }
}
$sql = [];
foreach ($b as $item) {
    $sql[] = implode(' ', $item);
}
$sql = implode(",\n  ", $sql);

$sql = "CREATE TABLE `toutiao_campaign` (
  {$sql}
)";

echo $sql;
