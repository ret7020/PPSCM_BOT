<?php
    function send_message($token, $message_text, $conversation_id){
            $data = array("message_text" => $message_text);
            $result_message = http_build_query($data);
            $ch = curl_init("https://pysoc.ru/v2api.php?token=" . $token . "&method=send_message&conv_id=" .$conversation_id. "&" . $result_message);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $returned_from_server = curl_exec($ch);
            curl_close($ch);
            return $returned_from_server;
    }
    function exec_api_command($token, $method_name, $params)
    {
            // Example of parameters to this function <<<  $data = array("message_text" => $message_text);
            $compiled_params = http_build_query($params);
            $ch = curl_init("https://pysoc.ru/v2api.php?token=" . $token . "&method=" .$method_name. "&" . $compiled_params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $returned_from_server = curl_exec($ch);
            curl_close($ch);
            return $returned_from_server;
    }
     $conv_id = $_GET['conversation_id'];
     $message = explode(" ", $_GET['message_text']);
     $message_text = $message[0];
     $message_argvs = $message[1];
     $token = "Your Bot API Token(Get in control panel)";
     switch ($message_text)
     {
            case "/инфа":
                  $get_conv_data = exec_api_command($token, "get_conv_data", array("conv_id" => $conv_id));
                  $get_conv_data = json_decode($get_conv_data, true);
                  send_message($token, "Информация о беседе, " . $get_conv_data['content']['name'] . "\n &#128104Количество участников: <b>" . $get_conv_data['content']['members_count'] . "</b>\n&#128347Дата создания: " . $get_conv_data['content']['date_created'] . "\n 	&#128172 Количество сообщений: " . $get_conv_data['content']['messages_count'] , $conv_id);
                  break;
            case "/кик":
                  send_message($token, "Вы хотите кикнуть человека", $conv_id); //Unfinished, this is placeholder only
                  break;
            case "/помощь":
                  send_message($token, "Справка по командам бота:\n/инфа - Информация о беседе\n/кик кого_кикать - Удалить человека из беседы(только админам)", $conv_id);
                  break;
            case "/админы":
                  send_message($token, "&#128081 Админы беседы:\nСтепан C PyPro", $conv_id); //Unfinished API method
                  break;
            case "/я":
                  send_message($token, "Ваш ID в PPS - <b>" . $_GET['user_id'] . "</b>", $conv_id); 
                  break;
            case "/участники":
                  send_message($token, "Участники этой беседы:\n" . $_GET['user_id'] . "</b>", $conv_id); //Unfinished, this is placeholder only
                  break;
      }
     
?>
