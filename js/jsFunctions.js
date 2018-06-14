//JS Functions

function FlavorFadeIn(){
	var flavor=document.getElementById("flavorInfo");
	$(flavor).fadeIn();
}

function FlavorFadeOut(){
	var flavor=document.getElementById("flavorInfo");
	$(flavor).fadeOut();
}

function ChangeTextColor(){

}

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

function closeTag(){

}

//tag class != tag id! tag id means actual badge

function addDisplayTag(){
	console.log("addDisplayTag called");
	var tagSection = document.getElementById('tagSection');
	var tagInput = document.getElementById('tagadd');
	var tagBadge = document.createElement('span');
	tagBadge.id = 'tag';
	var tag = createNewTagDisplay(tagInput.value, tagBadge);
	tagSection.appendChild(tag);
	tagInput.value = '';
}

function createNewTagDisplay(val, parent){
	var tagname = document.createTextNode('#'+val, parent);
	var x = document.createTextNode(' x');
	x.addEventListener('click', closeTag(parent));
	// x.onclick = function(){closeTag(parent)};
	tagname.id = 'tag';
	parent.appendChild(tagname);
	parent.appendChild(x);
	return parent;
}

function closeTag(tagBadge){
	var parent = document.getElementById('tagSection');
	parent.removeChild(tagBadge);
}
