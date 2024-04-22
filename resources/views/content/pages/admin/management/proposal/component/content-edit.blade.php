<form action="{{ route('management.proposal.update', $proposal->id) }}" method="POST" enctype="multipart/form-data" id="editProposalForm" class="row g-3" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="col-12">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" placeholder="{{ $proposal->title }}" value="{{ $proposal->title }}" />
    </div>
    <div class="col-12">
      <label class="form-label">Client</label>
      <select name="id_user" class="form-control select2">
        <option value="{{ $proposal->id_user }}" selected>Default: {{ $proposal->User->username }}</option>
        @foreach ($client as $c)
          <option value="{{ $c->id }}">{{ $c->username }}</option>                 
        @endforeach
      </select>
    </div>
    <div class="col-12">
      <div class="d-flex justify-content-between align-content-center">
        <label class="form-label">Document</label>
        <p style="width: 90%" class="text-muted small justify-content-start mb-0">( pdf )</p>
      </div>
      <input type="file" name="document" class="form-control" />
    </div>
    @if ($proposal->status == 'Funding')
        <div class="col-12">
            <div class="d-flex justify-content-between align-content-center">
                <label class="form-label">Total</label>
                <p style="width: 90%" class="text-muted small justify-content-start mb-0">( Total Target can't be changed when status is not Funding )</p>
            </div>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon11">Rp</span>
                <input type="text" name="total_target" class="form-control" placeholder="Rp. {{ number_format($proposal->total_target,2,',','.') }}" value="{{ $proposal->total_target }}" aria-describedby="basic-addon11" />
            </div>
        </div>
    @elseif($proposal->status == 'Ongoing')
        <div class="col-12">
            <label class="form-label">Company</label>
            <select name="id_company" class="form-control select2">
                <option value="{{ $proposal->id_company }}" selected>Default: {{ $proposal->Company->company_name }} ({{ $proposal->Company->country }}) | Work Field: {{ $proposal->Company->work_field }}</option>
                @foreach ($company as $c)
                    <option value="{{ $c->id }}">{{ $c->company_name }} ({{ $c->country }}) | Work Field: {{ $c->work_field }}</option>                 
                @endforeach
            </select>
        </div>
    @endif
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
        
        if (@json($proposal->status == 'Funding')) {
            FormValidation.formValidation(document.getElementById('editProposalForm'), {
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
                    id_user: {
                        validators: {
                            notEmpty: {
                                message: 'Client field must be filled'
                            }
                        }
                    },
                    document: {
                        validators: {
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

        } else if (@json($proposal->status == 'Ongoing')) {
            FormValidation.formValidation(document.getElementById('editProposalForm'), {
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
                    id_user: {
                        validators: {
                            notEmpty: {
                                message: 'Client field must be filled'
                            }
                        }
                    },
                    id_company: {
                        validators: {
                            notEmpty: {
                                message: 'Company field must be filled'
                            }
                        }
                    },
                    document: {
                        validators: {
                            file: {
                                extension: 'pdf',
                                type: 'application/pdf',
                                maxSize: '10485760',
                                message: 'Document field input file invalid'
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

        } else {
            FormValidation.formValidation(document.getElementById('editProposalForm'), {
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
                    id_user: {
                        validators: {
                            notEmpty: {
                                message: 'Client field must be filled'
                            }
                        }
                    },
                    document: {
                        validators: {
                            file: {
                                extension: 'pdf',
                                type: 'application/pdf',
                                maxSize: '10485760',
                                message: 'Document field input file invalid'
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
        }
    })
</script>