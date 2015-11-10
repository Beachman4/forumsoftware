var login_click = function() {
    if ($('.ca_panel').is(':visible')) {
        $('.ca_panel').hide();
        $('.login_panel').toggle();
    } else {
        $('.login_panel').toggle();
    }
}
var ca_click = function() {
    if ($('.login_panel').is(':visible')) {
        $('.login_panel').hide();
        $('.ca_panel').toggle();
    } else {
        $('.ca_panel').toggle();
    }
}
function edit_post() {
    
    var textarea = "<form method='post' id='edit_post' name='edit_post'><textarea name='edit_post' id='edit_post'></textarea><button class='btn btn-info' name='edit_submit' id='edit_submit' style='float: right;' type='submit'>Edit Post</button></form>";
    var edit = $(this).closest('div').find('#body')
    var divHtml = edit.html();
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