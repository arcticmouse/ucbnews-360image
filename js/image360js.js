// JavaScript Document
var div = document.getElementById('360-image');
var PSV = new PhotoSphereViewer({
	panorama: image_var.image,
	time_anim: 3000, 
	container: div,
	loading_html: image_var.loading_gif,
	navbar: true,
	navbar_style: {
		backgroundColor: 'rgba(0, 50, 98, 0.7)'
	},
	allow_scroll_to_zoom: false,
	anim_speed: image_var.speed,
});

document.addEventListener("DOMContentLoaded", function(event) {
	var to_add = '<p>' + image_var.description + '</p>';
	$('#360-image').append(to_add);
});