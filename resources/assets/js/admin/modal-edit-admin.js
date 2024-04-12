        
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
            regexp: /^[a-zA-Zs]+$/,
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