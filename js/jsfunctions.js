//JS FUNCTIONS

function showLoginForm(){
	var form = document.getElementById('loginform');
	// console.log("showloginform");
	var hide = document.getElementById('intro');
	var hide2 = document.getElementById('createaccountform');
	// console.log(hide);
	$(hide).fadeOut();
	$(hide2).fadeOut();
	$(form).fadeIn();
}

function showCreateAccountForm(){
	var form = document.getElementById('createaccountform');
	// console.log("showloginform");
	var hide = document.getElementById('intro');
	var hide2 = document.getElementById('loginform');
	// console.log(hide);
	$(hide).fadeOut();
	$(hide2).fadeOut();
	$(form).fadeIn();
}

function showAddEntryForm(){
	var form = document.getElementById('addentryform');
	// console.log("showloginform");
	var hide = document.getElementsByClassName('addEntryButton');
	// var hide2 = document.getElementById('loginform');
	// console.log(hide);
	$(hide).fadeOut();
	// $(hide2).fadeOut();
	$(form).fadeIn();
}

function removeElement(stringid){
	console.log('removeElement Called!');
	var rem = document.getElementById(stringid);
	$(rem).remove();
}

function showYoloDescription(){
	console.log('toggleCalled');
	var desc = document.getElementsByClassName('yoloDescription')[0];
		$(desc).fadeIn();
}

function hideYoloDescription(){
	var desc = document.getElementsByClassName('yoloDescription')[0];
	$(desc).fadeOut();
}

function elementExists(id){
	var element = document.getElementById(id);
	if (typeof(element) != 'undefined' && element != null){
		return true;
	}
	return false;
}

//ENTRY FUNCTIONS
var songc = 0;
var photoc = 0;
var personc = 0;
var occasionc = 0;
var mealc = 0;
var bookc = 0;
var projectc = 0;
var date = new Date();
if(Date() != date){
	songc = 0;
	photoc = 0;
	personc = 0;
	occasionc = 0;
	mealc = 0;
	bookc = 0;
	projectc = 0;
}

function addOption(){
	console.log('addOption Called!');
	var option = document.getElementById('newOption');
	console.log(option.value);
	switch(option.value){
		case 'song':
			if (elementExists('warning')){
				removeElement('warning');
			}
			addSongField(songc);
			console.log(document.getElementsByName('songTitle'+songc));
			songc++;
			break;

		case 'photo':
				if (elementExists('warning')){
				removeElement('warning');
			}
			addPhotoField(photoc);
			photoc++;
			break;

		case 'person':
			if (elementExists('warning')){
				removeElement('warning');
			}
			addPersonField(personc);
			personc++;
			break;

		case 'occasion':
			if (elementExists('warning')){
				removeElement('warning');
			}
			addOccasionField(occasionc);
			occasionc++;
			break;

		case 'meal':
			if (elementExists('warning')){
				removeElement('warning');
			}
			addMealField(mealc);
			mealc++;
			break;

		case 'book':
			if (elementExists('warning')){
				removeElement('warning');
			}
			addBookField(bookc);
			bookc++;
			break;

		case 'project':
			if (elementExists('warning')){
				removeElement('warning');
			}
			addProjectField(projectc);
			projectc++;
			break;

		default:
			if (!elementExists('warning')){
				var warning = document.createElement('p');
	  			warning.innerHTML='Please Select A Field!';
	  			warning.style.color='red';
	  			warning.id='warning';
	  			var form = document.getElementById('addentryform');
	  			form.appendChild(warning);
			}
	}
	// console.log("song: ", songc,
	//  			"photo: ", photoc,
	// 			"person: ", personc,
	// 			"occasion: ", occasionc,
	// 			"meal: ", mealc,
	// 			"book: ", bookc,
	// 			"project: ", projectc);
}

function addSongField(n){
	var song = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	song.id='song'+n;
	song.class='song';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x';
	x.setAttribute('onclick', "removeElement('song"+n+"'); songc--;");
	//make child nodes
	var title = document.createElement('input');
	var artist = document.createElement('input');
	var link = document.createElement('input');
	link.class='optional';
	title.name='songTitle'+n;
	artist.name='songArtist'+n;
	link.name='songLink'+n;

	//put child nodes into song
	$(song).append('Song:\t\t');
	song.appendChild(x);
	$(song).append($(br).clone());
	$(song).append('Song Title: ', title);
	$(song).append($(br).clone());
	$(song).append($(br).clone());
	$(song).append('Artist: ', artist);
	$(song).append($(br).clone());
	$(song).append($(br).clone());
	$(song).append('Link(optional): ', link);
	$(song).append($(br).clone());
	$(song).append($(br).clone());
	//put song node into form
	var form = document.getElementById('addentryform');
	form.appendChild(song);

}

