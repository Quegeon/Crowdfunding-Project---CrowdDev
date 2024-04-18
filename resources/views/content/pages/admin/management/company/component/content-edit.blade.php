<div id="edit-company-wizard" class="bs-stepper vertical wizard-modern mt-2">
    <div class="bs-stepper-header">
      <div class="step" data-target="#account-details">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">
            <i class="ti ti-file-description"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Account Details</span>
          </span>
        </button>
      </div>
      <div class="line"></div>
      <div class="step" data-target="#company-details">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">
            <i class="ti ti-user"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Company Details</span>
          </span>
        </button>
      </div>
      <div class="line"></div>
      <div class="step" data-target="#representative-details">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Representative Details</span>
          </span>
        </button>
      </div>
    </div>
    <div class="bs-stepper-content">
      <form action="{{ route('management.company.update', $company->id) }}" method="POST" id="editCompanyForm" onSubmit="return false" autocomplete="off">
        @csrf
        @method('PUT')
        <div id="account-details" class="content">
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" placeholder="{{ $company->username }}" value="{{ $company->username }}" />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Company Email</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon11">@</span>
                <input type="text" id="company_email" name="company_email" class="form-control" placeholder="{{ $company->company_email }}" value="{{ $company->company_email }}" aria-describedby="basic-addon11" />
              </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
              <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
            </div>
          </div>
        </div>
        <div id="company-details" class="content">
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label">Company Name</label>
              <input type="text" name="company_name" class="form-control" placeholder="{{ $company->company_name }}" value="{{ $company->company_name }}" />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Work Fields</label>
              <input type="text" name="work_field" class="form-control" placeholder="{{ $company->work_field }}" value="{{ $company->work_field }}" />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Country</label>
              <select name="country" class="country-data">
                <option value="{{ $company->country }}" selected>Default: {{ $company->country }}</option>
              </select>
            </div>
            <div class="col-sm-12">
              <label class="form-label">Company Description</label>
              <textarea name="company_description" class="form-control" rows="5" maxlength="255" placeholder="{{ $company->company_description }}">{{ $company->company_description }}</textarea>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
            </div>
          </div>
        </div>
        <div id="representative-details" class="content">
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" placeholder="{{ $company->name }}" value="{{ $company->name }}" />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Position</label>
              <input type="text" name="position" class="form-control" placeholder="{{ $company->position }}" value="{{ $company->position }}" />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Personal Email</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon11">@</span>
                <input type="text" name="personal_email" class="form-control" placeholder="{{ $company->personal_email }}" value="{{ $company->personal_email }}" aria-describedby="basic-addon11" />
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-outline-success bg-label-success btn-submit">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        const wizardIconsModernVertical = document.querySelector('#edit-company-wizard');
  
        if (typeof wizardIconsModernVertical !== undefined && wizardIconsModernVertical !== null) {
            const wizardValidationForm = wizardIconsModernVertical.querySelector('#editCompanyForm');

            const wizardValidationFormStep1 = wizardValidationForm.querySelector('#account-details');
            const wizardValidationFormStep2 = wizardValidationForm.querySelector('#company-details');
            const wizardValidationFormStep3 = wizardValidationForm.querySelector('#representative-details');

            const wizardValidationNext = [].slice.call(wizardValidationForm.querySelectorAll('.btn-next'));
            const wizardValidationPrev = [].slice.call(wizardValidationForm.querySelectorAll('.btn-prev'));
            const wizardIconsBtnSubmit = wizardValidationForm.querySelector('.btn-submit');
        
            const validationStepper = new Stepper(wizardIconsModernVertical, {
                linear: true
            });
        
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
                        },
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
            });
        
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
    })
</script>