
'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {

    FormValidation.formValidation(document.getElementById('formAuthentication'), {
      fields: {
        password: {
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
  })();
});