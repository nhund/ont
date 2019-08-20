<div class="modal fade" id="UploadImageQuestion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Thêm ảnh</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="image_url" value="">     
                <img src="" style="width: 100%;">           
                <input type="file" onchange="uploadImage(this)" name="upImage" class="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="appendImageContent(this)">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addImage" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Thêm ảnh</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="image_type" value="">
                <input type="hidden" name="image_position" value="">
                <input type="file" name="upImage" class="upImage">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addImageFlashDon" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Thêm ảnh</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="">
                <input type="hidden" name="postion" value="">                
                <input type="file" name="upImageFlashDon" class="upImageFlashDon">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addImageFlash" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Thêm ảnh</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="">
                <input type="hidden" name="postion" value="">
                <input type="hidden" name="count" value="">
                <input type="file" name="upImageFlash" class="upImageFlash">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addImageTracNghiem" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Thêm ảnh</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="">
                <input type="hidden" name="postion" value="">
                <input type="hidden" name="count" value="">
                <input type="file" name="upImageTn" class="upImageTn">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>
