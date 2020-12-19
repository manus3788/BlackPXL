@include('layouts.app')
<style type="text/css">
	.centerAlign{
		text-align: center;
	}
	.requiredspan {
		color: red;
	}
	.input-icon-wrap {
	  border: none;    
	  display: flex;
	  flex-direction: row;
	}
	
</style>
<div class="container">
	<div class="col-md-12">
		<h2><u>Dynamic Upload:</u></h2>
	</div>
	<br>
	<label class="col-md-12"><span class="requiredspan">*</span> Max 6</label>
	<div class="alert alert-danger col-md-5 centerAlign" id="error_maxout" style="display: none;">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<label></label>
	</div>
	<div class="alert alert-success col-md-5 centerAlign" id="success_message" style="display: none;">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<label></label>
	</div>
	<form id="dynamic_form">
		<div id="dynamic_container">
			<div class="row col-md-12">
				<div class="form-group col-md-6 input-icon-wrap">
					<label for="resume"> </label>
					<input type="file" name="file1" class="form-control col-md-9 filesClass">
					<span class="col-md-1" style="cursor: pointer;" id="addInputField"><i class="fa fa-plus-circle" style="font-size: 35px;color: green"></i></span>			
				</div>
			</div>
		</div>	
		<div class="row col-md-12">
			<div class="form-group  col-md-4">
				<button class="btn btn-primary" style="margin-left: 5px;padding-right: 20px;padding-left: 20px;" type="submit" id="saveFiles">Submit</button>
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
	var glblCount = 1;
	$(document).ready(function() {
		/*
			onclicking of the plus button appending the input div based count of input fields
		*/

		$(document).on('click', '#addInputField' ,function() {
			/*
				// checking the how many fileds are insertd
				//appending based on number of input fields
			*/
			var count = ++glblCount;
			if ($('#dynamic_container .row').length < 6) {  
				var input_fields = '<div class="row col-md-12"><div class="form-group col-md-6 input-icon-wrap"><input type="file" name="file'+count+'" class="form-control col-md-9 filesClass"><span class="col-md-1 removeInputFields" style="cursor: pointer;" ><i class="fa fa-minus-circle" style="font-size: 35px;color: red"></i></span></div></div>';
				$('#dynamic_container').append(input_fields);
			} else {
				/*
					//not allowing to add
				*/
				$('#error_maxout').show();
				$('#error_maxout label').html('More than 6 not Allowed');
			}
		});

		$(document).on('click', '.removeInputFields' ,function() {
			/*
				removing the input field on minus button click
			*/
			$(this).closest('.row').remove();	
		});

		/*
			ajax on submit uploading multiple files
		*/
		$(document).on('submit', '#dynamic_form', function(e) {
			e.preventDefault(); //preventing default submit actions
			$('#error_maxout').hide();
			$('#success_message').hide();
			
			var formData = new FormData(this);
			$.ajax({
				type:'POST',
				url:"{{url('dynamicUpload')}}",
				contentType: false,
				processData: false,
				data:formData,
				success:function(data) {
					$('#success_message').show();
					$('#success_message label').html(data.message);
					$('#dynamic_form')[0].reset();
				},
				error:function(e){
					$('#error_maxout').show();
					$('#error_maxout label').html(e.responseJSON.message);
				}
			});
		});
	});
</script>