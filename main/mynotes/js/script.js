$(function(){

var user = 8;

	var Note = {
		add: function(name,description){
			var new_note = {
				name : name,
				description : description
			};
			$.ajax({
				type : "POST",
				data : { data: new_note, action : 'add_note'},
				url : 'php/Note.php',
				success : function(data){
					Note.get(user);
					$("#addNoteModal").modal("hide");
					$("#note-title").val("");
					$("#note-description").val("");
				}
			});

		},
		get: function(user_id,created_at,updated_at){
			$.ajax({
				type : "POST",
				data : { user_id: user_id, created_at: created_at,updated_at: updated_at, action : 'get_notes'},
				url : 'php/Note.php',
				success : function(data){
					Note.list = jQuery.parseJSON(data);
					//console.log(data);
					$(".notes_list").empty();
					$.each(Note.list, function(index, value){
							let new_date = value.created_at;
								if(value.updated_at != "0000-00-00 00:00:00"){
									new_date = value.updated_at;
									//console.log("create at: ",new_date);
								}
									$(".notes_list").append("<li class=\"note\"><div class=\"card\">"
							           +"<div class=\"card-header\">"+value.title
							           +"<div class=\"pull-right\">"
							           +"<p>"+new_date+"</p></div></div>"
							           +"<div class=\"card-body clearfix\">"
							           +"<p class=\"card-text\">"+value.description+"</p>"
							           +"<button data-note_id=\""+value.id+"\" class=\"pull-right btn btn-primary m-1 edit_note\"><i class=\"fa fa-edit\"></i></button>"
							           +"<button data-note_id=\""+value.id+"\" class=\"pull-right btn btn-danger m-1 delete_note\"><i class=\"fa fa-trash\"></i></button>"
							           +"</div></div></li>");
					});
				}
			})

		},
		delete: function(note_id){
			$('#confirm-delete').modal('show');
			$("#note_id").val(note_id);
	
		},

		confirm_delete: function(note_id){
			$.ajax({
				type:"POST",
				data: {id:note_id,action:'delete_note'},
				url: 'php/Note.php',
				success:function(data){
					Note.get(user);
				}
			});
			$('#confirm-delete').modal('hide');

		},

		edit_trigger: function(to_edit){
			$("#editNoteModal").modal("show");
			$("#edit_note-title").val(to_edit.title);
			$("#edit_note-description").val(to_edit.description);
		},
		save_changes: function(){
			$("#editNoteModal").modal("hide");
			$("#confirm-edit").modal("show");
		},

		confirm_changes: function(){
				let edited_note	= {
					id: Note.currently_editing,
					title: $("#edit_note-title").val(),
					description: $("#edit_note-description").val(),
				};
				//console.log(edited_note);
				$.ajax({
					type:"POST",
					data: {data:edited_note,action:'edit_note'},
					url: 'php/Note.php',
					success:function(data){
						Note.get(user);
						$("#editNoteModal").modal("hide");
						$("#confirm-edit").modal("hide");
					}
				})

			
		}
	};

	Note.get(user); 

	$("#save_note").click(function(){
		Note.add( $("#note-title").val(), $("#note-description").val());
	});

	$("#edit_note").click(function(){
		Note.save_changes();
	});
	
	$(".notes_list").on('click','.delete_note',function(e){
		Note.delete(this.dataset.note_id);
	});

	$(".notes_list").on('click','.edit_note',function(e){
		Note.currently_editing = this.dataset.note_id;
		Note.edit_trigger(Note.list.find(obj => obj.id === this.dataset.note_id));
	});

	$("#confirm_delete").on('click',function(e){
		Note.confirm_delete($('#note_id').val());
	});

	$("#cancel_edit").on('click', function(e){
		$("#editNoteModal").modal("show");
	});

	$("#confirm_edit").on('click',function(e){
		Note.confirm_changes();
	});


});