function removecolor(){
	var color = prompt("Please write the color name that you would like to remove: ");
	var colors = document.getElementsByClassName("option");
	for(var i=0; i<colors.length; i++){
		if(color == colors[i]){
			colors.splice(i, 1);
			return;
		}
	}
	alert("That color is not on the menu!");
	removecolor();
}
