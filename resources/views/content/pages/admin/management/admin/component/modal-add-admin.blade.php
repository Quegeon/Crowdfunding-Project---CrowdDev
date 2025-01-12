<div class="modal fade" id="addAdmin" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Create Admin Account</h3>
          <p class="text-muted">Admin account can access all parts of this application.</p>
        </div>
        <form method="POST" action="{{ route('management.admin.store') }}" id="addAdminForm" class="row g-3" autocomplete="off">
          @csrf
          <div class="col-12">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Please Enter A Name" aria-label="Username" aria-describedby="basic-addon11" />
          </div>
          <div class="col-12">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Please Enter A Username" />
          </div>
          <div class="col-12">
            <div class="form-password-toggle">
              <label class="form-label">Password</label>
              <div class="input-group">
                <input type="password" name="password" class="form-control" id="basic-default-password12" placeholder="Please Enter A Password" />
                <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon11">@</span>
              <input type="text" name="email" class="form-control" placeholder="Please Enter An Email Address" aria-describedby="basic-addon11" />
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