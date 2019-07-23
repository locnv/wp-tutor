import $ from 'jquery';

class Like {

	constructor() {

		this.events();

	}

	// Events

	events() {
		$('.like-box').on('click', this.ourClickDispatcher.bind(this));
	}

	// Methods

	ourClickDispatcher(e) {

		var currentLikeBox = $(e.target).closest('.like-box');

		if($(currentLikeBox).data('exist') == 'yes') {
			this.deleteLike(currentLikeBox);
		} else {
			this.createLike(currentLikeBox);
		}
	}

	createLike(likeBox) {
		var url = siteInfo.rootUrl + '/wp-json/university/v1/manageLike';
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-WP-Nonce', siteInfo.nonce);
			},
			url: url,
			type: 'POST',
			data: { 'professorId': likeBox.data('professor') },
			success: (resp) => {
				console.log(resp);
			},
			error: (err) => {
				console.error(err);
			}
		});
	}

	deleteLike(likeBox) {
		var url = siteInfo.rootUrl + '/wp-json/university/v1/manageLike';
		$.ajax({
			url: url,
			type: 'DELETE',
			success: (resp) => {
				console.log(resp);
			},
			error: (err) => {
				console.error(err);
			}
		});
	}

}

export default Like;
