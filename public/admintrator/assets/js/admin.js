function number_format(Num) {
    Num = Num.toString().replace(/^0+/, "").replace(/\./g, "").replace(/,/g, "");
    Num = "" + parseInt(Num);
    var temp1 = "";
    var temp2 = "";
    if (Num == 0 || Num == undefined || Num == '0' || Num == '' || isNaN(Num)) {
        return '';
    }
    else {
        var count = 0;
        for (var k = Num.length - 1; k >= 0; k--) {
            var oneChar = Num.charAt(k);
            if (count == 3) {
                temp1 += ".";
                temp1 += oneChar;
                count = 1;
                continue;
            }
            else {
                temp1 += oneChar;
                count++;
            }
        }
        for (var k = temp1.length - 1; k >= 0; k--) {
            var oneChar = temp1.charAt(k);
            temp2 += oneChar;
        }
        return temp2;
    }
}

function showErrorMsg (msg) {
    $.notify({
        icon: 'fa fa-warning',
        title: 'Lỗi!',
        message: msg
    },{
        element: 'body',
        position: null,
        type: "danger",
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "center"
        },
        offset: 20,
        spacing: 10,
        z_index: 9999,
        delay: 3000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class'
    });
}

function showSuccessMsg (msg) {
    $.notify({
        icon: 'fa fa-success',
        title: 'Thông báo : ',
        message: msg
    },{
        element: 'body',
        position: null,
        type: "success",
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "center"
        },
        offset: 20,
        spacing: 10,
        z_index: 9999,
        delay: 3000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class'
    });
}

function showModalAddLesson(lesson_id, title) {
    if (lesson_id) {
        $('#lesson_id').val(lesson_id);
    }
    $('.title-courseLesson').html(title);
    $('#courseLesson').modal('show');
}

function showModalAddExersice(lesson_id) {
    if (lesson_id) {
         $('#les_id').val(lesson_id);
    }
    $('#courseEx').modal('show');
}

function showModalAddExam(lesson_id) {
    if (lesson_id) {
         $('#les_id').val(lesson_id);
    }
    $('#courseEx').modal('show');
}

function addRowLesson() {
    var html = '<div class="form-group row">\n' +
        '                        <div class="col-sm-5">\n' +
        '                            <input type="text" class="form-control lessonName" placeholder="#Lesson name" name="name[]">\n' +
        '                        </div>\n' +
        '                        <div class="col-sm-5">\n' +
        '                            <select class="form-control" name="status[]">\n' +
        '                                <option value="1">Public</option>\n' +
        '                                <option value="2">Private</option>\n' +
        '                                <option value="3">Deleted</option>\n' +
        '                            </select>\n' +
        '                        </div>\n' +
        '                        <div class="col-sm-2">\n' +
        '                            <a class="color-red" onclick="deleteRow(this)">Xóa</a>\n' +
        '                        </div>\n' +
        '                    </div>';
    $('#courseLesson .modal-body .form-group:last').before(html);
}

function deleteRow(dom) {
    $(dom).parent().parent().remove();
}

function addLesson() {
    var len = $(".lessonName").length;
    if (!len) {
        $('#courseLesson').modal('hide');
        return false;
    }

    var exit = false;
    $("#addCourseLesson .lessonName").each(function (index, ele) {
        if ($.trim(ele.value) == '') {
            exit = true;
            showErrorMsg('Vui lòng nhập tên');
            return false;
        }
    });

    if (exit) {
        return false;
    }

    var serialise = $( "form#addCourseLesson" ).serialize();
    $.ajax({
        url: '/admin/course/addLesson',
        data: serialise,
        dataType: 'json',
        method: 'POST',
        success: function (response) {
            if (response.status) {
                window.location.href = '/admin/lesson/'+response.id;
            }
        }
    });
}

function handleLessonForm() {
    var textarea = $('#editor').val();  
            CKEDITOR.instances['editor'].setData(textarea);   
    $('.change-lesson-des').toggle();
    $('.add-lesson-des').toggle();
    $('.pdes').toggle();
}


function saveDesLesson() {
    //CKEDITOR.instances['editor_format'].updateElement();
    var name        = $.trim($('input[name="lname"]').val());
    //validate
    if (name == '') {
        showErrorMsg('Vui lòng nhập tên');
        return false;
    }
    $('#editDesLesson').submit();
}

function ValidExForm(form) {
    CKEDITOR.instances.exDescription.updateElement();
    var name        = $.trim($('#'+form+' input[name="exName"]').val());
    var file        = $('#avatar').val().toLowerCase();
    //validate
    if (name == '') {
        showErrorMsg('Vui lòng nhập tên');
        return false;
    }
    if (file) {
        var extension = file.substring(file.lastIndexOf('.') + 1);
        var size     = $("#avatar")[0].files[0].size;
        if ($.inArray(extension, ['jpg', 'png', 'jpeg']) == -1 || size > 1048576) {
            showErrorMsg('File phải có định dạng jpg, jpeg, png và dung lượng dưới 1MB');
            return false;
        }
    }

    $('form#'+form).submit();
}

function ValidForm(form) {
    CKEDITOR.instances.content.updateElement();
    var title        = $.trim($('#'+form+' input[name="title"]').val());
    var file         = $('#'+form+' input[name="avatar"]').val();
    var document     = $('#'+form+' input[name="document"]').val();
    var text_document     = $.trim($('#'+form+' input[name="text_document"]').val());
    //validate
    if (title == '') {
        showErrorMsg('Vui lòng nhập tiêu đề');
        return false;
    }
    if (file) {
        var extension = file.substring(file.lastIndexOf('.') + 1);
        var size     = $('#'+form+' input[name="avatar"]')[0].files[0].size;
        if ($.inArray(extension, ['jpg', 'png', 'jpeg']) == -1 || size > 1048576) {
            showErrorMsg('File phải có định dạng jpg, jpeg, png và dung lượng dưới 1MB');
            return false;
        }
    }
    if (!document && !text_document) {
        showErrorMsg('Vui lòng up tài liệu');
        return false;
    }

    $('form#'+form).submit();
}

function addUser() {
    var email        = $.trim($('form#addUserForm input[name="email"]').val());
    //validate
    if (email == '') {
        showErrorMsg('Vui lòng nhập email');
        return false;
    }
    var serialise = $( "form#addUserForm" ).serialize();
    $.ajax({
        url: '/admin/course/addUser',
        data: serialise,
        dataType: 'json',
        method: 'POST',
        success: function (response) {
            if (response.status) {
                window.location.reload();
            } else {
                showErrorMsg(response.msg);
                return false;
            }
        }
    });
}

function addComment(e, parent_id, course_id) {
    var token   = $('meta[name=csrf-token]').attr("content");
    var content = $(e).parent().parent().find('input[name="comment_content"]').val();
    $.ajax({
        url: '/course/comment/add',
        data: {_token: token, content: content, parent_id: parent_id, course_id: course_id},
        dataType: 'json',
        method: 'POST',
        success: function (response) {
            if (response.error) {
                showErrorMsg(response.message)
            } else {
                showSuccessMsg(response.message);
                $('#comments-list').append(response.template);
            }
        }
    });
}
