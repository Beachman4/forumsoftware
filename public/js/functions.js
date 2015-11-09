var login_click = function() {
    $('.login_panel').toggle();
}
var login_x_click = function() {
    $('.login_panel').hide();
}
var ca_click = function() {
    $('.ca_panel').toggle();

}
var ca_x_click = function() {
    $('.ca_panel').hide();
}
function edit_post() {
    
    var textarea = "<form method='post' id='edit_post' name='edit_post'><textarea name='edit_post' id='edit_post'></textarea><button class='btn btn-info' name='edit_submit' id='edit_submit' style='float: right;' type='submit'>Edit Post</button></form>";
    var edit = $(this).closest('div').find('#body')
    var divHtml = edit.html(); // notice "this" instead of a specific #myDiv
    var editableText = $("<textarea />");
    editableText.val(divHtml);
    edit.replaceWith(editableText);
    editableText.focus();
    CKEDITOR.replace('edit_post');
}
function addedit() {
    $(this).attr("editing", "1");
    var editing = $("a[_editing='1']").first();
    var body = editing.parent().find('#body');
    var val = body.html();
    var editableText = $("<textarea />");
    editableText.val(val);
    body.replaceWith(editableText);
    editableText.focus();
}