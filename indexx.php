<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        

        <style>
          h1{
            padding-left:170px;
          }

          .button{
            padding-left:200px;
          }
          </style>
</head>
<body>
  <div class="container col-lg-6">
<?php
if(isset($_GET['flag'])){
  if($_GET['flag']==1){
    ?>

    <div class="alert alert-primary" role="alert">
 You have successfully completed your process.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

    <?php
  }
  if($_GET['flag']==0){
    ?>

    <div class="alert alert-danger" role="alert">
 ERROR!!.....Message not sent.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

    <?php
  }
 
}



?>
<div class="card mb-4">
<div class="card-header"><strong>Send</strong><span class="small ms-1">Mail</span></div>
            <div class="card-body">
<form action="mail.php" method="get">

        <div class="text mb-3 ms-2">
        <h1>Send E-mail</h1>
        </div>


        <div class="mb-3 ">
  <label for="email" class="form-label">Email</label>
  <input type="email" class="form-control" name="email" id="email">
</div>

<div class="mb-3 ">
  <label for="cc" class="form-label">cc</label>
  <input type="email" class="form-control" name="cc" id="cc">
</div>

<div class="mb-3 ">
  <label for="cc1" class="form-label">cc1</label>
  <input type="email" class="form-control" name="cc1"   id="cc1">
</div>

<div class="mb-3 ">
  <label for="cc2" class="form-label">cc2</label>
  <input type="email" class="form-control" name="cc2"  id="cc2">
</div>

<div class="mb-3 ">
  <label for="bcc" class="form-label">bcc</label>
  <input type="email" class="form-control" name="bcc"  id="bcc">
</div>

<div class="mb-3 ">
  <label for="bcc1" class="form-label">bcc1</label>
  <input type="email" class="form-control" name="bcc1"  id="bcc1">
</div>

<div class="mb-3 ">
  <label for="bcc2" class="form-label">bcc2</label>
  <input type="email" class="form-control" name="bcc2"  id="bcc2">
</div>

<div class="mb-3 ">
  <label for="subject" class="form-label">Subject</label>
  <input type="text" class="form-control" name="subject" id="subject">
</div>

<div class="mb-3 ">
  <label for="message" class="form-label">Message</label>
  <input type="text" class="form-control" name="message" id="message">
</div>

<div class="button ms-5">
<button type="submit" class="btn btn-primary" href="mail.php">Send Mail</button>
</div>

        </form>
        </div>
</div>
</div>
</div>



        <script src="C:\xampp\htdocs\demo\site\jquery-3.6.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </body>
</html>
