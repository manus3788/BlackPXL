@include('layouts.app')

<style type="text/css">
	.centerAlign{
		text-align: center;
	}
	.requiredspan {
		color: red;
	}
</style>
<div class="container">
	<div class="col-md-12">
		<h2><u>Job Application :</u></h2>
	</div>
	<br>
	<form id="user_form">
		<div class="col-md-12">
			<div class="alert alert-success col-md-8 centerAlign" id="success_message" style="display: none;">
			    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			    <label></label>
			</div>
			<div class="alert alert-danger col-md-8 centerAlign" id="error_message_fail" style="display: none;">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			    <label></label>
			</div>
		</div>		
		<label class="col-md-12"><span class="requiredspan">*</span> Fields Required</label>
		<div class="row col-md-12">

			<div class="form-group col-md-4">
				<label for="name">Name <span class="requiredspan">*</span></label>
				<input type="text" id="name" class="form-control" name="name" placeholder="Name">
				<span id="error_name" class="help-block requiredspan"></span>
			</div>
			<div class="form-group  col-md-4">
				<label for="email">Email <span class="requiredspan">*</span></label>
				<input type="text" id="email" class="form-control" name="email" placeholder="Email" >
				<span id="error_email" class="help-block requiredspan"></span>				
			</div>
		</div>
		<div class="row col-md-12">
			<div class="form-group col-md-4">
				<label for="applied_for">Applying For <span class="requiredspan">*</span></label>
				<select id="designation" class="form-control" name="designation" >
					<option value="">Select Designation</option>
					<option value="Developer">Developer</option>
					<option value="Designer">Designer</option>
					<option value="SEO">SEO</option>
					<option value="Manager">Manager</option>
				</select>
				<span id="error_designation" class="help-block requiredspan"></span>
			</div>
			<div class="form-group col-md-4">
				<label for="resume">Resume <span class="requiredspan">*</span></label>
				<input type="file" id="resume" class="form-control" name="resume"  accept=".pdf,.doc">
				<span id="error_resume" class="help-block requiredspan"></span>				
			</div>
		</div>
		<div class="row col-md-12">
			<div class="form-group col-md-8">
				<label for="message">Message <span class="requiredspan">*</span></label>
				<textarea style="resize: none;" rows="4" id="message" name="message" class="form-control" placeholder="Enter your message here..." ></textarea>
				<span id="error_message" class="help-block requiredspan"></span>	
			</div>
		</div>
		<div class="row col-md-12">
			<div class="form-group  col-md-8">
				<button class="btn btn-success pull-right" style="margin-left: 5px;padding-right: 20px;padding-left: 20px;" type="submit" id="apply">Apply</button>
				<button class="btn btn-danger pull-right" style="margin-right: 5px;padding-right: 20px;padding-left: 20px;" type="reset" id="reset">Reset</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

	//setting up CSRF Token Globally for all ajax Requests
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(document).ready(function() {
		/* submitting Job Application*/
		$(document).on('submit', '#user_form' , function(e) { 
			e.preventDefault();
			$('#error_message_fail').hide();
			$('#success_message').hide();
			$('.help-block').html('');

      		var formData = new FormData(this);	
      		$.ajax({
				type:'POST',
				url: "{{url('/storeUserInfo')}}",
				data: formData,
				cache:false,
				contentType: false,
				processData: false,
				success: function(data) {
					$('#success_message').show();
					$('#success_message label').html(data.message);
					$('#reset').trigger('click');
				},
				error: function(error) {
					$.each(error.responseJSON.errors, function(index){
						$('#error_'+index).html(this[0]);
					});	
					$('#error_message_fail').show();
					$('#error_message_fail label').html(error.responseJSON.message);					
				}
			});
		});
	});
</script>