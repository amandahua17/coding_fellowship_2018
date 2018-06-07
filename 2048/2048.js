var body = document.querySelector('body');
var key;
body.onkeypressed = function move(event) {
    key = event.keyCode;

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
