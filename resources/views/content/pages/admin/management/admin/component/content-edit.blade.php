
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

<script>      
  FormValidation.formValidation(document.getElementById('editAdminForm'), {
    fields: {
      name: {
        validators: {
          notEmpty: {
            message: 'Name field must be filled'
          },
          stringLength: {
              max: 255,
              message: 'Name field input exceeds the character limit'
          },
          regexp: {
            regexp: /^[a-zA-Zs ]+$/,
            message: 'Name field can only consist of alphabetical'
          }
        }
      },
      username: {
        validators: {
          notEmpty: {
            message: 'Username field must be filled'
          },
          stringLength: {
            min: 6,
            max: 30,
            message: 'Username field input must be more than 6 and less than 30 characters long'
          },
          regexp: {
            regexp: /^[a-zA-Z0-9 ]+$/,
            message: 'Username field can only consist of alphabetical, number and space'
          }
        }
      },
      email: {
        validators: {
          notEmpty: {
            message: 'Email field must be filled'
          },
          stringLength: {
            max: 50,
            message: 'Email field input must be less than 50 characters long'
          },
          emailAddress: {
            message: 'Email field input must be a valid email address'
          }
        }
      }
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