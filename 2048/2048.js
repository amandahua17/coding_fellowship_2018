var body = document.querySelector('body');
var key;
	// console.log('marker');
body.addEventListener("keypress", move());
function move(event) {
	// console.log('hi');
    key = event.keyCode || event.which;
	console.log(key);
	if(key == 37){
		moveleft();
	}
	if(key==38){
		moveup();
	}
	if(key==39){
		moveright();
	}
	if(key==40){
		movedown();
	}
}

function moveleft(){
	console.log("left");
}

function moveup(){
	console.log("up");
}

function moveright(){
	console.log("right");
}

function movedown(){
	console.log("down");
}