function addPhotoField(n){
	var photo = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	photo.id='photo'+n;
	photo.class='photo';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('photo"+n+"'); photoc--;");
	//make child nodes
	var path = document.createElement('input');
	var photographer = document.createElement('input');
	var title = document.createElement('input');
	title.class='optional';
	path.name='photoPath'+n;
	photographer.name='photographer'+n;
	title.name='photoTitle'+n;
	//put child nodes into photo
	$(photo).append('Photo:\t\t');
	photo.appendChild(x);
	$(photo).append($(br).clone());
	$(photo).append('Path: ', path);
	$(photo).append($(br).clone());
	$(photo).append($(br).clone());
	$(photo).append('Photographer: ', photographer);
	$(photo).append($(br).clone());
	$(photo).append($(br).clone());
	$(photo).append('Title(optional): ', title);
	$(photo).append($(br).clone());
	$(photo).append($(br).clone());
	//put photo node into form
	var form = document.getElementById('addentryform');
	form.appendChild(photo);
}

function addPersonField(n){
	var person = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	person.id='person'+n;
	person.class='person';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('person"+n+"'); personc--;");
	//make child nodes
	var name = document.createElement('input');
	var relationship = document.createElement('input');
	var description = document.createElement('input');
	relationship.class='optional';
	name.name='personName'+n;
	relationship.name='personRelationship'+n;
	description.name='personDescription'+n;
	//put child nodes into person
	$(person).append('Person:\t\t');
	person.appendChild(x);
	$(person).append($(br).clone());
	$(person).append('Name: ', name);
	$(person).append($(br).clone());
	$(person).append($(br).clone());
	$(person).append('Relationship(optional): ', relationship);
	$(person).append($(br).clone());
	$(person).append($(br).clone());
	$(person).append('Description: ', description);
	$(person).append($(br).clone());
	$(person).append($(br).clone());
	//put person node into form
	var form = document.getElementById('addentryform');
	form.appendChild(person);
}

function addOccasionField(n){
	var occasion = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	occasion.id='occasion'+n;
	occasion.class='occasion';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('occasion"+n+"'); occasionc--;");
	//make child nodes
	var name = document.createElement('input');
	var description = document.createElement('input');
	name.name='occasionName'+n;
	description.name='occasionDescription'+n;
	//put child nodes into occasion
	$(occasion).append('Event:\t\t');
	occasion.appendChild(x);
	$(occasion).append($(br).clone());
	$(occasion).append('Event Name: ', name);
	$(occasion).append($(br).clone());
	$(occasion).append($(br).clone());
	$(occasion).append('Description: ', description);
	$(occasion).append($(br).clone());
	$(occasion).append($(br).clone());
	//put occasion node into form
	var form = document.getElementById('addentryform');
	form.appendChild(occasion);
}

function addMealField(n){
	var meal = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	meal.id='meal'+n;
	meal.class='meal';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('meal"+n+"'); meal--");
	//make child nodes
	var place = document.createElement('input');
	var chef = document.createElement('input');
	var description = document.createElement('input');
	place.name='mealPlace'+n;
	chef.name='mealChef'+n;
	description.name='mealDescription'+n;
	//put child nodes into meal
	$(meal).append('Meal:\t\t');
	meal.appendChild(x);
	$(meal).append($(br).clone());
	$(meal).append('Place of Consumption: ', place);
	$(meal).append($(br).clone());
	$(meal).append($(br).clone());
	$(meal).append('Chef: ', chef);
	$(meal).append($(br).clone());
	$(meal).append($(br).clone());
	$(meal).append('Description: ', description);
	$(meal).append($(br).clone());
	$(meal).append($(br).clone());
	//put meal node into form
	var form = document.getElementById('addentryform');
	form.appendChild(meal);
}

function addBookField(n){
	var book = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	book.id='book'+n;
	book.class='book';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('book'); bookc--;");
	//make child nodes
	var title = document.createElement('input');
	var author = document.createElement('input');
	var notes = document.createElement('input');
	title.name='bookTitle'+n;
	author.name='bookAuthor'+n;
	notes.name='bookNotes'+n;
	notes.class='optional';
	//put child nodes into book
	$(book).append('Book:\t\t');
	book.appendChild(x);
	$(book).append($(br).clone());
	$(book).append('Title: ', title);
	$(book).append($(br).clone());
	$(book).append($(br).clone());
	$(book).append('Author: ', author);
	$(book).append($(br).clone());
	$(book).append($(br).clone());
	$(book).append('Notes(optional): ', notes);
	$(book).append($(br).clone());
	$(book).append($(br).clone());
	//put book node into form
	var form = document.getElementById('addentryform');
	form.appendChild(book);
}

