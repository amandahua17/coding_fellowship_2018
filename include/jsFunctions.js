function tagColor(){
	// console.log("hi");
	var p = document.getElementsByTagName('p');
	console.log(p);
	for(var i=0; i<p.length;i++){
		if(p[i].style.color == 'red'){
			p[i].style.color = 'green';
		}else{
			p[i].style.color = 'red';
		}
	}
}
