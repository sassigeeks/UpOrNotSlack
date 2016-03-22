<?php

/*

Requirements for UpOrNot Slash Command for slack

* Create a custom slash command for your slack team. 
* A slack account - Free account will suffice. 
* A server running PHP with curl enabled. Most shared hosting companies will have
  this enabled by default so you don't need to do anything.  

  
* Upload this script on your server running PHP5 with cURL.
* Set up a new custom slash command on your Slack team: 
  http://my.slack.com/services/new/slash-commands
* Under "Choose a command", enter the natcasesort you want for 
  the command. /UpOrNot is easy to remember.
* For "URL", enter the URL for the script on your server.
* Leave "Method" set to "Post".
* Choose whether you want this command to show in the 
  autocomplete list for slash commands.
* If you do decide to enable autocomplete, enter a short description and usage hint.
*/


# isitup.org doesn't need you to use API keys, but they do require that any automated script send in a user agent string.
# You can keep this one, or update it to something that makes more sense for you
$user_agent = "UpOrNotSlack/1.1 (https://github.com/sassigeeks/UpOrNotSlack; jus@envyserve.com)";

# Grab some of the values from the slash command, create vars for post back to Slack
$command = $_POST['command'];
$domain = $_POST['text'];
$token = $_POST['token'];

# Check the token and make sure the request is from our team 
if($token != 'REvSI9FmGtTudKyZUJKgs3nl'){ # replace this with the token from your slash command configuration page
    $msg = "The token for the slash command doesn't match. Check your script.";
    die($msg);
    echo $msg;
}
# This script utilizes the isitup service at isitup.org
$url_to_check = "https://isitup.org/".$domain.".json";

# Setup cURL
$ch = curl_init($url_to_check);

# Set up options for cURL 
# We want to get the value back from our query 
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
# Send in our user agent string 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

# Make the call and get the response
$ch_response = curl_exec($ch);

# Close connection.
curl_close($ch);

# Decode the JSON array sent back by isitup.org
$response_array = json_decode($ch_response, TRUE);

# Build our response 
# Note that we're using the text equivalent for an emoji at the start of each of the responses.
# You can use any emoji that is available to your Slack team, including the custom ones.
if($ch_response === FALSE){
  # isitup.org could not be reached 
  $reply = "Ironically, isitup could not be reached.";
}else{
  if($response_array["status_code"] == 1){
  	# Yay, the domain is up! 
    $reply = ":thumbsup: I am very happy to report that *<http://".$response_array["domain"]."|".$response_array["domain"].">* is *up*!";
  } else if($response_array["status_code"] == 2){
    # Boo, the domain is down. 
    $reply = ":disappointed: I am very sorry to report that *<http://".$response_array["domain"]."|".$response_array["domain"].">* is *not up*!";
  } else if($response_array["status_code"] == 3){
    # Uh oh, isitup.org doesn't think the domain entered by the user is valid
    $reply = ":interrobang: *".$text."* does not appear to be a valid domain. \n";
    $reply .= "Please enter both the domain name AND suffix (example: *envyserve.com* or *google.com*).";
  }
}

# Send the reply back to the user. 
echo $reply;


 ?>
 
 