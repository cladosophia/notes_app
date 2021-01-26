<?php
session_start();
if(isset($_SESSION['user_id'])){
// echo '<pre>';
// var_dump($notes);
// echo '</pre>';
?>

<!DOCTYPE html>
<html>
<head>
	<title>My Notes</title>
 <link rel="icon" href="img/i.png">
	
  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- jQuery and JS bundle w/ Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">

	<script type="text/javascript" src="js/script.js"></script>	

</head> 		  
<body>
                <!-- START OF NAVBAR! -->
<header class="pageheader">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-nav ml-left">
      <h4 class="float-left text-white"><?php echo ' Welcome, ' . $_SESSION['firstname'] ?> <?php echo  $_SESSION['lastname'] ?> </h4>
    </div>
    <div class="float-right">
    <button onclick="window.location = 'php/Logout.php?logout'" class="btn btn-danger" id="btn_signout" type="button">Log Out</button>
    </div>
  </nav>
</header> 
                <!-- END OF NAVBAR! -->  
  	<h1 class="heading">MY NOTES</h1>
  	<div class="container">
  		<div class="row">
  			<button class="btn btn-primary col-1 offset-10 " data-toggle="modal" data-target="#addNoteModal">
  				<i class="fa fa-plus"></i>
  			</button>
  		</div>
      <div class="notes">
        <ul class="notes_list">
        </ul>
      </div>

  	</div>





<!-- MODALS -->
<div class="modal fade" id="addNoteModal" tabindex="-1" role="dialog" aria-labelledby="addNoteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNoteModalLabel">New Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="note-title" class="col-form-label">Title:</label>
            <input type="text" class="form-control" id="note-title">
          </div>
          <div class="form-group">
            <label for="note-description" class="col-form-label">Description:</label>
            <textarea class="form-control" id="note-description"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_note">Save Note</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="editNoteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="edit_note-title" class="col-form-label">Title:</label>
            <input type="text" class="form-control" id="edit_note-title">
          </div>
          <div class="form-group">
            <label for="edit_note-description" class="col-form-label">Description:</label>
            <textarea class="form-control" id="edit_note-description"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit_note">Save Changes</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                </div>
            
                <div class="modal-body">
                    <p>Are you sure you want to delete this note?</p>
                    <p class="debug-url"></p>
                    <input type="text" class="form-control" id="note_id" hidden="true">
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok" type="button" id="confirm_delete">Yes</a>
                </div>
            </div>
        </div>
</div>

<div class="modal fade" id="confirm-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Confirm Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                </div>
            
                <div class="modal-body">
                    <p>Do you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel_edit">Cancel</button>
                    <a class="btn btn-primary btn-ok" type="button" id="confirm_edit">Confirm</a>
                </div>
            </div>
        </div>
</div>
<!-- MODALS -->
</body>

</html>

<?php
}
else
{
    header("location:html/login.php");
    var_dump($_SESSION['user_id']);
}

?>