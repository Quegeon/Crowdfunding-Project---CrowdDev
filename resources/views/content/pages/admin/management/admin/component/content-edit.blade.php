
<form method="POST" action="{{ route('management.admin.update', $admin->id) }}" id="editAdminForm" class="row g-3" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="col-12">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" placeholder="{{ $admin->name }}" value="{{ $admin->name }}" aria-label="Username" aria-describedby="basic-addon11" />
    </div>
    <div class="col-12">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" placeholder="{{ $admin->username }}" value="{{ $admin->username }}" />
    </div>
    <div class="col-12">
      <label class="form-label">Email</label>
      <div class="input-group">
        <span class="input-group-text" id="basic-addon11">@</span>
        <input type="text" name="email" class="form-control" placeholder="{{ $admin->email }}" value="{{ $admin->email }}" aria-describedby="basic-addon11" />
      </div>
    </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>

@vite([
  'resources/assets/js/admin/manage-admin/modal-edit-admin.js'
])