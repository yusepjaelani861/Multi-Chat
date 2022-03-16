<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Actions;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    public function getUser(Request $request)
    {
        $url = 'https://api.telegram.org/bot5221009888:AAH4p2BfrvGvJXi4RiIfU39ACxc--knQfeA/getUpdates';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);

        $data = DB::table('customer')->get();
        if (count($data) == 0) {
            DB::table('customer')->insert([
                'user_id' => $result['result'][0]['my_chat_member']['from']['id'],
                'channel_id' => $result['result'][0]['my_chat_member']['chat']['id'],
                'first_name' => $result['result'][0]['my_chat_member']['from']['first_name'],
                'last_name' => $result['result'][0]['my_chat_member']['from']['last_name'],
                'username' => $result['result'][0]['my_chat_member']['from']['username'],
            ]);
        } if (count($data) > 0) {
            DB::table('customer')->where('user_id', $result['result'][0]['message']['from']['id'])->update([
                'user_id' => $result['result'][0]['my_chat_member']['from']['id'],
                'channel_id' => $result['result'][0]['my_chat_member']['chat']['id'],
                'first_name' => $result['result'][0]['my_chat_member']['from']['first_name'],
                'last_name' => $result['result'][0]['my_chat_member']['from']['last_name'],
                'username' => $result['result'][0]['my_chat_member']['from']['username'],
            ]);
        }
        return $result;
    }

    public function profile()
    {
        $data = DB::table('customer')->get();
        $name = $data[0]->first_name;
        $date = $data[0]->created_at;
        $chat_id = $data[0]->user_id;
        return view('chat', compact('name', 'date', 'chat_id'));
    }

    public function sendChat(Request $request)
    {
        $chat_id = '-1001750794288';  
        $telegram = new Api('5221009888:AAH4p2BfrvGvJXi4RiIfU39ACxc--knQfeA');
        $response = $telegram->sendMessage([
            'chat_id' => '-1001750794288',
            'text' => $request->text,
        ]);

        $text = $response->getMessageId();
        $store = DB::table('chat')->insert([
            'chat_id' => $chat_id,
            'text' => $request->text,
        ]);
        
        return $this->getAll();
    }




    public function store(Request $request)
    {
        dd($request->audio_data);
    }

    public function getChat()
    {
        $data = DB::table('chat')->get();
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $chat_id = $value->chat_id;
                $text = $value->text;
                return view('chat', ['chat_id' => $chat_id, 'text' => $text]);
            }
    
        } else {
            return view('chat');
        }

    }
    
    public function getAll()
    {
        $list = DB::table('chat')->get();
        
        foreach ($list as $key => $value) {
            $chat_id = $value->chat_id;
            $text = $value->text;
        }
        $db = DB::table('customer')->where('channel_id', $chat_id)->get();


        

        return view('list', ['list' => $list, 'db' => $db]);
    }

}
