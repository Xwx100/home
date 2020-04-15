<?php

return [
    'frame' => [
        'laravel' => [
            'url' => 'laravel.com/',
            'ab'  => [
                '-n' => 100,
                '-c' => 10
            ],
            'loop_times' => 2
        ],
        'tp6'     => [
            'url' => 'tp6.test.com/',
            'ab'  => [
                '-n' => 100,
                '-c' => 10
            ],
            'loop_times' => 5
        ]
    ],
    // ab信息 归类
    'info_group' => [
//        [
//            'preg_match' => 'ApacheBench.*Version',
//            'en' => 'ab_info',
//            'zh' => 'ab 工具信息',
//        ],
//        [
//            'preg_match' => 'Benchmarking',
//            'en' => 'request_url',
//            'zh' => '请求地址'
//        ],
//        [
//            'preg_match' => 'Server Software',
//            'en' => 'server_info',
//            'zh' => '服务器信息'
//        ],
        [
            'preg_match' => 'Document Path',
            'en' => 'document_info',
            'zh' => '文档信息'
        ],
        [
            'preg_match' => 'Concurrency Level',
            'en' => 'ab_stats',
            'zh' => 'ab 基本统计信息'
        ],
//        [
//            'preg_match' => 'Connection Times \(ms\)',
//            'en' => 'ab_stats_ct',
//            'zh' => '[Time per request] 细分和统计'
//        ],
//        [
//            'preg_match' => 'Percentage of the requests',
//            'en' => 'ab_stats_ct_per',
//            'zh' => '[Time per request] 分布情况'
//        ]
    ],
    // ab信息归类 模式
    'info_group_m' => 're',
];
