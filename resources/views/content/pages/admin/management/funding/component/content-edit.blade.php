<form action="{{ route('management.funding.update', $funding->id) }}" method="POST" id="editFundingForm" class="row g-3" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="col-12">
      <label class="form-label">Proposal</label>
      <select name="id_proposal" class="form-control select2">
        <option value="{{ $funding->id_proposal }}" selected>Default: {{ $funding->Proposal->title }}</option>
        @foreach ($proposal as $p)
          <option value="{{ $p->id }}">Title: {{ $p->title }} | Funded: Rp. {{ number_format($p->total_funded,2,',','.') }} / Rp. {{ number_format($p->total_target,2,',','.') }}</option>                 
        @endforeach
      </select>
    </div>
    <div class="col-12">
      <label class="form-label">Sponsor</label>
      <select name="id_user" class="form-control select2">
        <option value="{{ $funding->id_user }}" selected>Default: {{ $funding->User->username }}</option>
        @foreach ($user as $u)
          <option value="{{ $u->id }}">{{ $u->username }}</option>                 
        @endforeach
      </select>
    </div>
    <div class="col-12">
      <label class="form-label">Fund</label>
      <div class="input-group">
        <span class="input-group-text" id="basic-addon11">Rp</span>
        <input type="text" name="fund" class="form-control" placeholder="Rp. {{ number_format($funding->fund,2,',','.') }}" value="{{ $funding->fund }}" aria-describedby="basic-addon11" />
      </div>
    </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>

<script>
    $(document).ready(function() {
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

        FormValidation.formValidation(document.getElementById('editFundingForm'), {
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
    })
</script>