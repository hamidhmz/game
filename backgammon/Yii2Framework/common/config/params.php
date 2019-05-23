<?php
return [
    // Users
    'users.defaultPassword' => '123456',
    'users.defaultAvatar' => 'default.png',
    'users.passwordResetTokenExpire' => 60 * 60,
    'users.rememberMeExpire' => 60 * 60 * 24 * 30,

    'users.statusActive' => 1,
    'users.statusInActive' => 2,
    'users.statusDelete' => 3,

    'users.groupAdministrator' => 1,
    'users.groupAdmin' => 2,
    'users.groupDeputy' => 3,
    'users.groupUser' => 4,
    
    'ligs.playersCount' => [4 => 4 ,8 => 8, 16 => 16],
    'ligs.statusWaitingForPlayer' => 1,
    'ligs.statusWaitingForStart' => 2,
    'ligs.statusPlaying' => 3,
    'ligs.statusFinish' => 4,
    
    'games.statusWaiting' => 1,
    'games.statusPendding' => 1,
    'games.statusPlaying' => 2,
    'games.statusFinish' => 3,
    'games.statusCanceled' => 4,
];