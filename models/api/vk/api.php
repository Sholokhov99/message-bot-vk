<?php
namespace VKAPI
{
    require_once $_SERVER["DOCUMENT_ROOT"].'/models/api/vk/config.php';
    class Message_new
    {
        # Получение id пользователя
        public function get_user_id(array $object)
        {
            return $object["from_id"];
        }

        # Получение сообщения отправленное пользователем
        public function get_user_message(array $object)
        {
            return $object["text"];
        }

        # Получение информации о сообщении 
        public function get_dedicated_array_message(array $object)
        {
            return $object["object"]["message"];
        }

        # Формирование запроса на отправку сообщения
        public function message_send(string $user_id, int $random_id, string $message, array $attachments = array())
        {
            return $this->call('messages.send', array(
                'user_id' => $user_id,
                'message' => $message,
                'random_id' => $random_id,
                'attachments' => $attachments,
            ));
        }

        # Подтверждение выполнения операции
        private function ok_response()
        {
            header("HTTP/1.1 200 OK");
            echo 'ok';
            ignore_user_abort(false);
        }

        # Отправка запроса серверу vk
        private function call(string $method, array $params = array())
        {
            $params['access_token'] = CALLBACK_VK_API_TOKEN;
            $params['v'] = VK_API_VERSION;

            $query = http_build_query($params);
            $url = VK_API_URLMETHOD.$method.'?'.$query;
            
            file_get_contents($url);

            $this->ok_response();
        }
    }
}
?>