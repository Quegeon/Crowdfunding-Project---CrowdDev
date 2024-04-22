<form action="{{ route('management.proposal.selection', $proposal->id) }}" method="POST" id="companySelectionForm" class="row g-3" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="col-12">
      <label class="form-label">Company</label>
      <select name="id_company" id="company-data" class="form-control">
        <option></option>
        @foreach ($company as $c)
          <option value="{{ $c->id }}">{{ $c->company_name }} ({{ $c->country }}) | Work Field: {{ $c->work_field }}</option>                 
        @endforeach
      </select>
    </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        const select2 = $('#company-data');

        if (select2.length) {
            select2.each(function () {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    dropdownParent: $this.parent(),
                    placeholder: 'Select a Company',
                    allowClear: true
                });
            });
        }

        FormValidation.formValidation(document.getElementById('companySelectionForm'), {
            fields: {
                id_company: {
                    validators: {
                        notEmpty: {
                            message: 'Company field must be filled'
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