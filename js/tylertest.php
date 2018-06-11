<script src='jquery-3.3.1.min.js'></script>

<a href='#' onclick='toggle();'>Toggle the box</a>
<div class='box' style='background-color:green'>
	This is the box
</div>

<script>
	function toggle(){
		b = document.getElementsByClassName("box");
		$(b).toggle();
		// if(b.style.backgroundColor == 'green'){
		// 	b.style.backgroundColor = 'white';
		// }else{
		// 	b.style.backgroundColor = 'blue';
		// }
	}
</script>
