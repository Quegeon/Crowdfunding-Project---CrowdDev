<div class="modal fade" id="addProposal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Create Proposal Data</h3>
          <p class="text-muted">Proposal can be funded and then assigned to a company by voting.</p>
        </div>
        <form action="{{ route('user.proposal.my-proposal.store') }}" method="POST" enctype="multipart/form-data" id="addProposalForm" class="row g-3" autocomplete="off">
          @csrf
          <div class="col-12">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Please Enter A Title" value="{{ old('title') }}" />
          </div>
          <div class="col-12">
            <div class="d-flex justify-content-between align-content-center">
              <label class="form-label">Document</label>
              <p style="width: 90%" class="text-muted small justify-content-start mb-0">( pdf )</p>
            </div>
            <input type="file" name="document" class="form-control" />
          </div>
          <div class="col-12">
            <label class="form-label">Total Target</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon11">Rp</span>
              <input type="text" name="total_target" class="form-control" placeholder="Please Enter A Total Target Fund" value="{{ old('total_target') }}" aria-describedby="basic-addon11" />
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