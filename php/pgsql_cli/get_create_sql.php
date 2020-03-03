<?php

$table = 'result_admin.mk_matierial_day_new';

$a = " recdate        | date                   | not null
 media_campaign | character varying(100) | not null
 media_creative | character varying(100) | not null
 ld_id          | integer                | not null
 bnadm_id       | integer                | not null
 game_id        | character varying(50)  | not null
 media_id       | character varying(50)  | not null
 regcount       | integer                | not null default 0
 actcount       | integer                | not null default 0
 clickcount     | integer                | not null default 0
 viewcount      | integer                | not null default 0
 enteruser_old  | integer                | not null default 0
 backuser1      | integer                | not null default 0
 backuser2      | integer                | not null default 0
 backuser3      | integer                | not null default 0
 backuser4      | integer                | not null default 0
 backuser5      | integer                | not null default 0
 backuser6      | integer                | not null default 0
 backuser7      | integer                | not null default 0
 backuser10     | integer                | not null default 0
 backuser15     | integer                | not null default 0
 backuser30     | integer                | not null default 0
 backuser45     | integer                | not null default 0
 backuser60     | integer                | not null default 0
 backuser90     | integer                | not null default 0
 backuser120    | integer                | not null default 0
 backuser150    | integer                | not null default 0
 backuser180    | integer                | not null default 0
 backuser360    | integer                | not null default 0
 paymoney1      | numeric(18,2)          | not null default 0.00
 paymoney2      | numeric(18,2)          | not null default 0.00
 paymoney3      | numeric(18,2)          | not null default 0.00
 paymoney4      | numeric(18,2)          | not null default 0.00
 paymoney5      | numeric(18,2)          | not null default 0.00
 paymoney6      | numeric(18,2)          | not null default 0.00
 paymoney7      | numeric(18,2)          | not null default 0.00
 paymoney10     | numeric(18,2)          | not null default 0.00
 paymoney15     | numeric(18,2)          | not null default 0.00
 paymoney30     | numeric(18,2)          | not null default 0.00
 paymoney45     | numeric(18,2)          | not null default 0.00
 paymoney60     | numeric(18,2)          | not null default 0.00
 paymoney90     | numeric(18,2)          | not null default 0.00
 paymoney120    | numeric(18,2)          | not null default 0.00
 paymoney150    | numeric(18,2)          | not null default 0.00
 paymoney180    | numeric(18,2)          | not null default 0.00
 paymoney360    | numeric(18,2)          | not null default 0.00
 payuser1       | integer                | not null default 0
 payuser2       | integer                | not null default 0
 payuser3       | integer                | not null default 0
 payuser4       | integer                | not null default 0
 payuser5       | integer                | not null default 0
 payuser6       | integer                | not null default 0
 payuser7       | integer                | not null default 0
 payuser10      | integer                | not null default 0
 payuser15      | integer                | not null default 0
 payuser30      | integer                | not null default 0
 payuser45      | integer                | not null default 0
 payuser60      | integer                | not null default 0
 payuser90      | integer                | not null default 0
 payuser120     | integer                | not null default 0
 payuser150     | integer                | not null default 0
 payuser180     | integer                | not null default 0
 payuser360     | integer                | not null default 0
 paymoney       | numeric(18,2)          | not null default 0.00
 payuser        | integer                | not null default 0
 cost           | numeric(18,2)          | not null default 0
 cost_r         | numeric(18,2)          | not null default 0";

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

$sql = "CREATE TABLE {$table} (
  {$sql}
)";

echo $sql;
