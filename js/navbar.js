const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
if(urlParams.has('home') || urlParams.toString().trim().length === 0) {
    $('#nav-home').addClass('active');
}else if(urlParams.has('news')) {
    $('#nav-news').addClass('active');
}else if(urlParams.has('favoriten')) {
    $('#nav-favoriten').addClass('active');
}  


 