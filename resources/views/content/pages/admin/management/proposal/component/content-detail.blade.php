<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" value="{{ $proposal->title }}" disabled />
    </div>
    <div class="col-12">
        <label class="form-label">Client</label>
        <input type="text" class="form-control" value="{{ $proposal->User->username }}" disabled />
    </div>
    <div class="col-12">
        <label class="form-label">Document</label>
        <input type="text" class="form-control" value="{{ $proposal->document }}" disabled />
    </div>
    <div class="col-12">
        <label class="form-label">Total Target</label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon11">Rp</span>
            <input type="text" class="form-control" value="{{ number_format($proposal->total_target,2,',','.') }}" aria-describedby="basic-addon11" disabled />
        </div>
    </div>
    <div class="col-12">
        <label class="form-label">Total Funded</label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon11">Rp</span>
            <input type="text" class="form-control" value="{{ number_format($proposal->total_funded,2,',','.') }}" aria-describedby="basic-addon11" disabled />
        </div>
    </div>
    <div class="col-12">
        @php
            if ($proposal->Company) {
                $content = $proposal->Company->company_name . '( ' . $proposal->Company->country . ' ) | Work Field: ' . $proposal->Company->work_field;
            } else {
                $content = '-';
            }
        @endphp
        <label class="form-label">Company</label>
        <input type="text" class="form-control" value="{{ $content }}" disabled />
    </div>
    <div class="col-12">
        <label class="form-label">Status</label>
        <input type="text" class="form-control" value="{{ $proposal->status }}" disabled />
    </div>
    <div class="col-12 text-center">
        <button type="reset" class="btn btn-label-secondary me-sm-3 me-1" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</div>