<div id="detail-proposal-wizard" class="bs-stepper vertical wizard-modern mt-2">
    <div class="bs-stepper-header">
      <div class="step" data-target="#proposal-details">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">
            <i class="ti ti-files"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Proposal Details</span>
          </span>
        </button>
      </div>
      <div class="line"></div>
      <div class="step" data-target="#funding-details">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle">
            <i class="ti ti-wallet"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Funding Details</span>
          </span>
        </button>
      </div>
      <div class="line"></div>
      <div class="step" data-target="#voting-details">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-circle"><i class="ti ti-check"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Voting Details</span>
          </span>
        </button>
      </div>
    </div>
    <div class="bs-stepper-content">
      <form onSubmit="return false">
        <div id="proposal-details" class="content">
          <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" value="{{ $proposal->title }}" disabled />
            </div>
            <div class="col-sm-6">
                <label class="form-label">Document</label>
                <input type="text" class="form-control" value="{{ $proposal->document }}" disabled />
            </div>
            <div class="col-sm-6">
                <label class="form-label">Total Target</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon11">Rp</span>
                    <input type="text" class="form-control" value="{{ number_format($proposal->total_target,2,',','.') }}" aria-describedby="basic-addon11" disabled />
                </div>
            </div>
            <div class="col-sm-6">
                <label class="form-label">Total Funded</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon11">Rp</span>
                    <input type="text" class="form-control" value="{{ number_format($proposal->total_funded,2,',','.') }}" aria-describedby="basic-addon11" disabled />
                </div>
            </div>
            <div class="col-sm-6">
                @php
                    if ($proposal->Company) {
                        $content = $proposal->Company->company_name . '( ' . $proposal->Company->country . ' ) | Work Field: ' . $proposal->Company->work_field;
                    } else {
                        $content = '-';
                    }
                @endphp
                <label class="form-label">Company</label>
                <input type="text" class="form-control" value="{{ $content }}" disabled />
            </div>
            <div class="col-12 d-flex justify-content-end">
              <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
            </div>
          </div>
        </div>
        <div id="funding-details" class="content">
          <div class="row g-3">
            <div class="col-sm-12">
              <table class="table modal-datatable">
                <thead class="table-primary">
                  <tr>
                    <th>#</th>
                    <th>Sponsor</th>
                    <th>Fund</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  @foreach ($funding as $f)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $f->User->username }}</td>
                      <td>Rp. {{ number_format($f->fund,2,',','.') }}</td>
                      <td>{{ $f->created_at->toDateString() }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span> <i class="ti ti-arrow-right"></i></button>
            </div>
          </div>
        </div>
        <div id="voting-details" class="content">
          <div class="row g-3">
            <div class="col-sm-12">
              <table class="table modal-datatable">
                <thead class="table-primary">
                  <tr>
                    <th>#</th>
                    <th>Participant</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th class="text-center">Vote</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  @foreach ($vote as $v)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $v->User->username }}</td>
                      <td>{{ $v->Company->company_name }}</td>
                      <td>{{ $f->created_at->toDateString() }}</td>
                      <td class="text-center">
                        @if ($v->is_reject)
                          <span class="badge bg-label-danger text-center">Reject</span>
                        @else
                          <span class="badge bg-label-success text-center">Approve</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
    const wizardIconsModernVertical = document.querySelector('#detail-proposal-wizard');

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
