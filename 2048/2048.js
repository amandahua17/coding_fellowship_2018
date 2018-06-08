

var body = document.querySelector('body');
var key;
// var b1 = document.getElementById("box");
// updateBox(b1, box);
	// console.log('marker');
body.addEventListener("keydown", move);
function move(event) {
	var b1 = document.getElementById("box");
	// console.log('hi');
    key = event.keyCode || event.which;
	console.log(key);

	// var box1 = new box();
	if(key == 37){
		box.moveLeft();
	}
	if(key==38){
		box.moveUp();
	}
	if(key==39){
		box.moveRight();
	}
	if(key==40){
		box.moveDown();
	}
	updateBox(b1, box);
}

function updateBox(b, boxn){
	b.style.top = boxn.ypos + 'px';
	b.style.left = boxn.xpos + 'px';
}

var box = {
	xpos: Math.floor(Math.random()*8)*100,
	ypos: Math.floor(Math.random()*8)*100,
	moveLeft: function(){
		if(this.xpos!=0){
			this.xpos-=100;
		}
	},
	moveRight: function(){
		if(this.xpos!=700){
			this.xpos+=100;
		}
	},
	moveUp: function(){
		if(this.ypos!=0){
			this.ypos-=100;
		}
	},
	moveDown: function(){
		if(this.ypos!=700){
			this.ypos+=100;
		}
	}
};

// function moveleft(element){
// 	console.log("left");
// 	if(element.style.left != 0){
//
// 	}
// }
//
// function moveup(element){
// 	console.log("up");
// }
//
// function moveright(element){
// 	console.log("right");
// }
//
// function movedown(element){
// 	console.log("down");
// }
