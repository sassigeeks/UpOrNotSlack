# UpOrNotSlack

UpOrNot is a simple Slash command for slack that allows a team to check whether or not a URL is online by using the a custom slash command such as the following:

`/upornot myfunkydomain.com`

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
