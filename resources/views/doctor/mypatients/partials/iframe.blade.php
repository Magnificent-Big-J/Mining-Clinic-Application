
<div class="modal-body">
    <iframe src="{{asset($medicalRecord->path)}}" width="100%" height="380" frameborder="0" allowtransparency="true"></iframe>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <a href="{{asset($medicalRecord->path)}}" target="_blank" class="btn btn-primary" download>Download</a>
</div>
