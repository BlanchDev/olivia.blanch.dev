<!DOCTYPE html>
<html lang="en">
<head>
  <?php require($_SERVER["DOCUMENT_ROOT"]."/head.php"); ?>

  <title>Meet Olivia</title>
</head>
<body>

  <style type="text/css" media="screen">

    body{
      display: flex;
      flex-direction: column;
    }

    .mainflexbox{
      padding: 150px 0px;
      text-align: center;
      gap: 70px;
    }

    h2{
      background: linear-gradient(to right, mediumaquamarine, aquamarine, yellowgreen);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    h3{
      background: linear-gradient(to right,greenyellow, aqua);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .loginBtn{

      font-size: 2rem;
      padding: 20px;
      border-radius: 10px;
      background: linear-gradient(115deg, rgba(0,255,207,0.20350146894695376) 0%, rgba(13,62,45,0.7357143541010154) 12%, rgba(24,6,107,0.6712885837928921) 95%);  
      gap: 10px;

      transition: all 0.5s ease;
    }

    .loginBtn:hover{

     filter: brightness(0.7);

     transition: all 0.5s ease;
   }

   .try{
    background: linear-gradient(to right, #ff00cc, slateblue, aqua);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .oliviaMsg{
    background: rgba(35, 155, 85, 0.1);
    padding: 20px 20px;
    border-radius: 2px 10px 20px 2px;
    border-left: 5px solid #43bd84;
    width: calc(100% - 3px);
    gap: 15px;
  }
  .msgDetails{
    width: 100%;
    gap: 7px;
    text-align: left;
  }

  .msgDetails .Name {
    font-size: 1.6rem;
    font-weight: 700;
    color: #00ff8c;
  }

  .msgDetails .Msg {
    font-size: 1.5rem;
    font-weight: 500;
    color: whitesmoke;
    width: 100%;
    white-space: pre-wrap;


    background: linear-gradient(140deg, snow, mediumslateblue, mediumaquamarine,greenyellow);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
</style>

<div class="mainflexbox column aic">

  <div class="oliviaMsg row">

    <img style="width: 100px; height:100px; border-radius: 50%;" src="/resources/photos/olivia.jpg" alt="Olivia's Photo">

    <div class="msgDetails column">
      <div class="Name">Olivia</div>
      <div class="Msg">Hello! I'm Olivia. I'm looking forward to talking to you.</div>
    </div>
  </div>


  <div class="pageTitles column aic" style="gap: 25px;">


    <h2 style="font-size: 1.7rem; color: mediumaquamarine;" >GPT 3.5 Turbo API Layout</h2>

    <h3 style="font-size: 1.5rem; color: aquamarine;" >Do you want try?</h3>

  </div>


  <a class="loginBtn row aic" href="/chat" title="Talk with Olivia"><span class="try" style="font-weight: 600; color: aqua;">Try <i class="fa-solid fa-right-to-bracket fa-shake"></i></span> now!</a>


</div>

</body>
</html>