// comment related
var comment_name = '';
var comment_email_address = '';
var comment_url = '';

// photo related
var view_exif = 'true';
var view_comments = 'true';
var exif_html_view = '';
var comment_html_view = '';

function getCookies() {
	var cookie_str = unescape(document.cookie);
	var cookie_arr = cookie_str.split(';');

	for (var a = 0; a < cookie_arr.length; a++) {
		var t_cookie = cookie_arr[a].split('=');
		// trim lead/trailing whitespace
		t_cookie[0] = t_cookie[0].replace(/(^\s*|\s*$)/, '');
		if (t_cookie[0] == 'comment_name') {
			comment_name = (t_cookie[1] == undefined ? '' : t_cookie[1]);
		}
		else if (t_cookie[0] == 'comment_email_address') {
			comment_email_address = (t_cookie[1] == undefined ? '' : t_cookie[1]);
		}
		else if (t_cookie[0] == 'comment_url') {
			comment_url = (t_cookie[1] == undefined ? '' : t_cookie[1]);
		}
		else if (t_cookie[0] == 'view_exif') {
			view_exif = (t_cookie[1] == undefined ? '' : t_cookie[1]);
		}
		else if (t_cookie[0] == 'view_comments') {
			view_comments = (t_cookie[1] == undefined ? '' : t_cookie[1]);
		}
	}
}
function setCommentCookies(f) {
	document.cookie = 'comment_name='+f.name.value+'; path=/; expires=Friday, 01-Jan-2010 00:00:00 GMT';
	document.cookie = 'comment_email_address='+f.email_address.value+'; path=/; expires=Friday, 01-Jan-2010 00:00:00 GMT';
	document.cookie = 'comment_url='+f.url.value+'; path=/; expires=Friday, 01-Jan-2010 00:00:00 GMT';
}
function forgetCommentCookies(c) {
	if (!c.checked) {
		document.cookie = 'comment_name=; path=/; expires=Monday, 01-Jan-1990 00:00:00 GMT';
		document.cookie = 'comment_email_address=; path=/; expires=Monday, 01-Jan-1990 00:00:00 GMT';
		document.cookie = 'comment_url=; path=/; expires=Monday, 01-Jan-1990 00:00:00 GMT';
	}
}
function commentLinkOver() {
	window.status='click to view comments';
	return true;
}
function commentLinkOut() {
	window.status='';
	return true;
}
function openComments(id) {
	win = window.open('comments.php?id='+id, 'comments_window', 'resizable,toolbar=no,location=no,directories=no,status,menubar=no,width=450,height=400,scrollbars');
	win.focus();
}
function validateComments(f) {
	var ok = true;
	var remember = (f.remember_me.checked);
	f.comment.value = f.comment.value.replace(/(^\s*|\s*$)/g, '');
	f.name.value = f.name.value.replace(/(^\s*|\s*$)/g, '');
	f.email_address.value = f.email_address.value.replace(/(^\s*|\s*$)/g, '');
	f.url.value = f.url.value.replace(/(^\s*|\s*$)/g, '');

	if (!f.comment.value.length) {
		alert('You should probably enter a comment before submitting.');
		f.comment.focus();
		ok = false;
	}
	else if (!f.name.value.length) {
		alert('I\'m gonna need your name.');
		f.name.focus();
		ok = false;
	}
	else if (!f.email_address.value.length) {
		alert('Please enter your email address. Don\'t worry, it won\'t be displayed!');
		f.email_address.focus();
		ok = false;
	}
	else if (f.email_address.value.search(/^[^,@\s]+@([a-z0-9\-]+\.)+[a-z0-9]+$/i) == -1) {	
		alert('A valid email address is needed to post. (Don\'t worry, it won\'t be displayed!)');
		f.email_address.focus();
		ok = false;
	}
	else if (f.url.value.length > 0 && (f.url.value.search(/^http:\/\/([a-z0-9\-]+\.)+.+$/i) == -1)) {	
		alert('That doesn\'t look like a valid url.');
		f.url.focus();
		ok = false;
	}

	if (ok && remember) {
		setCommentCookies(f);
	}

	return ok;
}

function setPhotosCookies() {
	document.cookie = 'view_exif='+view_exif+'; path=/; expires=Friday, 01-Jan-2010 00:00:00 GMT';
	document.cookie = 'view_comments='+view_comments+'; path=/; expires=Friday, 01-Jan-2010 00:00:00 GMT';
}

function show_exif() {
	document.all.exif_info.innerHTML = exif_html_view;
	view_exif = 'true';
	setPhotosCookies();
}

function hide_exif() {
	exif_html_view = document.all.exif_info.innerHTML;
	document.all.exif_info.innerHTML = exif_html_hide;
	view_exif = 'false';
	setPhotosCookies();
}

function show_comments() {
	document.all.comment_info.innerHTML = comment_html_view;
	document.forms.comment_submit.name.value = comment_name;
	document.forms.comment_submit.email_address.value = comment_email_address;
	document.forms.comment_submit.url.value = comment_url;
	if (comment_name) {
		document.forms.comment_submit.remember_me.checked = true;
	}
	view_comments = 'true';
	setPhotosCookies();
}

function hide_comments() {
	comment_html_view = document.all.comment_info.innerHTML;
	document.all.comment_info.innerHTML = comment_html_hide;
	view_comments = 'false';
	setPhotosCookies();
}