function addProjectField(n){
	var project = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	project.id='project'+n;
	project.class='project';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('project"+n+"'); projectc--;");
	//make child nodes
	var title = document.createElement('input');
	var progress = document.createElement('input');
	var collaborators = document.createElement('input');
	var notes = document.createElement('input');
	title.name='projectTitle'+n;
	progress.name='projectProgress'+n;
	collaborators.name='projectPartners'+n;
	notes.name = 'projectNotes'+n;
	notes.class='optional';
	collaborators.class='optional';
	//put child nodes into project
	$(project).append('Project:\t\t');
	project.appendChild(x);
	$(project).append($(br).clone());
	$(project).append('Title: ', title);
	$(project).append($(br).clone());
	$(project).append($(br).clone());
	$(project).append('Progress: ', progress);
	$(project).append($(br).clone());
	$(project).append($(br).clone());
	$(project).append('Collaborators: ', collaborators);
	$(project).append($(br).clone());
	$(project).append($(br).clone());
	$(project).append('Notes(optional): ', notes);
	$(project).append($(br).clone());
	$(project).append($(br).clone());
	//put project node into form
	var form = document.getElementById('addentryform');
	form.appendChild(project);
}

function validateEntryForm(){
	var segments = window.location.href.split('?');		//'view_day.php', 'date=xxxx-xx-xx'
	var postvars = segments[1].split('=');				//'date', 'xxxx-xx-xx'
	var date = postvars[1];
	var freeWrite = document.getElementsByName('freeWrite').value;

	//checking content...		
	var songa = [songc][];
	var photoa = [photoc][];
	var peresona = [personc][];
	var occasiona = [occasionc][];
	var meala = [mealc][];
	var booka = [bookc][];
	var projecta = [projectc][];

	//song
	for(var i = 1; i < songa[0]; i++){
		songa[i][0] = $('#songTitle').val();
		songa[i][1] = $('#songArtist').val();
		songa[i][2] = $('#songLink').val();
	}

	//photo
	for(var i = 1; i < songa[0]; i++){
		songa[i][0] = $('#photoPath').val();
		songa[i][1] = $('#photoPhotographer').val();
		songa[i][2] = $('#photoTitle').val();
	}

	//person
	for(var i = 1; i < songa[0]; i++){
		songa[i][0] = $('#personName').val();
		songa[i][1] = $('#personRelationship').val();
		songa[i][2] = $('#personDescription').val();
	}

	//occasion
	for(var i = 1; i < songa[0]; i++){
		songa[i][0] = $('#occasionName').val();
		songa[i][1] = $('#occasionDescription').val();
	}

	//meal
	for(var i = 1; i < songa[0]; i++){
		songa[i][0] = $('#mealPlace').val();
		songa[i][1] = $('#mealChef').val();
		songa[i][2] = $('#mealDescription').val();
	}

	//book
	for(var i = 1; i < songa[0]; i++){
		songa[i][0] = $('#bookTitle').val();
		songa[i][1] = $('#bookAuthor').val();
		songa[i][2] = $('#bookNotes').val();
	}

	//project
	for(var i = 1; i < songa[0]; i++){
		songa[i][0] = $('#projectTitle').val();
		songa[i][1] = $('#projectProgress').val();
		songa[i][2] = $('#projectPartners').val();
		songa[i][3] = $('#projectNotes').val();
	}

	console.log('going through js functions');
	$.post({url:'/ajax/addEntry.php',
			data:{
				'songs': songa,
				'photos': photoa,
				'people': persona,
				'occasions': occasiona,
				'meals': meala,
				'books': booka,
				'projects': projecta,
				'date': date,
				'freeWrite': freeWrite
			},
			success: function(data){		//SUCCESS CARRIES OUT AFTER
				console.log(data);
				$('#e1').html(data);
				// console.log($('#e1').length);
				// if(!$('#e1').length){
					// var title = document.getElementsByTagName('h1');
					// var text = document.createTextNode(data);
					// text.id = 'e1';
					// console.log('text.id = '+text.id);
					// title[0].after(text);
				// }

			}
	});
}
