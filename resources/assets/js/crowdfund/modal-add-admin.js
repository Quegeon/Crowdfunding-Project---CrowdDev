/**
 * Edit User
 */

'use strict';

// Select2 (jquery)
$(function () {
  const select2 = $('.select2');

  // Select2 Country
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Select value',
        dropdownParent: $this.parent()
      });
    });
  }
});

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {

    FormValidation.formValidation(document.getElementById('addAdminForm'), {
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
