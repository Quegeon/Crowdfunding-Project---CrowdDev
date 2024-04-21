
'use strict';

$(function () {
  const select2 = $('.select2');

  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        placeholder: 'Select a Value',
        allowClear: true
      });
    });
  }
});

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {

    FormValidation.formValidation(document.getElementById('addFundingForm'), {
      fields: {
        id_proposal: {
          validators: {
            notEmpty: {
              message: 'Proposal field must be filled'
            }
          }
        },
        id_user: {
            validators: {
              notEmpty: {
                message: 'Sponsor field must be filled'
              }
            }
        },
        fund: {
            validators: {
              notEmpty: {
                message: 'Fund field must be filled'
              },
              stringLength: {
                max: 10,
                min: 4,
                message: 'Fund field input must be more than 4 and less than 10 characters long'
              },
              regexp: {
                regexp: /^[0-9]+$/,
                message: 'Fund field input must consist of numbers'
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
  })();
});