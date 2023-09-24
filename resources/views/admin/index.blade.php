@extends('layouts.admin.index')


@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="javascript:void(0)" class="btn btn-primary" id="createNewprocesse"> new processess</a>

    </div>
    <div class="container">
        <h1>admin processess </h1>
        <form action="">
            <div class="form-inline">
                <div class="form-group">
                    <label for="from_date">From Date:</label>
                    <input type="date" name="FromDateFillter" id="FromDateFillter" class="form-control filter-input m-4" id="from_date">
                </div>
                <div class="form-group">
                    <label for="to_date">To Date:</label>
                    <input type="date" name="toDateFillter" id="toDateFillter" class="form-control filter-input m-4" id="to_date">
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="nameFillter" id="nameFillter" class="form-control filter-input m-4" id="name">
                </div>
                <div class="form-group">
                    <label for="amount">Amount: stats:</label>
                    <input type="number" name="AmountFillter" id="AmountFillter" class="form-control filter-input" id="amount-filter">

                    <select class="form-control filter-input" name="AmountTypeFillter" id="AmountTypeFillter">
                        <option value=">" selected>Greater than</option>
                        <option value="<">Less than</option>
                        <option value="=">Equal to</option>
                    </select>
                </div>
                <div class="form-group">
                    <!-- < id="export" ></a> -->
                    <button  class=" btn btn-primary m-5 "formaction= "{{ route('admin.processessExport') }}" >  export data </button>
                </div>
            </div>
        </form>

        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>user name</th>
                    <th>walletid</th>
                    <th>balance_before</th>
                    <th>balance_after</th>
                    <th>amount_before</th>
                    <th>amount_after</th>
                    <th>tax_value</th>
                    <th>date</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="modelHeading">Modal Title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="processessForm" name="processessForm" class="form-horizontal">
                        @csrf
                        <div class="mb-3">

                            <label for="userSelect" class="form-label">Select User</label>

                            <select id="userSelect" name="userSelect" class="selectpicker border rounded-md with-ajax" data-live-search="true">

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Title" maxlength="50" required>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">tax_value</label>
                            <input type="number" class="form-control" id="tax_value" name="tax_value" min="2" max="100" placeholder="Enter Title" maxlength="50" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.3.8/js/ajax-bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


<script type="text/javascript">
    $(function() {

        /*------------------------------------------
        --------------------------------------------
        Pass Header Token
        --------------------------------------------
        --------------------------------------------*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
    });

    $(document).ready(function() {




        $(".selectpicker").selectpicker();
        $('.modal').on('hidden.bs.modal', function() {
            // Find the .modal-backdrop element and remove the class
            $('.modal-backdrop').removeClass('modal-backdrop fade show');
        });
        $('#createNewprocesse').click(function() {
            
            $('#saveBtn').val("create-processes");
            $('#product_id').val('');
            $('#processessForm').trigger("reset");
            $('#modelHeading').html("Create New processes");
            $("#processessForm").attr('action', "{{ route('admin.store') }}");

            $('.modal').modal('show');
        });

        var user_options = {
            values: "a, b, c",
            ajax: {
                url: "{{ route('admin.getUsers') }}",
                type: "POST",
                dataType: "json",
                data: {
                    q: '@{{{q}}}'
                }
            },

            locale: {
                emptyTitle: 'ابدأ بالكتابة واختار المستخدمين',
                statusInitialized: 'ابدأ بالكتابة واختار المستخدمين',
                searchPlaceholder: 'ابحث',
                statusNoResults: 'لا بوجد نتائج',
                errorText: 'لا يوجد نتائج',
            },
            preprocessData: function(data) {
                var i = 0;
                l = data.length;
                array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push(
                            $.extend(true, data[i], {
                                text: data[i].name,
                                value: data[i].id,
                            })
                        );
                    }
                }

                return array;
            }
        };


        $("#userSelect")
            .selectpicker()
            .filter(".with-ajax")
            .ajaxSelectPicker(user_options);
        $("select").trigger("change");

        $('.selectpicker').selectpicker('refresh');



        $('.filter-input').on('change keyup', function() {
            var nameFillter = $('#nameFillter').val();
            var FromDateFillter = $('#FromDateFillter').val();
            var toDateFillter = $('#toDateFillter').val();
            var AmountFillter = $('#AmountFillter').val();
            var AmountTypeFillter = $("#AmountTypeFillter").val();


            table.ajax.reload();
        });





        getdata();




        $('#saveBtn').click(function(e) {

            var form = $("#processessForm")[0];
            e.preventDefault();
            var data = new FormData(form)
            var url = $("#processessForm").attr('action');

            $.ajax({
                data: data,
                url: url,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    $('#ajaxModel').modal('hide');
                    toastr.success('done');

                    table.ajax.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                    toastr.error(data.responseJSON.message);

                    $('#saveBtn').html('Save Changes');
                }
            });
        });








    });

    var table = $('.data-table').DataTable();

    function getdata() {

        table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('admin.data') }}",
                data: function(d) {
                    d.nameFillter = $('#nameFillter').val();
                    d.FromDateFillter = $('#FromDateFillter').val();
                    d.toDateFillter = $('#toDateFillter').val();
                    d.AmountFillter = $('#AmountFillter').val();
                    d.AmountTypeFillter = $("#AmountTypeFillter").val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'wallet_id',
                    name: 'wallet_id'
                },
                {
                    data: 'balance_before',
                    name: 'balance_before'
                },
                {
                    data: 'balance_after',
                    name: 'balance_after'
                },
                {
                    data: 'amount_before',
                    name: 'amount_before'
                },
                {
                    data: 'amount_after',
                    name: 'amount_after'
                },
                {
                    data: 'tax_value',
                    name: 'tax_value'
                },
                {
                    data: 'date',
                    name: 'date'
                },

            ]
        });

    }
</script>