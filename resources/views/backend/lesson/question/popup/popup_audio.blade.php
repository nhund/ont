@push('css')

<style type="text/css">
#editorQuestion .modal-dialog{
    width: 70%;
}
</style>

@endpush

<div class="modal fade" id="UploadAudioQuestion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Tải lên audio</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="lesson_id" value="">  
                <div class="col-sm-12 row form-group">                            
                    <div class="form-group row">
                        <input type="hidden" name="audio_url" value="">
                        <input type="file" onchange="uploadAudio(this)" name="uploadAudio" class="uploadAudio">
                        {{-- <audio controls>
                            <source src="{{ asset('public/file/audio/1/SampleAudio_0.4mb.mp3') }}">
                        </audio> --}}
                    </div>
                </div>                                          
            </div>
            <div class="modal-footer">
                <div class="loader" style="display: none;"></div>
                <div class="box_action">
                    <button type="button" class="btn btn-primary" onclick="appendAudioContent(this)">Lưu</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>    
                </div>                
            </div>
        </div>
    </div>
</div>
@push('js')

<script type="text/javascript">
    $(document).ready(function() {

    });

</script>
@endpush