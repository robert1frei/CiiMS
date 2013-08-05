/**
 * Handles all the Javacript for the Dashboard.
 */
$(document).ready(function() {

	// Bind nanoscrollers
	$("#main.nano").nanoScroller();

	// Load the dashboard
	CiiDashboardUsers.load();
	
});

var CiiDashboardUsers = {

	load : function() {

	},

	loadIndex: function() {
		CiiDashboardUsers.bindUserSearchBehavior();
		CiiDashboardUsers.roundedImage();
	},

	loadUpdate : function() {
		$(".meta-icon-plus").click(function(e) {
			$(".meta-container").append("<div class=\"pure-control-group\"><label contenteditable=true>Click to Change</label><input type=\"text\" class=\"pure-input-2-3\" value=\"\" /></div>");

			$(".meta-container input").on("keyup change", function() {
				$(this).attr("name", "UserMetadata[" + $(this).prev().text() + "__new]");
			})

		});

		setInterval(function() {
			$(".meta-container label[contenteditable]").each(function() {
				$(this).next().attr("name", "UserMetadata[" + $(this).text() + "__new]");
			});
		}, 1000);
	},

	loadUserList : function() {

	},

	roundedImage : function() {
		$(".rounded-img, .rounded-img2").load(function() {
		    $(this).wrap(function(){
		      return '<span class="' + $(this).attr('class') + '" style="background:url(' + $(this).attr('src') + ') no-repeat center center; width: ' + $(this).width() + 'px; height: ' + $(this).height() + 'px;" />';
		    });
		    $(this).css("opacity","0");
		  });
	},

	bindUserSearchBehavior : function() {
		var ajaxUpdateTimeout;
	    var ajaxRequest;
	    $('input#Users_displayName').keyup(function(){
	        ajaxRequest = $(this).serialize();
	        clearTimeout(ajaxUpdateTimeout);
	        ajaxUpdateTimeout = setTimeout(function () {
	            $.fn.yiiListView.update(
	                'ajaxListView',
	                {data: ajaxRequest}
	            )
	        },
	        300);
	    });
	},

};