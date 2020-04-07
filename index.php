<?php
if(!isset($_REQUEST)) exit();
require_once $_SERVER["DOCUMENT_ROOT"].'/config.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/models/bot.php';

class Callback
{
    public function __construct()
    {
        $event = $this->get_event();
        // Время выполнения скрипта в секундах
        //set_time_limit(2);

        try
        {
            switch($event['type'])
            {
                case "confirmation":
                    $this->handle_confirmation();
                break; 
                case "message_new":
                    $bot = new BotVk\Message_new($event);
                break;
                default:
                    $this->ok_response();
                break;
            }
        } 
        catch (Exception $ex)
        {
            log_error($ex);
        }
    }

    # Подтверждение сайта
    private function handle_confirmation()
    {
        $this->response(CALLBACK_API_CONFRIM_TOKEN);
    }

    # Вывод сообщения на экран
    private function response($value)
    {
        echo $value;
        exit();
    }

    # Ловим отправленный json файл
    private function get_event()
    {
        $json = '{"type":"message_new","object":{"message":{"date":1586054794,"from_id":228970688,"id":135,"out":0,"peer_id":228970688,"text":"ПриВеТ","conversation_message_id":127,"fwd_messages":[],"important":false,"random_id":0,"attachments":[],"is_hidden":false},"client_info":{"button_actions":["text","vkpay","open_app","location","open_link"],"keyboard":true,"inline_keyboard":true,"lang_id":0}},"group_id":193668024,"event_id":"b0c936fa537622981a096bd5e38a252e7cac0d20"}';
        return json_decode($json, true);
        #return json_decode(file_get_contents('php://input'), true);
    }
}
$callback = new Callback();
?>