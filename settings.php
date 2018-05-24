<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/user.php";

$require_login=true;
include_once "login_check.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$page_title="Settings";
$page_ribbon="F";

include 'template/header.php';
?>

<?php
//$stmt = $user->getUser($_SESSION['userid']);
//$num  = $stmt->rowCount();
//$temp=0;
?>
<?php
if($_POST){ 
      if($_POST["action"] == "Load"){  
           $user->read();  
      }  

      if($_POST["action"] == "Insert"){  
           $user->nickname = $_POST['displayname'];
           $user->username = $_POST['username'];
           $user->role     = $_POST['role'];
           $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);

          if(!$user->userExists($_POST['username'])){
            if($user->addUser()){
                echo "<div class=\"row\"><div class=\"col-md-12\"><div class='alert alert-success'>";
                    echo "<h4>Success</h4>";
                echo "</div></div></div>";
            }
            else {
                echo "<div class=\"row\"><div class=\"col-md-12\"><div class='alert alert-danger'>";
                echo "<h4>Error adding user!</h4>";
                echo "</div></div></div>"; 
            }
          }
         else{
            echo "<div class=\"row\"><div class=\"col-md-12\"><div class='alert alert-danger'>";
                echo "<h4>Username already exist!</h4>";
            echo "</div></div></div>";  
         }
      }
}
else{
    echo 'what';
}
?>

<div class="container">
<div class="row">
    <div class="col-md-3 xd-pane-aside">
        <div class="thumbnail panel panel-default">
            <div class="caption">
            </div>
        </div>
    </div>

    <div class="col-md-9 xd-pane-content">
        <div class="row">
            <div class="col-sm-10">
                <h4>Manage Users</h4>
            </div>
            <div class="col-sm-2">
                <button type="button" id="btnadduser" class="btn btn-primary" data-toggle="modal" data-target="#userdialog">Add user</button>
            </div>
        </div>

        <table id="users" class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-xs-3">Name</th>
                    <th class="col-xs-3">Username</th>
                    <th class="col-xs-2">Role</th>
                    <th class="col-xs-2">Date Created</th>
                    <th class="col-xs-2">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php       
                    $stmt = $user->read();
                    $num  = $stmt->rowCount();
                    if($num>0){
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                            echo "<tr>";
                            echo "<td>{$nickname}</td>";
                            echo "<td>{$username}</td>";
                            echo "<td>{$role}</td>";
                            echo "<td>{$modified}</td>";
                            echo "<td><div class=\"btn-group\">";
                            echo "<a href=\"joborderitem.php?&amp;code=\" class=\"btn btn-xs btn-default\">Change Profile</a>";
                            ?>
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-option-vertical"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                            <?php
                                echo "<li><a href=\"#\" data-toggle=\"modal\" data-target=\"#passdialog\">Reset Password</a></li>";
                                echo "<li><a href=\"" . $home_url . "joborders.php?id=&amp;\">Delete</a></li>";
                            ?>
                                </ul>
                            <?php
                            echo "</div>";
                            //echo "<a href=\"#\" class=\"btn btn-xs btn-default\"></a><a href=\"#\" class=\"btn btn-xs btn-default\">Reset Password</a><a href=\"#\" class=\"btn btn-xs btn-default\"></a>";
                            echo "</td></tr>";
                        }
                    }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div id="ttt"></div>


<!-- Modal -->
<div class="modal fade" id="userdialog" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
      </div>
      <div class="modal-body">
      <form method="post" id="user_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label>Enter Name</label>
                <input type="text" name="displayname" id="displayname" class="form-control" />
            </div>
            <div class="form-group">
                <label>Select Role</label>
                <div>
                    <label class="radio-inline">
                    <input type="radio" name="role" value="user"> user
                    </label>
                    <label class="radio-inline">
                    <input type="radio" name="role" value="admin"> admin
                    </label>
                </div>
            </div>
            <div class="form-group">  
                <label>Enter Username</label>
                <input type="text" name="username" id="username" class="form-control" />
            </div>
            <div class="form-group">            
                <label>Enter Password</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="hidden" name="action" id="action" />
        <input type="hidden" name="user_id" id="user_id" />
        <input type="submit" name="action" id="button_action" class="btn btn-primary" value="Insert" />
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="passdialog" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
      </div>
      <div class="modal-body">
      <form method="post" id="pass_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">            
                <label>Enter Password</label>
                <input type="password" name="password" id="password" class="form-control" required />
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="hidden" name="action" id="action" />
        <input type="hidden" name="user_id" id="user_id" />
        <input type="submit" name="action" id="button_action" class="btn btn-primary" value="Change Password" />
      </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">  
    $(document).ready(function(){
        $('#btnadduser').click(function(){  
            $('#user_form')[0].reset();
            $('#action').val('insert');
            $('#button_action').val("Insert");  
        });

        $('#user_form').submit(function(){
        //$("#button_action").click(function(event){  
            alert("hi");
                var displayname = $('#displayname').val();  
                var username = $('#username').val();
                var password = $('#password').val();
                var post_url = $('#user_form').attr("action"); //get form action url
                var request_method = $('#user_form').attr("method");
                
                if(displayname != '' && username != '' && password != '')  
                {  
                    /*$.ajax({  
                          url: post_url,  
                          method: request_method,  
                          //data:new FormData(this),  
                          data: $("#user_form").serialize(),
                          /*success:function(data){  
                               $("#ttt").text($("#user_form").serialize());
                               $("#action").val("insert");  
                               $('#button_action').val("Insert");  
                          } 
                         
                          success: function(data) {
                                alert('ok');
                                $("#ttt").text($("#user_form").serialize());
                                echo json_encode($data)
                          }*/
                         // $.ajax({  
                           // url: 'objects/functions/fetch_user.php',

                        $.post('objects/functions/fetch_user.php',{username: $('#username').val()}, function(data){
                            if(data.exists){
                                $("#users").append("error");
                                //tell user that the username already exists
                            }else{
                                //username doesn't exist, do what you need to do
                            }
                        }, 'JSON');
                           

                     })

                     /*.done(function(response){
                        if(response.type == 'error'){ //load json data from server and output message    
                            output = '<div class="error">ERR'+response.text+'</div>';
                        }else{
                            output = '<div class="success">SCC'+response.text+'</div>';
                        }
                        $("#users").append(output);
                    });*/
                }  
                else{  
                     alert("All Fields are Required");  
                }
                event.preventDefault();   
           });  
    })
</script>
<?php include 'template/footer.php' ?>