<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	 <form id="form1" >
	   <input type='file' id="imgInp" />
	   <img id="blah" src="#" alt="your image" />
	</form>
	<script src="JavaScript/jquery.min.js"></script>
	<script>

		$("#imgInp").change(function(){
		   if (this.files && this.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		        	alert(e.target.result);
		            $('#blah').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(this.files[0]);
		    }
		});
	</script>
</body>
</html>