<?php
class Synthesizer {

    function __construct($input_type, $api_id, $api_token, $lang, $output,
                            $api_url_file='http://api.azreco.az/synthesize',
                                $api_url_text='http://api.azreco.az/synthesize/text') {
        $this->input_type = $input_type;
        $this->api_id = $api_id;
        $this->api_token = $api_token;
        $this->lang = $lang;
        $this->api_url_file = $api_url_file;
        $this->api_url_text = $api_url_text;
        $this->output = $output;
    }

    function synthesize($opts) {
        $params = array(
            "api_id" => $this->api_id,
            "api_token" => $this->api_token,
            "lang" => $this->lang,
        );

        $ch = curl_init();

        if($this->input_type == "file") {
            $files = '@' . realpath($opts);
            $data_string = http_build_query(array($params, $files));
            curl_setopt($ch, CURLOPT_URL, $this->api_url_file);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: multipart/form-data'));
        } elseif($this->input_type == "text") {
            $params["text"] = $opts;
            $data_string = http_build_query($params);
            curl_setopt($ch, CURLOPT_URL, $this->api_url_text);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/x-www-form-urlencoded'));
        } else {
            throw new Exception("Type of input. Must be one of 'text' or 'file'.");
        }

        echo $data_string . "\n";
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        $data = curl_exec($ch);

        if (!curl_errno($ch)) {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code == 200) {
                file_put_contents($this->output, $data);
                echo "File saved! \n";
            } else {
                echo $data;
                echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
        }
        curl_close($ch);
    }
}

$opts  = "";
$opts .= "t:";
$opts .= "l:";
$opts .= "i:";
$opts .= "k:";
$opts .= "o:";
$longopts  = array("input-type:",);
$options = getopt($opts, $longopts);

$data = new Synthesizer($options['input-type'],$options['i'], $options['k'], $options['l'], $options['o']);
$data->synthesize($options['t']);

?>
