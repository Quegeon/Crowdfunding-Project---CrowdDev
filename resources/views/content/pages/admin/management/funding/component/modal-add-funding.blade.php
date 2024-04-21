<div class="modal fade" id="addFunding" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Add Funding Data</h3>
        </div>
        <form action="{{ route('management.funding.store') }}" method="POST" id="addFundingForm" class="row g-3" autocomplete="off">
          @csrf
          <div class="col-12">
            <label class="form-label">Proposal</label>
            <select name="id_proposal" class="form-control select2">
              <option></option>
              @foreach ($proposal as $p)
                <option value="{{ $p->id }}">Title: {{ $p->title }} | Funded: Rp. {{ number_format($p->total_funded,2,',','.') }} / Rp. {{ number_format($p->total_target,2,',','.') }}</option>                 
              @endforeach
            </select>
          </div>
          <div class="col-12">
            <label class="form-label">Sponsor</label>
            <select name="id_user" class="form-control select2">
              <option></option>
              @foreach ($user as $u)
                <option value="{{ $u->id }}">{{ $u->username }}</option>                 
              @endforeach
            </select>
          </div>
          <div class="col-12">
            <label class="form-label">Fund</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon11">Rp</span>
              <input type="text" name="fund" class="form-control" placeholder="Please Enter A Fund" value="{{ old('fund') }}" aria-describedby="basic-addon11" />
            </div>
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>