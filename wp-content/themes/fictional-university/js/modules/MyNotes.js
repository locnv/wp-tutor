
import $ from 'jquery';

/* Declaration of MyNotes class */
class MyNotes {

	// 1.
	constructor() {
		this.events();
	}

	// events
	events() {
		$('#my-notes').on('click', '.delete-note', this.deleteNote.bind(this));
		$('#my-notes').on('click', '.edit-note', this.editNote.bind(this));
		$('#my-notes').on('click', '.update-note', this.updateNote.bind(this));
		$('.submit-note').on('click', this.createNote.bind(this));
	}

	// methods

	editNote(e) {
		var thisNote = $(e.target).parents('li');
		if(thisNote.data('state') == 'editable') {
			this.makeNoteReadOnly(thisNote);
		} else {
			this.makeNoteEditable(thisNote);
		}
		
	}

	makeNoteEditable(thisNote) {
		thisNote.find('.edit-note').html('<i class="fa fa-times" aria-hidden="true"></i>Cancel');

		thisNote.find('.note-title-field, .note-body-field')
		.removeAttr('readonly')
		.addClass('note-active-field');

		thisNote.find('.update-note')
		.addClass('update-note--visible');

		thisNote.data('state', 'editable');
	}

	makeNoteReadOnly(thisNote) {
		thisNote.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit');

		thisNote.find('.note-title-field, .note-body-field')
		.attr('readonly', 'readonly')
		.removeClass('note-active-field');

		thisNote.find('.update-note')
		.removeClass('update-note--visible');

		thisNote.data('state', 'cancel');
	}

	deleteNote(e) {
		var thisNote = $(e.target).parents('li');

		var url = siteInfo.rootUrl + '/wp-json/wp/v2/note/' + thisNote.data('id'); // data-id -> id
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', siteInfo.nonce);
			},
			url: url,
			type: 'DELETE',
			success: (resp) => {
				thisNote.slideUp();
				console.log('Server response -> ');
				console.log(resp);

				if(resp.userNoteCount < 500) {
					$('.note-limit-message').removeClass('active');
				}
			},
			error: (err) => {
				console.log('Sorry, there is an error.', err);
			}
		});
	}

	updateNote(e) {
		var thisNote = $(e.target).parents('li');
		var ourUpdatedPost = {
			'title': thisNote.find('.note-title-field').val(),
			'content': thisNote.find('.note-body-field').val()
		}

		var url = siteInfo.rootUrl + '/wp-json/wp/v2/note/' + thisNote.data('id'); // data-id -> id
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', siteInfo.nonce);
			},
			url: url,
			type: 'POST',
			data: ourUpdatedPost,
			success: (resp) => {
				this.makeNoteReadOnly(thisNote);
				console.log('Server response -> ');
				console.log(resp);
			},
			error: (err) => {
				console.log('Sorry, there is an error.', err);
			}
		});
	}

	createNote() {
		var ourNewPost = {
			'title': $('.new-note-title').val(),
			'content': $('.new-note-body').val(),
			'status': 'publish'
		}

		var url = siteInfo.rootUrl + '/wp-json/wp/v2/note/';
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', siteInfo.nonce);
			},
			url: url,
			type: 'POST',
			data: ourNewPost,
			success: (resp) => {
				$('.new-note-title, .new-note-body').val('');
				$(`
					<li data-id="${resp.id}">
		            	<input readonly class="note-title-field" type="text" name="txtTitle" value="${resp.title.raw}">
		            	<span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
		            	<span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
		            	<textarea readonly class="note-body-field">${resp.content.raw}</textarea>
		            	<span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
		            </li>
				`).prependTo($('#my-notes')).hide().slideDown();

				console.log('Server response -> ');
				console.log(resp);
			},
			error: (err) => {
				if(err.responseText == 'You have reached your note limit.') {
					$('.note-limit-message').addClass('active');
				}

				console.log('Sorry, there is an error.', err);
			}
		});
	}


}

export default MyNotes;
