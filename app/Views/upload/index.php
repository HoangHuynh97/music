<div class="modal fade" id="modalUpload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    	<form action="<?=base_url('/upload/setData')?>" method="POST">
	      <div class="modal-header">
	        <h5 class="modal-title" id="staticBackdropLabel">Cập nhật ca khúc mới</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <div class="input-group">
					  <span class="input-group-text">Tên ca khúc/ID Youtube</span>
					  <input name="nameSong" type="text" aria-label="First name" class="form-control" placeholder="Tên ca khúc">
					  <input name="idYTB" type="text" aria-label="Last name" class="form-control" placeholder="ID Youtube">
					</div>
					<div class="input-group mb-3" style="margin-top: 15px;">
					  <span class="input-group-text" id="inputGroup-sizing-default">Ca sĩ thể hiện</span>
					  <input name="nameSinger" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="Ca sĩ thể hiện">
					</div>
					<div class="input-group mb-3">
					  <label class="input-group-text" for="inputGroupSelect01">Thể loại</label>
					  <select name="idCategory" class="form-select" id="inputGroupSelect01">
					    <option value="vi" selected>Việt Nam</option>
					    <option value="us">US-UK</option>
					    <option value="cn">Trung Quốc</option>
					    <option value="kr">Hàn Quốc</option>
					  </select>
					</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
	        <button type="submit" class="btn btn-primary">Lưu lại</button>
	      </div>
      </form>
    </div>
  </div>
</div>