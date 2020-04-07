<?php
namespace BotVk
{
    require_once $_SERVER["DOCUMENT_ROOT"].'/models/api/vk/api.php';
    use VKAPI\Message_new as msg_new_vk_api;

    class Message_new
    {
        public function __construct(array $event = array())
        {
            $vk_api = new msg_new_vk_api();
            $message_object = $vk_api->get_dedicated_array_message($event);
            $user_id = $vk_api->get_user_id($message_object);
            $message = $this->get_answer_bot($vk_api->get_user_message($message_object));
            $attachments = array();
            $vk_api->message_send($user_id, random_int(1, PHP_INT_MAX), $message, $attachments);
        }

        private function get_answer_bot(string $text)
        {
            switch(mb_strtolower($text, 'UTF-8'))
            {
                case "привет":
                    return "Доброго времени суток!";
                break;
                case "старт":
                    return "Доброго времени суток, я немного глупый и только умею отвечать на сообщение 'привет'";
                default:
                    return "К сожалею я погу ответить только на 'привет' и 'старт'. Но мой повелитель обучает менея, думаю, что скоро буду гораздо умнее";
            }
        }
    }
}
?>