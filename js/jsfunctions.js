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

function toggleYoloDescription(){
	var desc = document.getElementByClassName('yoloDescription');
	if(desc.style.display == 'hidden'){
		$(desc).fadeIn();
	}else{
		$(desc).fadeOut();
	}
}

//ENTRY FUNCTIONS
function addOption(){
	console.log('addOption Called!');
	var option = document.getElementById('newOption');
	console.log(option.value);
	var element =  document.getElementById('warning');
	switch(option.value){
		case 'song':
			if (typeof(element) != 'undefined' && element != null){
				removeElement('warning');
			}
			addSongField();
			break;

		case 'photo':
				if (typeof(element) != 'undefined' && element != null){
				removeElement('warning');
			}
			addPhotoField();
			break;

		case 'person':
			if (typeof(element) != 'undefined' && element != null){
				removeElement('warning');
			}
			addPersonField();
			break;

		case 'occasion':
			if (typeof(element) != 'undefined' && element != null){
				removeElement('warning');
			}
			addOccasionField();
			break;

		case 'meal':
			if (typeof(element) != 'undefined' && element != null){
				removeElement('warning');
			}
			addMealField();
			break;

		case 'book':
			if (typeof(element) != 'undefined' && element != null){
				removeElement('warning');
			}
			addBookField();
			break;

		case 'project':
			if (typeof(element) != 'undefined' && element != null){
				removeElement('warning');
			}
			addProjectField();
			break;

		default:
			if (typeof(element) == 'undefined' || element == null){
				var warning = document.createElement('p');
	  			warning.innerHTML='Please Select A Field!';
	  			warning.style.color='red';
	  			warning.id='warning';
	  			var form = document.getElementById('addentryform');
	  			form.appendChild(warning);
			}
	}
}

function addSongField(){
	var song = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	song.id='song';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x';
	x.setAttribute('onclick', "removeElement('song')");
	//make child nodes
	var title = document.createElement('input');
	var artist = document.createElement('input');
	var link = document.createElement('input');
	link.class='optional';
	title.name='songTitle';
	artist.name='songArtist';
	link.name='songLink';

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

function addPhotoField(){
	var photo = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	photo.id='photo';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('photo')");
	//make child nodes
	var path = document.createElement('input');
	var photographer = document.createElement('input');
	var title = document.createElement('input');
	title.class='optional';
	path.name='photoPath';
	photographer.name='photographer';
	title.name='photoTitle';
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

function addPersonField(){
	var person = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	person.id='person';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('person')");
	//make child nodes
	var name = document.createElement('input');
	var relationship = document.createElement('input');
	var description = document.createElement('input');
	relationship.class='optional';
	name.name='personName';
	relationship.name='personRelationship';
	description.name='personDescription';
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

function addOccasionField(){
	var occasion = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	occasion.id='occasion';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('occasion')");
	//make child nodes
	var name = document.createElement('input');
	var description = document.createElement('input');
	name.name='occasionName';
	description.name='occasionDescription';
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

function addMealField(){
	var meal = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	meal.id='meal';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('meal')");
	//make child nodes
	var place = document.createElement('input');
	var chef = document.createElement('input');
	var description = document.createElement('input');
	place.name='mealPlace';
	chef.name='mealChef';
	description.name='mealDescription';
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

function addBookField(){
	var book = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	book.id='book';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('book')");
	//make child nodes
	var title = document.createElement('input');
	var author = document.createElement('input');
	var notes = document.createElement('input');
	title.name='bookTitle';
	author.name='bookAuthor';
	notes.name='bookNotes';
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

function addProjectField(){
	var project = document.createElement('div');
	var br = document.createElement('br');
	var button = document.getElementById('placeOptionsBeforeThis');
	project.id='project';
	//make exit
	var x = document.createElement('button');
	x.type='button';
	x.innerHTML='x\t';
	x.setAttribute('onclick', "removeElement('project')");
	//make child nodes
	var title = document.createElement('input');
	var progress = document.createElement('input');
	var collaborators = document.createElement('input');
	var notes = document.createElement('input');
	title.name='projectTitle';
	progress.name='projectProgress';
	collaborators.name='projectPartners';
	notes.name = 'projectNotes';
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
