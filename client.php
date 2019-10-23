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
            $file_path = realpath($opts);
            $params['file'] = new cURLFile($file_path);
            curl_setopt($ch, CURLOPT_URL, $this->api_url_file);
        } elseif($this->input_type == "text") {
            $params["text"] = $opts;
            curl_setopt($ch, CURLOPT_URL, $this->api_url_text);
        } else {
            throw new Exception("Type of input. Must be one of 'text' or 'file'.");
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $data = curl_exec($ch);

        if (!curl_errno($ch)) {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code == 200) {
                file_put_contents($this->output, $data);
                echo "File saved! \n";
            } else {
                echo $data . "\n";
                echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
        }
        curl_close($ch);
    }
}

$opts = "t:l:i:k:o:";
$longopts  = array("input-type:",);
$options = getopt($opts, $longopts);

$synth = new Synthesizer($options['input-type'],$options['i'], $options['k'], $options['l'], $options['o']);
$synth->synthesize($options['t']);

?>
