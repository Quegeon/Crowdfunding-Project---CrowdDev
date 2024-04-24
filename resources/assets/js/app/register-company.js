'use strict';

(function() {
    const wizardIconsModernVertical = document.querySelector('#multiStepsValidation');
  
    if (typeof wizardIconsModernVertical !== undefined && wizardIconsModernVertical !== null) {
      // Wizard form
      const wizardValidationForm = wizardIconsModernVertical.querySelector('#multiStepsForm');
      // Wizard steps
      const wizardValidationFormStep1 = wizardValidationForm.querySelector('#account-details');
      const wizardValidationFormStep2 = wizardValidationForm.querySelector('#company-details');
      const wizardValidationFormStep3 = wizardValidationForm.querySelector('#representative-details');
      // Wizard next prev button
      const wizardValidationNext = [].slice.call(wizardValidationForm.querySelectorAll('.btn-next'));
      const wizardValidationPrev = [].slice.call(wizardValidationForm.querySelectorAll('.btn-prev'));
      const wizardIconsBtnSubmit = wizardValidationForm.querySelector('.btn-submit');
  
      const validationStepper = new Stepper(wizardIconsModernVertical, {
        linear: true
      });
  
      // Account details
      const FormValidation1 = FormValidation.formValidation(wizardValidationFormStep1, {
        fields: {
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
                regexp: /^[a-zA-Z0-9 ]+$/,
                message: 'Password field can only consist of alphabetical and number'
              }
            }
          },
          company_email: {
            validators: {
              notEmpty: {
                message: 'Company Email field must be filled'
              },
              stringLength: {
                max: 50,
                message: 'Company Email field input must be less than 50 characters long'
              },
              emailAddress: {
                message: 'Company Email field input must be a valid email address'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.col-sm-6'
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      }).on('core.form.valid', function () {
        validationStepper.next();
      });
  
      // Personal info
      const FormValidation2 = FormValidation.formValidation(wizardValidationFormStep2, {
        fields: {
          company_name: {
            validators: {
              notEmpty: {
                message: 'Company Name field must be filled'
              },
              stringLength: {
                max: 255,
                message: 'Company Name field input exceeds the character limit'
              },
              regexp: {
                regexp: /^[a-zA-Z0-9 ]+$/,
                message: 'Company Name field can only consist of alphabetical, number and space'
              }
            }
          },
          work_field: {
            validators: {
              stringLength: {
                  max: 255,
                  message: 'Work Fields input exceeds the character limit'
              },
              regexp: {
                regexp: /^[a-zA-Z0-9\s, ]+$/,
                message: 'Name field can only consist of alphabetical'
              }
            }
          },
          country: {
            validators: {
              notEmpty: {
                message: 'Country field must be selected'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.col-sm-6'
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton()
        }
      }).on('core.form.valid', function () {
        validationStepper.next();
      });

      const country = $('.country-data');
      if (country.length) {
        country.each(function () {
          const $this = $(this);
          $this.wrap('<div class="position-relative"></div>');

          $.ajax({
            url: 'https://restcountries.com/v3.1/all',
            dataType: 'json',
            success: function(data) {
                $this.select2({
                  dropdownParent: $this.parent(),
                  placeholder: 'Select a country',
                  allowClear: true,
                  data: data.map(country => ({
                      id: country.name.common,
                      text: country.name.common
                  })),
                  // templateResult: function (data) {
                  //   if (!data.id) { return data.text; }
                  //   return $('<span style="color: #b2366a; background-color: #f9eff3">' + data.text + '</span>');
                  // },
                  // templateSelection: function (data) {
                  //   if (!data.id) { return data.text; }
                  //   return $('<span style="background-color: #f8f7fa">' + data.text + '</span>');
                  // }

                }).on('change', function () {
                    FormValidation2.revalidateField('country');
                });
            },
            error: function(error) {
                console.error('Error fetching countries:', error);
            }
          });
        });
      }
  
      // Social links
      const FormValidation3 = FormValidation.formValidation(wizardValidationFormStep3, {
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
          position: {
            validators: {
              notEmpty: {
                message: 'Position field must be filled'
              },
              stringLength: {
                  max: 50,
                  message: 'Position field input exceeds the character limit'
              },
              regexp: {
                regexp: /^[a-zA-Zs ]+$/,
                message: 'Position field can only consist of alphabetical'
              }
            }
          },
          personal_email: {
            validators: {
              notEmpty: {
                message: 'Personal Email field must be filled'
              },
              stringLength: {
                max: 50,
                message: 'Personal Email field input must be less than 50 characters long'
              },
              emailAddress: {
                message: 'Personal Email field input must be a valid email address'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.col-sm-6'
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton(),
        }
      });

      wizardIconsBtnSubmit.addEventListener('click', event => { 
        const validPromise = FormValidation3.validate();

        validPromise.then((value) => {
          if (value == 'Valid') {
            wizardValidationForm.submit();
          }

        }).catch((error) => {
            console.error(error); // This will log any errors that occur during the Promise execution
        });
      })
  
      wizardValidationNext.forEach(item => {
        item.addEventListener('click', event => {
          switch (validationStepper._currentIndex) {
            case 0:
              FormValidation1.validate();
              break;
  
            case 1:
              FormValidation2.validate();
              break;
  
            case 2:
              FormValidation3.validate();
              break;
  
            default:
              break;
          }
        });
      });
  
      wizardValidationPrev.forEach(item => {
        item.addEventListener('click', event => {
          switch (validationStepper._currentIndex) {
            case 2:
              validationStepper.previous();
              break;
  
            case 1:
              validationStepper.previous();
              break;
  
            case 0:
  
            default:
              break;
          }
        });
      });
    }
})();