var login_click = function() {
    $('.show_login').hide();
    $('.show_ca').hide();
    $('.login_panel').show();
}
var login_x_click = function() {
    $('.login_panel').hide();
    $('.show_ca').show();
    $('.show_login').show();
}
var ca_click = function() {
    $('.show_login').hide();
    $('.show_ca').hide();
    $('.ca_panel').show();

}
var ca_x_click = function() {
    $('.ca_panel').hide();
    $('.show_login').show();
    $('.show_ca').show();
}