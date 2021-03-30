/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

let userId = document.head.querySelector('meta[name="user-id"]').content;
window.Echo.private('App.User.' + userId)               
.listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', notification => {
	let notiCnt = parseInt($('#noti_count').text());
	$('#noti_count').text(notiCnt + 1);
	$('#noti_list').prepend(`<li><a href="${notification.letter.link}">${notification.letter.title}<br>${notification.letter.body}</a></li>`);

	toastr.info(notification.letter.title, notification.letter.body, {
	  timeOut: '60000',
	  positionClass: 'toast-bottom-left',
	  onclick: function() {
	  	window.location.href = notification.letter.link;
	  }
	});
})
