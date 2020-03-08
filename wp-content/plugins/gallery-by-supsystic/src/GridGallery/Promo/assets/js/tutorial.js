(function($, pointers) {

	pointers.setPointer = function() {
		pointers = this;

		if (!this.stepNumber) {
			this.stepNumber = 0;
		}

		var pointerData = pointers.pointersData[this.stepNumber];

		if (!pointerData) {
			return;
		}

		var $target = $(pointerData.target);
		if (!$target.length) {
			return;
		}

		var $pointer = $target.pointer({
			pointerClass: pointerData.class,
			content: pointerData.title + pointerData.content,
			position: { 
				edge: pointerData.edge,
				align: pointerData.align
			},
			close: function(event) {
				if (pointers.hasNextStep) {
					pointers.stepNumber += 1;
					sessionStorage.setItem('sgg-tutorial-step', pointers.stepNumber);
					if (pointerData.nextURL && window.location.href !== pointerData.nextURL) {
						window.location = pointerData.nextURL;
					}
					pointers.setPointer();
				} else {
					$.post(ajaxurl, {
						_wpnonce: SupsysticGallery.nonce,
						action: 'sgg-tutorial-close'
					});
					sessionStorage.removeItem('sgg-tutorial-step');
				}
			}
		});
		pointers.current = $pointer;
		pointers.openPointer();
		var action = this.actions[pointerData.id];
		if (typeof action == 'function') {
			action.call(this);
		}
	};

	pointers.openPointer = function() {		  
		var $pointer = pointers.current;

		if (! typeof $pointer === 'object' ) {
			return;
		}

		$('html, body').animate({
			scrollTop: $pointer.offset().top - 200
		}, 300, function() {
			var $widget = $pointer.pointer('widget');
			pointers.setNext($widget);
			$pointer.pointer('open');
		});
	};

	pointers.setNext = function($widget) {
		this.hasNextStep = false;
		pointers = this;
		if (typeof $widget === 'object') {
			var $buttons = $widget.find('.wp-pointer-buttons');
			var $closeButton = $buttons.find('a').first().removeClass('close');
			$closeButton.html(this.close).addClass('button button-secondary stop-tutorial');

			if (this.stepNumber < this.pointersData.length - 1) {
				this.hasNextStep = true;
				if (this.pointersData[this.stepNumber].nextURL) {
					var $nextButton = $closeButton.clone(true, true);
					$nextButton.addClass('next button button-primary');
					$nextButton.html(this.next).appendTo($buttons);
				}
			}

			$closeButton.on('mousedown', function(event) {
				pointers.hasNextStep = false;
			});
		}
	};

	var stepNumber = sessionStorage.getItem('sgg-tutorial-step');

	if (stepNumber !== null) {
		pointers.stepNumber = Number(stepNumber);
	} else {
		pointers.stepNumber = 0;
	}


	pointers.actions = {
		'step-0': function() {
			pointers = this;
			$('#toplevel_page_supsystic-gallery').on('click', 'a', function(event) {
				if(!pointers.hasNextStep) return;
				event.preventDefault();
				pointers.current.pointer('close');
			});
		},
		'step-2': function() {
			pointers = this;
			$('#gallery-create').on('click', function(event) {
				if ($('#gg-create-gallery-text input:first').val().length > 0) {
					pointers.current.pointer('close');
				}
			});
		},
		'step-3': function() {
			pointers = this;
			$('button.gallery.import-to-gallery').on('click', function(event) {
				pointers.current.pointer('close');
			});
		},
		'step-4': function() {
			pointers = this;
			$('#importDialog .button').one('click', function(event) {
				pointers.current.pointer('close');
			});
		},
		'step-5': function() {
			pointers = this;
			$('#single-gallery-toolbar li:eq(1) a').one('click', function(event) {
				pointers.current.pointer('close');
			});
		},
		'step-7': function() {
			pointers = this;
			var $widget = pointers.current.pointer('widget');
			$widget.one('click', 'a.next', function(event) {
				$('.supsystic-plugin .form-tabs a:eq(1)').trigger('click');
			});
		},
		'step-8': function() {
			pointers = this;
			var $widget = pointers.current.pointer('widget');
			$widget.one('click', 'a.next', function(event) {
				$('.supsystic-plugin .form-tabs a:eq(2)').trigger('click');
			});
		},
		'step-9': function() {
			pointers = this;
			var $widget = pointers.current.pointer('widget');
			$widget.one('click', 'a.next', function(event) {
				$('.supsystic-plugin .form-tabs a:eq(3)').trigger('click');
			});
		}
	};


	pointers.init = function() {
		this.setPointer();
	};

	pointers.init();


})(jQuery, GalleryPromoPointers); 
