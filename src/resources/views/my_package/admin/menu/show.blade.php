@extends('my_package.layouts.app')

@section('content')
    <div class="p-5 wrapper">
        <div class=""><button id="openCreateModal" class="btn btn-primary">Create <i
                    class="fas fa-plus ml-1 iconSizeEdit"></i></button></div>
        <form action="{{ route('update.menus') }}" method="POST" class="mt-4 w-full text-left rounded-md" id="menu-form">
            @csrf
            <input type="hidden" id="user_id" name="user_id">
            <div id="nestable" class="dd">
                <ol class="dd-list">
                    @foreach ($menus as $menu)
                        @if ($menu->parent_id == null)
                            <li class="dd-item" data-id="{{ $menu->id }}">
                                <div class="d-flex justify-content-between">
                                    <div class="dd-handle" style="text-transform: capitalize">{{ $menu->title }}</div>
                                    <div class="switch_box box_1 ml-3">
                                        <button id="edit_menu" class="btn btn-sm btn-success ml-1"><i
                                                class="fas fa-edit iconSizeEdit"></i></button>
                                        <button id="delete_menu" class="btn btn-sm btn-danger ml-1"><i
                                                class="fas fa-trash iconSizeEdit"></i></button>
                                    </div>
                                </div>
                                @if (count($menu->children) > 0)
                                    <ol class="dd-list">
                                        @foreach ($menu->children as $child)
                                            <li class="dd-item" data-id="{{ $child->id }}">
                                                <div class="d-flex justify-content-between">
                                                    <div class="dd-handle" style="text-transform: capitalize">
                                                        {{ $child->title }}</div>
                                                    <div class="switch_box box_1 ml-3">
                                                        <button id="edit_menu" class="btn btn-sm btn-success ml-1"><i
                                                                class="fas fa-edit iconSizeEdit"></i></button>
                                                        <button id="delete_menu" class="btn btn-sm btn-danger ml-1"><i
                                                                class="fas fa-trash iconSizeEdit"></i></button>
                                                    </div>
                                                </div>
                                                @if (count($child->children) > 0)
                                                    <ol class="dd-list">
                                                        @foreach ($child->children as $subchild)
                                                            <li class="dd-item" data-id="{{ $subchild->id }}">
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="dd-handle"
                                                                        style="text-transform: capitalize">
                                                                        {{ $subchild->title }}</div>
                                                                    <div class="switch_box box_1 ml-3">
                                                                        <button id="edit_menu"
                                                                            class="btn btn-sm btn-success ml-1"><i
                                                                                class="fas fa-edit iconSizeEdit"></i></button>
                                                                        <button id="delete_menu"
                                                                            class="btn btn-sm btn-danger ml-1"><i
                                                                                class="fas fa-trash iconSizeEdit"></i></button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
            <div class="topBg" style="display: none;"><img src="{{ asset('adminPackage/spinner.gif') }}" alt=""></div>
        </form>
    </div>

    <script>
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'mr-4 btn btn-danger'
            },
            buttonsStyling: false
        })
        $('#nestable').nestable({
            group: 1,
            maxDepth: 3
        });

        $('#nestable').on('change', function() {
            var menuOrder = $('#nestable').nestable('serialize');
            var serializedMenu = JSON.stringify(menuOrder);

            $.ajax({
                type: 'POST',
                url: "{{ route('update.menu.order') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    menuOrder: serializedMenu
                },
                success: function(response) {},
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#openCreateModal').click(function() {


            Swal.fire({
                title: 'Create a New Menu',
                text: 'Do you want to continue',
                confirmButtonText: 'Create',
                html: `

                <div class="d-flex justify-content-between">
                        <div class="mb-6 text-left">
                            <label for="text" class="form-label mb-1 text-sm fw-bold text-gray-900">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        <div class="mb-6 text-left">
                            <label for="slug" class="form-label mb-1 text-sm fw-bold text-gray-900">Slug</label>
                            <input type="text" id="slug" name="slug" class="form-control" required>
                        </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <div class="mb-6 text-left">
                        <label for="icon" class="form-label mb-1 text-sm fw-bold text-gray-900">Icon</label>
                        <input type="text" id="icon" name="icon" class="form-control" required>
                    </div>
                    <div class="mb-6 text-left">
                        <label for="path" class="form-label mb-1 text-sm fw-bold text-gray-900">Path</label>
                        <input type="text" id="path" name="path" class="form-control" required>
                    </div>
                </div>
        
       
        <div class="mt-4 text-left">
            <label for="operations" class="form-label mb-1 text-sm fw-bold text-gray-900">Operations</label>
            <div id="operationsContainer">
                <div class="input-group mb-3 flex">
                    <input type="text" id="operations" name="operations[]" class="operations-input form-control">
                    <input type="text" name="key[]" class="ml-5 key-input form-control" placeholder="Key">
                    <button class="btn btn-primary ml-4 add-new-button" type="button" style="width: 100px;"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
    `,
                showCancelButton: true,
                preConfirm: () => {
                    const title = $('#title').val();
                    const slug = $('#slug').val();
                    const icon = $('#icon').val();
                    const path = $('#path').val();
                    const level = $('#level').val();
                    // const operations = [];
                    // console.log(operations)
                    const user_id = $('#user_id').val();
                    const formData = {
                        title: title,
                        slug: slug,
                        icon: icon,
                        path: path,
                        level: level,
                        operations: [],
                        user_id: user_id,
                        _token: '{{ csrf_token() }}'
                    };

                    $('.input-group').each(function(index) {
                        const operationInput = $(this).find('.operations-input');
                        const keyInput = $(this).find('.key-input');
                        if (operationInput && keyInput) {
                            const operation = operationInput.val();
                            const key = keyInput.val();
                            if (operation && key) {
                                const obj = {
                                    title: operation.toLowerCase().trim(),
                                    key: key.trim(),
                                    value: 'true'
                                };
                                formData.operations.push(obj);
                            }
                        }
                    });
                    // console.log(formData.operations);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('store.menu') }}",
                        data: JSON.stringify(formData),
                        contentType: 'application/json',
                        success: function(response) {
                            $('#nestable').empty();
                            $('#nestable').html(response);
                            swalWithBootstrapButtons.fire(
                                'Created',
                                'Menu has been created',
                                'success'
                            )
                        },
                        error: function(error) {
                            console.error('Error submitting the form');
                        }
                    });
                }
            })
        });

        $(document).on('click', '.add-new-button', function() {
            const newInput = `
        <div class="input-group mb-3 flex">
            <input type="text" name="operations[]" class="operations-input form-control">
            <input type="text" name="key[]" class="ml-5 key-input form-control" placeholder="Key">
            <button class="btn btn-danger remove-button ml-4 operations-input" type="button" style="width: 100px;"><i class="fas fa-trash iconSizeEdit"></i></button>
        </div>
    `;
            $('#operationsContainer').append(newInput);
        });

        $(document).on('click', '.remove-button', function() {
            $(this).parent().remove();
        });

        function editMenu(id) {
            $.ajax({
                type: 'GET',
                url: "{{ route('getMenu', '') }}" + "/" + id,
                success: function(response) {
                    const {
                        title,
                        slug,
                        icon,
                        path,
                        level,
                        operations,
                    } = response;
                    let inputs = "";
                    let dataArray = JSON.parse("[" + operations + "]");

                    dataArray.forEach(operation => {
                        operation.forEach(operation => {
                            console.log(operation)
                            inputs += `
                        <div class="input-group mb-2 text-left d-flex justify-content-between" id="${operation.key}-wrapper">
                            <input type="text" name="operations[]" value="${operation.title}" class="operations-input form-control" required>
                                <input type="text" name="keys[]" value="${operation.key}" class="ml-3 key-input form-control" required>
                            <button onclick="removeInput('${operation.key}-wrapper')" type="button" class="btn btn-danger ml-2" style=""><i class="fas fa-trash iconSizeEdit"></i></button>
                        </div>`;
                        })


                    });

                    Swal.fire({
                        title: 'Edit Menu',
                        html: `
<div class="text-left updateForm">


<div class="d-flex justify-content-between">
    <div class="mb-3 text-start">
    <label for="title" class="form-label mb-1 text-sm fw-bold text-gray-900">Title</label>
    <input type="text" id="title" name="title" value="${title}" class="form-control" required>
</div>
<div class="mb-3 text-start">
    <label for="slug" class="form-label mb-1 text-sm fw-bold text-gray-900">Slug</label>
    <input type="text" id="slug" name="slug" value="${slug}" class="form-control" required>
</div>


</div>
<div class="d-flex justify-content-between">
    <div class="mb-3 text-start">
    <label for="icon" class="form-label mb-1 text-sm fw-bold text-gray-900">Icon</label>
    <input type="text" id="icon" name="icon" value="${icon}" class="form-control" required>
</div>
    <div class="mb-3 text-start">
    <label for="path" class="form-label mb-1 text-sm fw-bold text-gray-900">Path</label>
    <input type="text" id="path" name="path" value="${path}" class="form-control" required>
</div>
<div class="mb-3 text-start d-none">
    <label for="level" class="form-label mb-1 text-sm fw-bold text-gray-900">Level</label>
    <input type="text" id="level" name="level" value="${level}" class="form-control" required>
</div>

</div>

<div class="mb-3 text-start" id="operationsContainerUpdate">
    <label for="title" class="form-label mb-1 text-sm fw-bold text-gray-900">Operations</label>
    ${inputs}
</div>    
<div class="text-start">
    <button class="btn btn-primary rounded-md py-2 px-3 text-white text-sm add-new-button-update" style="width:80px;"><i class="fas fa-plus"></i></button>
</div></div>

                `,
                        showCancelButton: true,
                        preConfirm: () => {
                            // const operations = [];
                            // $('.operations-input').each(function() {
                            //     const value = $(this).val().trim();
                            //     if (value) {
                            //         operations.push(value.toLowerCase());
                            //     }
                            // });
                            const updatedData = {
                                title: $('#title').val(),
                                slug: $('#slug').val(),
                                icon: $('#icon').val(),
                                path: $('#path').val(),
                                level: level,
                                operations: []
                            };
                            $('.input-group').each(function(index) {
                                const operationInput = $(this).find('.operations-input');
                                const keyInput = $(this).find('.key-input');
                                if (operationInput && keyInput) {
                                    const operation = operationInput.val();
                                    const key = keyInput.val();
                                    if (operation && key) {
                                        const obj = {
                                            title: operation.toLowerCase().trim(),
                                            key: key.trim(),
                                            value: 'true'
                                        };
                                        updatedData.operations.push(obj);
                                    }
                                }
                            });
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                }
                            });
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('singleMenuUpdate', '') }}" +
                                    "/" + id,
                                data: updatedData,
                                success: function(response) {
                                    // console.log(response)
                                    $('#nestable').empty();
                                    $('#nestable').html(response);
                                    swalWithBootstrapButtons.fire(
                                        'Updated',
                                        'Menu has been updated',
                                        'success'
                                    )
                                },
                                error: function(error) {
                                    console.error(
                                        'Error updating the menu');
                                }
                            });
                        }
                    });
                },
                error: function(error) {
                    console.error('Error fetching menu data');
                }
            });
        }

        function removeInput(id) {
            const elem = document.getElementById(id);
            elem.parentNode.removeChild(elem);
        }

        $(document).on('click', '.add-new-button-update', function() {
            const newInput = `
            <div class="input-group mb-3 d-flex">
            <input type="text" name="operations[]" placeholder="Title" class="operations-input form-control">
            <input type="text" name="key[]" class="ml-3 key-input form-control" placeholder="Key">
            <button class="btn btn-danger remove-button ml-2 operations-input" type="button"><i class="fas fa-trash iconSizeEdit"></i></button>
        </div>
    `;
            $('#operationsContainerUpdate').append(newInput);
        });


        function removeInput(id) {
            const elem = document.getElementById(id);
            elem.parentNode.removeChild(elem);
        }



        function deleteMenu(id) {
            $.ajax({
                type: 'get',
                url: "{{ route('deleteMenu', '') }}" + "/" + id,
                success: function(response) {
                    $('#nestable').empty();
                    $('#nestable').html(response);
                    swalWithBootstrapButtons.fire(
                        'Deleted',
                        'Menu is deleted',
                        'success'
                    )
                }
            });
        }

        $('#menu-form').on('click', '#edit_menu', function(event) {
            event.preventDefault();
            const menuId = $(this).closest('.dd-item').data('id');
            editMenu(menuId);
        });
        $('#menu-form').on('click', '#delete_menu', function(event) {

            event.preventDefault();

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const menuId = $(this).closest('.dd-item').data('id');
                    deleteMenu(menuId);
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })

        });
    </script>
    <style>
        .iconSizeEdit {
            font-size: 12px;
        }

        .wrapper .dd-handle {
            background: white;
            height: 40px;
            display: flex;
            align-items: center;
        }

        .updateForm label {
            font-size: 14px;
        }
    </style>
@endsection
