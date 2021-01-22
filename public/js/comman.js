$(document).ready(function(){
	// $.noConflict();
	$('[data-toggle="tooltip"]').tooltip();

	// $(".delete").click(function(){
	// 	var editID = $(this).attr("deleteID");
	// 	$("#deleteID").val(editID);
	// 	$("#deleteEmployeeModal").modal("show");
	// });

	$("form#editEmployee").submit(function(e){
		e.preventDefault();
		var formData = new FormData();
		formData.append('image', $('#image')[0].files[0]);
		formData.append('id', $("#editID").val());
		formData.append('fname', $("#fname").val());
		formData.append('lname', $("#lname").val());
		formData.append('email', $("#email").val());
		formData.append('phone', $("#phone").val());
		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('input[name="_token"]').val()
				}
			});
		$.ajax({
			url: url+"/frontend/submitform/submitUpdateform",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(result){
				if(result == 1){
					$("#editEmployeeModal").modal("hide");
					$("form#editEmployeeModal").trigger("reset");
					window.location.reload();
					return true;
				}else{
					$("form#editEmployeeModal").trigger("reset");
					alert("something went wrong..!");
					return false;
				}
			}
		});
	});


	


	$("form#deleteEmployee").submit(function(e){
		e.preventDefault();
		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('input[name="_token"]').val()
				}
			});
		var deleteID = $("#deleteID1").val();
		$.ajax({
			url: url+"/frontend/submitform/submitDeleteform",
			method: 'POST',
			data: {'id': deleteID },
			success: function(result){
				if(result == 1){
					$("#deleteEmployeeModal").modal("hide");
					$("form#deleteEmployeeModal").trigger("reset");
					window.location.reload();
					return true;
				}else{
					$("form#deleteEmployeeModal").trigger("reset");
					alert("something went wrong..!");
					return false;
				}
			}
		});
	});



});

function editData(arrData){
	var arrData = JSON.parse(arrData);
	$("#editID").val(arrData.id);
	if(arrData.image!=null){
		$('#oldImage').prop('src',url+'/public/users/'+arrData.image);
	}
	$("#fname").val(arrData.fname);
	$("#lname").val(arrData.lname);
	$("#email").val(arrData.email);
	$("#phone").val(arrData.phone);       
	$("#editEmployeeModal").modal("show");
}
function deleteData(id){
	$("#deleteID1").val(id);
	$("#deleteEmployeeModal").modal("show");
}
