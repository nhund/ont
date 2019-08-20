@push('css')

<style type="text/css">
.loader {
    margin: 0 auto;
    border: 5px solid #f3f3f3;
    border-radius: 50%;
    border-top: 5px solid #3498db;
    width: 40px;
    height: 40px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

@endpush
<div class="modal fade" id="importQuestion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Thêm câu hỏi từ excel</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="lesson_id" value="{{ $lesson['id'] }}">  
                {{-- <div class="col-sm-12 row form-group">                            
                    <div class="form-group row">
                        <div class="col-sm-12">Loại câu hỏi</div>
                        <div class="col-sm-12">
                            <select class="form-control" name="type">
                                <option value="{{ \App\Models\Question::TYPE_FLASH_SINGLE }}">FlashCard Đơn</option>
                                <option value="{{ \App\Models\Question::TYPE_FLASH_MUTI }}">FlashCard chuỗi</option>
                                <option value="{{ \App\Models\Question::TYPE_DIEN_TU }}">Điền từ</option>
                                <option value="{{ \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN }}">Điền từ đoạn văn</option>
                                <option value="{{ \App\Models\Question::TYPE_TRAC_NGHIEM }}">Trác nghiệm</option>
                            </select>
                        </div>
                    </div>
                </div> --}}                          
                <input type="file" name="import_excel" class="">
            </div>
            <div class="modal-footer">
                <div class="loader" style="display: none;"></div>
                <div class="box_action">
                    <button type="button" class="btn btn-primary import_save">Lưu</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>    
                </div>                
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
    var import_excel = '{{ route('admin.import.course') }}';
</script>
    <script src="{{ asset('/public/admintrator/assets/js/import.js?ver='.time()) }}"></script>
@endpush