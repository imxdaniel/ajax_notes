<html>
<head>
<style>
	*{
		font-family:helvetica,arial,verdana;
	}

	h2{
		width: 300px;
		margin-bottom: 20px;
		margin-left: 25px;
		padding-bottom: 20px;
		border-bottom: 1px solid gray;
	}

	.text_box{
		margin:25px ;
		padding:10px;
		width:300px;
		height:250px;
		display:block;
		vertical-align:center;
		border-bottom: 1px solid gray;	
	}

	.del-btn{
		margin-left:150px;
		text-decoration: none;
	}

	/*#notes{
		border-bottom:1px solid gray;
	}*/
</style>
	<title>AJAX Activity</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$('#notes-form').submit(function(){ /* on submission of form do this */
				$.post( /* we created post action - building that post, 1. where is it being sent to */
					$('#notes-form').attr('action'), /* 1. get action attribute of this form - getting the location */
					$('#notes-form').serialize(), /* 2. serialize into a format that computer can read - string of characters */
					function(output){ /* 3. what function gets called when its successful, output was a variable we created, could call anything */
						if(output.status) /* status that we set in controller for status = true or false */
						{
							//console.log(output);
							$('#notes').append( /* append (add or edit) to the notes div we created & includes what we want it to look like & output.note_id is the id we obtained & .description is text from note*/
								'<div class="text_box" data-note-id="' + output.id + '"><div class="actions"> \
								<a class="del-btn" href="notes/delete_note/' + output.id + '">[x]</a> \
								</div><textarea class="note-text" rows="8" cols="20">' + output.description + '</textarea></div>');
						}
					}, "json"
				);
				/* json is telling it we are expecting it in json format */
				$('textarea').val(''); /*resetting text area to be empty (empty string '') val = value*/
				return false; /*normally submit goes to a diff page, it prevents it from going diff page (in our action)*/
			});

			$('#notes').on('click', 'a.del-btn', function() /* on click btn to delete */
			{
				var that = $(this); /* $this here refers to 'del-btn', but $this in next line will change to refer to a function. We use var that to remember reference to 'del-btn' */
				$.post( /* building post */
					that.attr('href'), /* location where we are sending the post to , controller and method we're sending */
					function(data)
					{
						console.log($(this));
						console.log(that);
						if (data.status) 
						{
							that.closest('.text_box').remove();  /* delete the entire textbox */
						}
					}, "json"
				);
				return false;
			});

			$('#notes').on('blur', '.note-text', function() {
				var note_id = $(this).closest('.text_box').data('note-id');
				var text = $(this).val();
				$.post (

					"<?php echo base_url('notes/edit_note') ?>",
					{'id': note_id, 'description': text},
					function(data) {
						console.log(data);
					}
				);
			});
		});
	</script>
</head>
<body>

<h2>Notes </h2>
<div id ="notes">
	<?php
		foreach ($notes as $note)
		{
			// var_dump($note);
			$box = "<div class='text_box' data-note-id={$note['id']}>";
			$box .=		"<div class='actions'>";
			$box .=	"<a class='del-btn' href='notes/delete_note/{$note['id']}'>Delete</a>";
			$box .= "</div>";
			$box .= "<textarea class='note-text' name='note_content' cols='20' rows='8'>" . $note['description'] . "</textarea>";
			$box .= "</div>"; 

			echo $box;
		}
	?>
</div>

<form action='/notes/add_note' method='post' id='notes-form'>
	<label>Add a note:</label><br>
	<textarea name='description' cols='30' rows='12'></textarea><br><br>
	<input type='submit' value='Post It'>
</form>

</body>
</html>