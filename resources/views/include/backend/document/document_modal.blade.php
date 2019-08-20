<div class="modal fade" id="delDocument" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-bold">Bạn có chắc chắn muốn xóa ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary delDoc" id-doc="" onclick="delDoc(this)">Xóa</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="handleDocument" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title">Thêm tài liệu</h1>
            </div>
            <form id="handleDocumentForm" method="POST" action="{{ route('document.handle') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id"   id="document_id" value="">
                    <input type="hidden" name="course_id"   value="{{ $course['id'] }}">
                    <input type="hidden" name="_token"      value="{{ csrf_token() }}">
                    <div class="form-group row">
                        <div class="col-sm-3">Tiêu đề</div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Tiêu đề" name="title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">Mô tả</div>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="description" placeholder="Mô tả"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">Avatar</div>
                        <div class="col-sm-9">
                            <input type="file" name="avatar">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">Upload tài liệu</div>
                        <div class="col-sm-9">
                            <input type="file" name="document" id="document">
                        </div>
                    </div>
                    <div class="row">Nội dung</div>
                    <div class="row form-group-sm">
                        <textarea class="ckeditor" name="content" id="content"></textarea>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="ValidForm('handleDocumentForm')">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editDocument" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>