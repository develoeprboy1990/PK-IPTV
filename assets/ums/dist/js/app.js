$.app = {
	message_box: function(message, selector, element) {
		switch(selector) {
			case 'error': 
				$(element+' .message-container').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+message+'</div>');
				break;

			case 'warning':
				$(element+' .message-container').html('<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+message+'</div>');
				break;

			case 'info':
				$(element+' .message-container').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+message+'</div>');
				break;

			case 'clear':
				$(element+' .message-container').html('');
				break;

			case 'success':
			default:
				$(element+' .message-container').html('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+message+'</div>');
				break;
		}
	},
};
