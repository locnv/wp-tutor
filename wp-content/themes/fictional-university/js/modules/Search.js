import $ from 'jquery';

class Search {

	// 1. Describe and create / initiate our object
	constructor() {
		this.resultsDiv = $('#search-overlay__results');
		this.openButton = $('.js-search-trigger');
		this.closeButton = $('.search-overlay__close');
		this.searchOverlay = $('.search-overlay');
		this.searchField = $('#search-term');

		this.isOverlayOpen = false;
		this.isSpinnerVisible = false;
		this.previousValue;
		this.typingTimer;

		this.events();

	}

	// 2. Events
	events() {
		this.openButton.on('click', this.openOverlay.bind(this));
		this.closeButton.on('click', this.closeOverlay.bind(this));

		// 'keydown' -> fired periodically
		// 'keyup' -> fired once
		$(document).on('keydown', this.keyPressDispatcher.bind(this));
		this.searchField.on('keyup', this.typingLogic.bind(this));
	}

	
	// 3. Functions / Methods

	typingLogic() {
		if(this.searchField.val() == this.previousValue) {
			return;
		}

		clearTimeout(this.typingTimer);

		if(this.searchField.val()) {
			if(!this.isSpinnerVisible) {
				this.resultsDiv.html('<div class="spinner-loader"></div>');
				this.isSpinnerVisible = true;
			}
			this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
		} else {
			this.resultsDiv.html('');
			this.isSpinnerVisible = false;
		}

		this.previousValue = this.searchField.val();
	}

	getResults() {
		this.resultsDiv.html('Search result is going to be appeared here!');
		this.isSpinnerVisible = false;
	}

	keyPressDispatcher(e) {

		if(e.keyCode === 83 && !this.isOverlayOpen && $('input, textarea').is(':focus')) {	// s (search)
			this.openOverlay();
		}

		if(e.keyCode === 27 && this.isOverlayOpen) { // ESC
			this.closeOverlay();
		}
	}

	openOverlay() {
		this.searchOverlay.addClass('search-overlay--active');
		$('body').addClass('body-no-scroll');
		this.isOverlayOpen = true;
	}

	closeOverlay() {
		this.searchOverlay.removeClass('search-overlay--active');
		$('body').removeClass('body-no-scroll');
		this.isOverlayOpen = false;
	}

}

export default Search;