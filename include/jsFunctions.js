function textColor(){
	// console.log("hi");
	var p = document.getElementsByTagName('p');
	console.log(p);
	for(var i=0; i<p.length;i++){
		if(p[i].style.color == 'red'){
			p[i].style.color = 'orange';
		}else if(p[i].style.color == 'orange'){
			p[i].style.color = 'gold';
		}else if(p[i].style.color == 'gold'){
			p[i].style.color = 'lightgreen';
		}else if(p[i].style.color == 'lightgreen'){
			p[i].style.color = 'blue';
		}else if(p[i].style.color == 'blue'){
			p[i].style.color = 'purple';
		}else if(p[i].style.color == 'purple'){
			p[i].style.color = 'pink';
		}else if(p[i].style.color == 'pink'){
			p[i].style.color = 'black';
		}else{
			p[i].style.color = 'red';
		}
	}
}
