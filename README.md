# AzReco Text To Speech API PHP example
Example php script to help you integrate with our text-to-speech API.

This is an example php script for uploading text file and saving the audio into a .wav file.

# Supporting languages
AZERBAIJANI (az-AZ)

TURKISH  (tr-TR)

# Requirements

You will need to have the php-curl module installed.

sudo apt install php-curl

# Usage example:

php client.py --input-type file -t text/example-tr.txt -l tr-TR -i api_user_id -k api_token -o example-tr.wav  

or

php client.py --input-type text -t "any text" -l tr-TR -i api_user_id -k api_token -o example-tr.wav  

In this example for input type 'file' the script uploads 'example-tr.txt', synthesizes speech using our tr-TR text-to-speech and saves the resulting audio as 'example-tr.wav' when the synthesizing process finished. For input type 'text' the script sends text to the server, synthesizes speech using our tr-TR text-to-speech and saves the resulting audio as 'example-tr.wav' when the synthesizing process finished.


# How to get user id and token?

To get user id and API token, send a request to info@azreco.az.
To confirm your request, we will ask you some details about your purpose in using API.
