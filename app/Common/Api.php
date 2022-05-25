<?php

namespace App\Common;

use Illuminate\Support\Facades\Log;

class Api
{
    private Methods $api;

    public function __construct(Methods $methods)
    {
        $this->api = $methods;
    }

    public function sendKillWebHook(array $data): void
    {
        //トラップログ用
        if ($data['killer_latitude'] == 0 && $data['killer_longitude'] == 0){
            $discordUrl = config('scum_app.scum_discord_trap_wh_url');
            $postData = [
                'username' => 'SCUM 日本サーバー（非公式）TRAP_LOG_BOT βテスト中',
                'avatar_url' => 'https://oceanofgamesu.com/wp-content/uploads/2021/01/scum-1-640x330.jpg',
                'content' => 'トラップ通知',
                'embeds' => [
                    [
                        'title' => 'TRAP LOG',
                        'description' => ':japanese_ogre:KILLER：' . $data['killer_name'] . "\n\n" . ':skull:DEATH：' . $data['victim_name'],
                        'timestamp' => now(),
                        'color' => 15158332,
                        'author' => [
                            'name' => 'TRAP',
                        ],
                        'fields' => [
                            [
                                'name' => '使用トラップ',
                                'value' => $data['weapon'] ?? 'unknown',
                                'inline' => true,
                            ],
                            [
                                'name' => '位置',
                                'value' => '設定中', //todo
                                'inline' => true,
                            ]
                        ]
                    ]
                ]
            ];
        }else {
            $discordUrl = config('scum_app.scum_discord_kill_wh_url');
            $postData = [
                'username' => 'SCUM 日本サーバー（非公式）KILL_LOG_BOT βテスト中',
                'avatar_url' => 'https://oceanofgamesu.com/wp-content/uploads/2021/01/scum-1-640x330.jpg',
                'content' => 'キル通知',
                'embeds' => [
                    [
                        'title' => 'KILL LOG',
                        'description' => ':japanese_ogre:KILLER：' . $data['killer_name'] . "\n\n" . ':skull:DEATH：' . $data['victim_name'],
                        'timestamp' => now(),
                        'color' => 15158332,
                        'author' => [
                            'name' => 'KILL',
                        ],
                        'fields' => [
                            [
                                'name' => '使用武器',
                                'value' => $data['weapon'] ?? 'unknown',
                                'inline' => true,
                            ],
                            [
                                'name' => '距離',
                                'value' => '設定中', //todo
                                'inline' => true,
                            ]
                        ]
                    ]
                ]
            ];
        }

        $response = $this->api->post($discordUrl, $postData);

        if ($response['status'] >= 400) {
            Log::error('API POST送信：sendKillWebHookの実行が失敗しました。');
        }
        Log::debug('API POST送信：sendKillWebHookの実行が成功しました');
    }

    public function sendServerStatusWebHook(): void
    {
        $response = $this->api->get('https://api.battlemetrics.com/servers/' . config('scum_app.battlemetrics_server_id'), []); //battlemetricsからサーバー情報の取得

        if ($response['status'] >= 400) {
            Log::error('API POST送信：sendServerStatusWebHookの実行が失敗しました。');
        }else {
            $result = json_decode($response['result'], true);

            $serverStatus = [
                'online' => 'ONLINE',
                'offline' => 'OFFLINE',
            ];

            $statusColor = [
                'online' => 65280,
                'offline' => 15158332,
            ];

            $postData = [
                'username' => 'SCUM 日本サーバー（非公式）SERVER_STATUS_BOT',
                'avatar_url' => 'https://oceanofgamesu.com/wp-content/uploads/2021/01/scum-1-640x330.jpg',
                'content' => 'Server Status',
                'embeds' => [
                    [
                        'title' => 'SERVER_STATUS',
                        'description' => 'Online Player：' . $result['data']['attributes']['players'] . ' / ' . $result['data']['attributes']['maxPlayers'] . "\n\n" . 'Server Status：' . $serverStatus[$result['data']['attributes']['status']],
                        'timestamp' => now(),
                        'color' => $statusColor[$result['data']['attributes']['status']],
                    ]
                ]
            ];

            $response = $this->api->post(config('scum_app.scum_discord_server_status_wh_url'), $postData);

            if ($response['status'] >= 400) {
                Log::error('API POST送信：sendServerStatusWebHookの実行が失敗しました。');
            }
            Log::debug('API POST送信：sendServerStatusWebHookの実行が成功しました');
        }
    }
}
