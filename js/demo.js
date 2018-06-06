function changeContent(){
	var form = document.getElementById('form');
	var rc = document.getElementsByTagName('tr').length;
	var cc = (document.getElementsByTagName('td').length)/rc;
	// console.log(form.row.value);
	// console.log(form.col.value);
	// console.log(rc);
	// console.log(cc);
	if(form.row.value>rc){
		console.log("Error! That row does not exist");
	}
	if(form.col.value>cc){
		console.log("Error! That column does not exist");
	}
	var table = document.getElementById('myTable').rows[parseInt(form.row.value,10)].cells;
	table[parseInt(form.col.value,10)].innerHTML=form.content.value;
}
