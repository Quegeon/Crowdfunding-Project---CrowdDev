<form method="POST" action="{{ route('management.admin.update.password', $dataId) }}" id="changeAdminPasswordForm" class="row g-3" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <p style="width: 50%" class="mb-0">Current Password : </p>
            <div class="d-flex justify-content-between align-items-center input-group">
                <div id="current_password" class="justify-content-start mb-0">&#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022;</div>
                <div class="input-group-append">
                    <button type="button" id="toggle_visibility" class="btn justify-content-end" data-id="{{ $dataId }}" data-visibility="hide">
                        <i id="icon-visibility" class="fa-regular fa fa-eye-slash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
      <label class="form-label">New Password</label>
      <input type="text" name="new_password" class="form-control" placeholder="Please Enter A New Password" />
    </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>

@vite('resources/assets/js/admin/manage-admin/modal-change-password.js')

<script>
    FormValidation.formValidation(document.getElementById('changeAdminPasswordForm'), {
    fields: {
      new_password: {
        validators: {
          notEmpty: {
            message: 'Password field must be filled'
          },
          stringLength: {
            min: 8,
            max: 20,
            message: 'Password field must be more than 8 and less than 20 characters long'
          },
          regexp: {
            regexp: /^[a-zA-Z0-9]+$/,
            message: 'Password field can only consist of alphabetical and number'
          }
        }
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: '.col-12'
      }),
      autoFocus: new FormValidation.plugins.AutoFocus(),
      submitButton: new FormValidation.plugins.SubmitButton(),
      defaultSubmit: new FormValidation.plugins.DefaultSubmit()
    }
  });
</script>