<form method="POST" action="{{ route('user.proposal.my-proposal.fund', $proposal->id) }}" id="addFundingForm" class="row g-3" autocomplete="off">
    @csrf
    <div class="col-12">
        <label class="form-label">Proposal</label>
        <input type="text" class="form-control" value="Title: {{ $proposal->title }} | Funded: Rp. {{ number_format($proposal->total_funded,2,',','.') }} / Rp. {{ number_format($proposal->total_target,2,',','.') }}" disabled />
      </div>
    <div class="col-12">
      <label class="form-label">Fund</label>
      <div class="input-group">
        <span class="input-group-text" id="basic-addon11">Rp</span>
        <input type="text" name="fund" class="form-control" placeholder="Please Enter A Fund" value="{{ old('fund') }}" aria-describedby="basic-addon11" />
      </div>
    </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>

<script>
  $(document).ready(function() {
    FormValidation.formValidation(document.getElementById('addFundingForm'), {
      fields: {
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
  })
</script>