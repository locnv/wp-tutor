import $ from 'jquery';

class Search {

	// 1. Describe and create / initiate our object
	constructor() {

		this.addSearchHTML();

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

		if(this.searchField.val() !== this.previousValue) {
			clearTimeout(this.typingTimer);

			if(this.searchField.val()) {
				if(!this.isSpinnerVisible) {
					this.resultsDiv.html('<div class="spinner-loader"></div>');
					this.isSpinnerVisible = true;
				}
				this.typingTimer = setTimeout(this.getResults.bind(this), 750);
			} else {
				this.resultsDiv.html('');
				this.isSpinnerVisible = false;
			}			
		}

		this.previousValue = this.searchField.val();
	}

	getResults() {

		var url = siteInfo.rootUrl + '/wp-json/university/v1/search?term=' + this.searchField.val();
		$.getJSON(url, (results) => {
			var retHtml = `
				<div class="row">
					<div class="one-third">
						<h2 class="search-overlay__section-title">General Information</h2>
						${results.generalInfo.length > 0 ? '<ul class="link-list min-list">' : '<p>No general information match search.</p>'}
							${results.generalInfo.map(item => `<li><a href="${item.link}">${item.title}</a> ${item.postType === 'post' ? `<small>by <b>${item.authorName}</b></small>` : ''}</li>`).join('')}
						${results.generalInfo.length > 0 ? '</ul>' : ''}
					</div>
					<div class="one-third">
						<h2 class="search-overlay__section-title">Programs</h2>
						${results.programs.length > 0 ? '<ul class="link-list min-list">' : `<p>No Programs match that search. <a href="${siteInfo.rootUrl}/programs">View all programs</a></p>`}
							${results.programs.map(item => `<li><a href="${item.link}">${item.title}</a></li>`).join('')}
						${results.programs.length > 0 ? '</ul>' : ''}

						<h2 class="search-overlay__section-title">Professors</h2>

					</div>
					<div class="one-third">
						<h2 class="search-overlay__section-title">Campuses</h2>
						${results.campuses.length > 0 ? '<ul class="link-list min-list">' : `<p>No Campuses match that search. <a href="${siteInfo.rootUrl}/campuses">View all campuses</a>.</p>`}
							${results.campuses.map(item => `<li><a href="${item.link}">${item.title}</a></li>`).join('')}
						${results.campuses.length > 0 ? '</ul>' : ''}

						<h2 class="search-overlay__section-title">Events</h2>
					</div>
				</div>
			`;

			this.resultsDiv.html(retHtml);
			this.isSpinnerVisible = false;
		});

	}

	keyPressDispatcher(e) {
		if(e.keyCode === 83 && !this.isOverlayOpen && !$('input, textarea').is(':focus')) {	// s (search)
			this.openOverlay();
		}

		if(e.keyCode === 27 && this.isOverlayOpen) { // ESC
			this.closeOverlay();
		}
	}

	openOverlay() {
		this.searchOverlay.addClass('search-overlay--active');
		$('body').addClass('body-no-scroll');
		this.searchField.val('');
		this.isOverlayOpen = true;
		setTimeout(() => this.searchField.focus(), 301);
		
	}

	closeOverlay() {
		this.searchOverlay.removeClass('search-overlay--active');
		$('body').removeClass('body-no-scroll');
		this.isOverlayOpen = false;
	}

	addSearchHTML() {
		$('body').append(`
			<div class="search-overlay">
    
		    <div class="search-overlay__top">
		      <div class="container">
		        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
		        <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
		        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
		      </div>
		    </div>

		    <div class="container">
		      <div id="search-overlay__results"></div>
		    </div>
		  </div>
		`);
	}

}

export default Search;
