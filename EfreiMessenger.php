<html>
  <head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta charset="utf-8">
    <title>S4 Efrei Messenger !</title> 
  </head>
  <header class = "header">
    <div class = content>
      <img src="/images/LogoEM.png" width = 85px class = "logo">
      <nav>
        <ul>
          <li><a href = "index.php">
            Go Back
          </a></li>
          <li>  
            <form action="EfreiMessenger.php" method="POST">
              <input type = "submit" name = "ApplyBtn" value = "Apply">
              <?php 
                include('form.php');
              ?>
          </form>
          </li>
          <li>
            <form action="EfreiMessenger.php" method="POST">
              <input type = "submit" name = "LeaveBtn" value = "Leave">
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <body class = "bodyEM">
    <div>
      <FONT size="5">
      <p>Efrei Messenger is a free app that combines the voice chat aspects of services like Skype and Teamspeak with the text chat aspects 
        of Internet Relay Chat and various instant messaging services like messenger. </p>
      <img src="/images/EMEx.jpg" class ="center">
    </div>
      <div>
      <h2><b>Task</b></h2>
      <p>Your task is to implement a simple team messenger application.</p>
      <p><b>How we imagine the application ?</b></p>
      <p>1. User enters the main page of our messenger application and he gives his nickname. </p>
      <p>2. After this, the user can see a list of active channels with the number of members already chatting in the given channel.</p>  
      <p> For instance:</p> 
      <p class = "textCenter">Channel 1 (5 members)</p> 
      <p class = "textCenter">Channel 2 (2 members)</p> 
      <p class = "textCenter">Happy channel! (7 members)</p>  

      <p>3. User can enter one of the channels or he can create his own channel after providing the channel name.</p>
      <p>4. After joining the specific channel the user should see a list of channel members and the history of the channel discussion, similar to the TeamSpeak app.</p>
      <p>5. User can join the discussion or leave the channel.</p>
      <p>6. Then he can join another channel or create new one.</p>
      <p>7. The logic of the application is controlled by server. All chats and channels are stored in the database. </p>
      <p>8. In the most simple version of the application users need to refresh the page to see new messages and members in the channel.</p>
      <p>9. In more advanced game version you should use REST services with Vue.js on the frontend.</p>
    </div>
    </FONT>       
  </body>
</html>