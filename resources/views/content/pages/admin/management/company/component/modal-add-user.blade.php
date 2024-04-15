<div class="modal fade" id="addCompany" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="mb-2">Create Company Account</h3>
            <p class="text-muted">Company accounts consist of two pieces of data: Company Representative data and The Company data itself.</p>
          </div>
          <div class="col-12">
            <div id="add-company-wizard" class="bs-stepper vertical wizard-modern mt-2">
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
                <form action="{{ route('management.company.store') }}" method="POST" id="addCompanyForm" onSubmit="return false" autocomplete="off">
                  @csrf
                  <!-- Account Details -->
                  <div id="account-details" class="content">
                    <div class="row g-3">
                      <div class="col-sm-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Please Enter A Username" value="{{ old('username') }}" />
                      </div>
                      <div class="col-sm-6 form-password-toggle">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-merge">
                          <input type="password" name="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                          <span class="input-group-text cursor-pointer" id="password-modern-vertical1"><i class="ti ti-eye-off"></i></span>
                        </div>
                      </div>
                      <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
                      </div>
                    </div>
                  </div>
                  <!-- Company Details -->
                  <div id="company-details" class="content">
                    <div class="row g-3">
                      <div class="col-sm-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control" placeholder="Please Enter A Company Name" value="{{ old('company_name') }}" />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label">Work Fields</label>
                        <input type="text" name="work_field" class="form-control" placeholder="Please Enter Working Fields Of Company" value="{{ old('work_field') }}" />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label">Country</label>
                        <select name="country" id="country-data">
                          <option></option>
                        </select>
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label">Company Email</label>
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon11">@</span>
                          <input type="text" id="company_email" name="company_email" class="form-control" placeholder="Please Enter An Email Address" value="{{ old('company_email') }}" aria-describedby="basic-addon11" />
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <label class="form-label">Company Description</label>
                        <textarea name="company_description" class="form-control" rows="5" maxlength="255" placeholder="Please Enter Company Descriptions">{{ old('company_description') }}</textarea>
                      </div>
                      <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
                      </div>
                    </div>
                  </div>
                  <!-- Representative Details -->
                  <div id="representative-details" class="content">
                    <div class="row g-3">
                      <div class="col-sm-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Please Enter A Name" value="{{ old('name') }}" />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label">Position</label>
                        <input type="text" name="position" class="form-control" placeholder="Please Enter A Position" value="{{ old('position') }}" />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label">Personal Email</label>
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon11">@</span>
                          <input type="text" name="personal_email" class="form-control" placeholder="Please Enter An Email Address" value="{{ old('personal_email') }}" aria-describedby="basic-addon11" />
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
          </div>
        </div>
      </div>
    </div>
  </div>