<?php
/* Main */
$Route->new('/', ['\Functions\Home', 'index']);
$Route->new('/login', ['\Functions\Login', 'index']);
$Route->new('/logout', ['\Functions\Logout', 'index']);
$Route->new('/users', ['\Functions\Users', 'index']);
$Route->new('/newusers', ['\Functions\NewUsers', 'index']);
$Route->new('/server', ['\Functions\Server', 'index']);
$Route->new('/allservers', ['\Functions\AllServers', 'index']);
$Route->new('/create', ['\Functions\Create', 'index']);
$Route->new('/autodj', ['\Functions\Autodj', 'index']);
$Route->new('/music', ['\Functions\Music', 'index']);
$Route->new('/upload', ['\Functions\Upload', 'index']);
$Route->new('/playlist', ['\Functions\Playlist', 'index']);
$Route->new('/settings', ['\Functions\Settings', 'index']);
$Route->new('/dj', ['\Functions\dj', 'index']);
$Route->new('/ticket', ['\Functions\Ticket', 'index']);
$Route->new('/account', ['\Functions\Account', 'index']);