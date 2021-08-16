function checkForm(f) {
	var ok = true;
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
		alert('Please enter your email address.');
		f.email_address.focus();
		ok = false;
	}
	else if (f.email_address.value.search(/^[^,@\s]+@([a-z0-9\-]+\.)+[a-z0-9]+$/i) == -1) {	
		alert('A valid email address is needed to post.');
		f.email_address.focus();
		ok = false;
	}
	else if (f.url.value.length > 0 && (f.url.value.search(/^http:\/\/([a-z0-9\-]+\.)+.+$/i) == -1)) {	
		alert('That doesn\'t look like a valid url.');
		f.url.focus();
		ok = false;
	}

	return ok;
}