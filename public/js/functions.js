var login_click = function() {
    $('.show_login').hide();
    $('.show_ca').hide();
    $('.login').show();
}
var login_x_click = function() {
    $('.login').hide();
    $('.show_ca').show();
    $('.show_login').show();
}
var ca_click = function() {
    $('.show_login').hide();
    $('.show_ca').hide();
    $('.create').show();

}
var ca_x_click = function() {
    $('.create').hide();
    $('.show_login').show();
    $('.show_ca').show();
}