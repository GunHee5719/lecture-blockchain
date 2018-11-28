
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="member.css">
</head>
<body>

<div class="content">
    <form name="Teacher_login" action="login_t.php" method="post">
      <div class="div_table" align="center">
          <table id="login_table" class="table table-sm">
              <h4 align="center" style="padding-bottom: 2%">Log-in</h4>
              <tr align="center">
                  <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID
                      <input type="text" name="id" id="login_id" class="form-control-sm"> </td>
              </tr>
              <tr align="center">
                  <td> Password <input type="password" name="password" id="login_password" class="form-control-sm"></td>
              </tr>
          </table>
      </div>
      <div class="div_button" align="center">
          <input type="hidden" id="metamask" name="metamask" value="">
          <input type="submit" value="Sign-in" class="btn btn-dark" onclick="location.href='../MainPage.php'" >
      </div>
    </form>
</div>

<script src='https://cdn.jsdelivr.net/gh/ethereum/web3.js/dist/web3.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script type="text/javascript" src="../TokenWeb3.js"></script>
<script type="text/javascript">
$(window).on("load",function(){
  getUserAccountLogin();
});
</script>
</body>
</html>
