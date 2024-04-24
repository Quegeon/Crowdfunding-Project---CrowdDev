<form method="POST" action="{{ route('management.user.update', $user->id) }}" id="editUserForm" class="row g-3" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="col-12">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" placeholder="{{ $user->name }}" value="{{ $user->name }}" />
    </div>
    <div class="col-12">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" placeholder="{{ $user->username }}" value="{{ $user->username }}" />
    </div>
    <div class="col-12">
      <label class="form-label">Email</label>
      <div class="input-group">
        <span class="input-group-text" id="basic-addon11">@</span>
        <input type="text" name="email" class="form-control" placeholder="{{ $user->email }}" value="{{ $user->email }}" aria-describedby="basic-addon11" />
      </div>
    </div>
    <div class="col-12">
        <label class="form-label">Payment Credential</label>
        <input type="text" name="payment_credential" class="form-control" placeholder="Please Enter A New Payment Credential" />
      </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>

<script>
  $(document).ready(function(){
    FormValidation.formValidation(document.getElementById('editUserForm'), {
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
        },
        payment_credential: {
            validators: {
              notEmpty: {
                message: 'Payment Credential field must be filled'
              },
              stringLength: {
                min: 6,
                max: 6,
                message: 'Payment Credential field input must consist of 6 digits'
              },
              regexp: {
                regexp: /^[0-9]+$/,
                message: 'Payment Credential field input must consist of numbers'
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
  })
</script>