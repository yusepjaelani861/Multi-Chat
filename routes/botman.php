<?php
$botman->hears('test', function($bot){
    $bot->reply('hello!');
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');