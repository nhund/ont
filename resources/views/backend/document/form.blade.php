<div class="modal-header text-center">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h1 class="modal-title">Sửa tài liệu</h1>
</div>
<form id="editDocumentForm" method="POST" action="{{ route('document.handle') }}" enctype="multipart/form-data">
    <div class="modal-body">
        <input type="hidden" name="id"   id="document_id" value="{{ $document->id }}">
        <input type="hidden" name="course_id"   value="{{ $document->course_id }}">
        <input type="hidden" name="_token"      value="{{ csrf_token() }}">
        <div class="form-group row">
            <div class="col-sm-3">Tiêu đề</div>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="Tiêu đề" name="title" value="{{ $document->title }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3">Mô tả</div>
            <div class="col-sm-9">
                <textarea class="form-control" name="description" placeholder="Mô tả">{{ $document->description }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">Avatar</div>
            <div class="col-sm-9" style="padding: 0">
                <div class="col-sm-4" >
                    <input type="file" name="avatar" id="avatar">
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="text_avatar" @if($document->avatar)value="{{ Request::root().'/public/document/avatar/'.$document->avatar }}"@endif>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">Upload tài liệu</div>
            <div class="col-sm-9" style="padding: 0">
                <div class="col-sm-4" >
                    <input type="file" name="document">
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="text_document" @if($document->document)value="{{ Request::root().'/public/document/file/'.$document->document }}"@endif>
                </div>
            </div>
        </div>
        <div class="row">Nội dung</div>
        <div class="row form-group-sm">
            <textarea class="ckeditor" name="content" id="ckeditor">{{ $document->content }}</textarea>
        </div>
    </div>
</form>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="ValidForm('editDocumentForm')">Lưu</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
</div>