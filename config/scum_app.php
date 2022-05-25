<?php

return [

    'scum_discord_kill_wh_url' => getenv('DISCORD_WEB_HOOK_KILL_LOG_URL'), //SCUMDiscord用ウェブフックURL（キル用）

    'scum_discord_trap_wh_url' => getenv('DISCORD_WEB_HOOK_TRAP_LOG_URL'), //SCUMDiscord用ウェブフックURL（トラップ用）

    'scum_discord_server_status_wh_url' => getenv('DISCORD_WEB_HOOK_SERVER_STATUS_URL'), //SCUMDiscord用ウェブフックURL（サーバー用）

    'battlemetrics_server_id' => getenv('BATTLEMETRICS_SERVER_ID'), //battlemetricsのscumサーバーID（サーバー用）

    'weapon' => [

    ]
];
