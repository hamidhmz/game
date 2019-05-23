function addSubMenu(url, parent_id) {
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: {parent_id: parent_id},
        success: function (result) {
            var row = '';
            row += '<div class="row" id="row">';
            row += '	<input type="hidden" name="SubMenu[id][]" value="' + result.id + '"/>';
            row += '	<div class="col-md-2">';
            row += '        <div class="form-group">';
            row += '            <a class="btn btn-block btn-sm" onclick="deleteSubmenu(\'' + result.delete_message + '\', \'' + result.delete_url + '\', ' + result.id + ', ' + result.parent_id + ', this);">حذف</a>';
            row += '        </div>';
            row += '	</div>';
            row += '	<div class="col-md-4">';
            row += '        <div class="form-group">';
            row += '            <input class=\"form-control\" type=\"text\" placeholder=\"عنوان\" name=\"SubMenu[title][]\"/>';
            row += '        </div>';
            row += '	</div>';
            row += '	<div class="col-md-3">';
            row += '        <div class="form-group">';
            row += '            <select class="form-control" name="SubMenu[type_id][]" onchange="changeTypeID(this, \'#page' + result.id + '\', \'#url' + result.id + '\');">';
            row += '                <option value="31">صفحه داخلی</option>';
            row += '                <option value="32">صفحه خارجی</option>';
            row += '            </select>';
            row += '        </div>';
            row += '	</div>';
            row += '	<div class="col-md-3">';
            row += '        <div class="form-group">';
            row += '            <div id="page' + result.id + '" style="display: block;">';
            row += '                <select class="form-control" name="SubMenu[page_id][]">';
            for (var i in result.pages) {
                var item = result.pages[i];
                row += '                <option value="' + item.id + '">' + item.title + '</option>';
            }
            row += '                </select>';
            row += '		</div>';
            row += '		<div id="url' + result.id + '" style="display: none;">';
            row += '		    <input name="SubMenu[url][]" class="form-control" placeholder="لینک خارجی"/>';
            row += '		</div>';
            row += '        </div>';
            row += '	</div>';
            row += '</div>';
            $('#items').append(row);
        }
    });

}
function changeTypeID(that, page_id, url_id) {
    var type_id = parseInt($(that).val());
    if (type_id === 31) {
        $(page_id).css('display', 'block');
        $(url_id).css('display', 'none');
    } else {
        $(page_id).css('display', 'none');
        $(url_id).css('display', 'block');
    }
}
function deleteSubmenu(message, url, id, parent_id, that) {
    if (confirm(message)) {
        $.ajax({
            url: url,
            data: {id: id, parent_id: parent_id},
            success: function (result) {
                if (result && result.rows && result.rows == 1) {
                    $(that).parent().parent().parent().remove();
                }
            }
        });
    }
}