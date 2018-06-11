<script src='/js/jquery.js'></script>

<!-- <a href='#' onclick='toggle();'></a> -->
<!-- <form>
	<input type='text'value=''></input>
</form> -->
<h2 style='text-align:center;'>Calculate a random number between designated limits(non-inclusive)</h2>
<button onclick='calculate()' style='text-align:center'>Get Started</button>
<!-- <div class='box' style='background-color:green'>
	This is the box
</div> -->

<script>
	function toggle(){
		b = document.getElementsByClassName("box");
		$(b).toggle();
	}
	function calculate(){
		var a = parseInt(prompt("Enter a lower limit: "));
		var b = parseInt(prompt("Enter an upper limit: "));
		if(a>=b){
			alert("Your lower limit must be less than your upper limit!");
			calculate();
		}else{
			var r = (Math.random());
			var c = a+(r*(b-a+1));
			console.log("ll: " + a + "\nul: " + b + "\nrandom:" + r);
			document.write('Your random number: '+ c);
		}
	}
</script>
