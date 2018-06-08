
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
var body = document.querySelector('body');
var key;
var b1 = document.getElementById("box");
	updateBox(b1);
// var

body.addEventListener("keydown", move);
function move(event) {
	// console.log('hi');
    key = event.keyCode || event.which;
	// console.log(key);
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
	updateBox(b1);
}

function updateBox(b){
	b.style.top = box.ypos + 'px';
	b.style.left = box.xpos + 'px';
	b.style.backgroundColor = '#'+ getBoxColor(box.xpos, box.ypos).toString(16);

	// checkDots(box.ypos, box.xpos);
}

function getBoxColor(xpos, ypos){
	// console.log(xpos, ypos);
	var xcol;
	var ycol;
	switch (xpos){
		case 0:
			xcol = 0x171;
			break;
		case 100:
			xcol = 0x371;
			break;
		case 200:
			xcol = 0x571;
			break;
		case 300:
			xcol = 0x771;
			break;
		case 400:
			xcol = 0x971;
			break;
		case 500:
			xcol = 0xa71;
			break;
		case 600:
			xcol = 0xc71;
			break;
		case 700:
			xcol = 0xe71;
			break;
		default:
			xcol = 0x070;
	}

	switch (ypos){
		case 0:
			ycol = 0x171;
			break;
		case 100:
			ycol = 0x173;
			break;
		case 200:
			ycol = 0x175;
			break;
		case 300:
			ycol = 0x177;
			break;
		case 400:
			ycol = 0x179;
			break;
		case 500:
			ycol = 0x17a;
			break;
		case 600:
			ycol = 0x17c;
			break;
		case 700:
			ycol = 0x17e;
			break;
		default:
			ycol = 0x070;
	}
	var col = ycol+xcol;
	// console.log(col.toString(16));
	return col;
}

function checkDots(){

}

function newDot(){
	var dot = document.createElement("div");
	var parent = document.getElementById("container");
	dot.style.width = "10px";
	dot.class = 'dot';
	parent.appendChild(dot);
}
