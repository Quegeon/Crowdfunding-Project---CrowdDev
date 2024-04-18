<div id="detail-company-wizard" class="bs-stepper vertical wizard-modern mt-2">
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
      <form onSubmit="return false">
        <div id="account-details" class="content">
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" value="{{ $company->username }}" disabled />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Company Email</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon11">@</span>
                <input type="text" id="company_email" class="form-control" value="{{ $company->company_email }}" aria-describedby="basic-addon11" disabled />
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
              <input type="text" class="form-control" value="{{ $company->company_name }}" disabled />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Work Fields</label>
              <input type="text" class="form-control" value="{{ $company->work_field }}" disabled />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Country</label>
              <input type="text" class="form-control" value="{{ $company->country }}" disabled />
            </div>
            <div class="col-sm-12">
              <label class="form-label">Company Description</label>
              <textarea class="form-control" rows="5" disabled>{{ $company->company_description }}</textarea>
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
              <input type="text" class="form-control" value="{{ $company->name }}" disabled />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Position</label>
              <input type="text" class="form-control" value="{{ $company->position }}" disabled />
            </div>
            <div class="col-sm-6">
              <label class="form-label">Personal Email</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon11">@</span>
                <input type="text" class="form-control" value="{{ $company->personal_email }}" aria-describedby="basic-addon11" disabled />
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
</div>

<script>
  $(document).ready(function(){
    const wizardIconsModernVertical = document.querySelector('#detail-company-wizard');

    if (typeof wizardIconsModernVertical !== undefined && wizardIconsModernVertical !== null) {
        const wizardIconsModernVerticalBtnNextList = [].slice.call(wizardIconsModernVertical.querySelectorAll('.btn-next')),
            wizardIconsModernVerticalBtnPrevList = [].slice.call(wizardIconsModernVertical.querySelectorAll('.btn-prev'));

        const verticalModernIconsStepper = new Stepper(wizardIconsModernVertical, {
            linear: false
        });

        if (wizardIconsModernVerticalBtnNextList) {
            wizardIconsModernVerticalBtnNextList.forEach(wizardIconsModernVerticalBtnNext => {
                wizardIconsModernVerticalBtnNext.addEventListener('click', event => {
                    verticalModernIconsStepper.next();
                });
            });
        }
        if (wizardIconsModernVerticalBtnPrevList) {
            wizardIconsModernVerticalBtnPrevList.forEach(wizardIconsModernVerticalBtnPrev => {
                wizardIconsModernVerticalBtnPrev.addEventListener('click', event => {
                    verticalModernIconsStepper.previous();
                });
            });
        }
    }
  })
</script>
