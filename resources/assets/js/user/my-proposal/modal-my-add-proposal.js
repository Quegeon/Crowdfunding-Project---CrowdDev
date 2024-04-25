
'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {

    FormValidation.formValidation(document.getElementById('addProposalForm'), {
      fields: {
        title: {
          validators: {
            notEmpty: {
              message: 'Title field must be filled'
            },
            stringLength: {
                max: 100,
                min: 6,
                message: 'Title field input must be more than 6 and less than 100 characters long'
            },
            regexp: {
              regexp: /^[a-zA-Z0-9 \-|()&#\[\]]+$/,
              message: 'Title field can only consist of alphabetical, number, space and symbols ( -,|, ( ), &, #, [ ] )'
            }
          }
        },
        document: {
          validators: {
            notEmpty: {
              message: 'Document field must be filled'
            },
            file: {
              extension: 'pdf',
              type: 'application/pdf',
              maxSize: '10485760',
              message: 'Document field input file invalid'
            }
          }
        },
        total_target: {
            validators: {
              notEmpty: {
                message: 'Total Target field must be filled'
              },
              stringLength: {
                max: 10,
                min: 4,
                message: 'Total Target field input must be more than 4 and less than 10 characters long'
              },
              regexp: {
                regexp: /^[0-9]+$/,
                message: 'Total Target field input must consist of numbers'
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