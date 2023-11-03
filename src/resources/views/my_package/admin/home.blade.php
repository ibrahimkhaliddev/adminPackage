@extends('my_package.layouts.app')


@section('content')
    {{-- <section class="flex">
        <div class="container mx-auto text-center py-5">
            <div class="flex justify-between">
                <select id="userSelect" class="border border-black px-10 rounded-sm">
                    <option value="1" selected disabled>Admin</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" class="capitalize">{{ $user->name }}</option>
                    @endforeach
                </select>
                <button id="openCreateModal" class="bg-blue-500 rounded-md px-3 py-1 text-white">Create</button>
            </div>
    
            <form action="{{ route('update.menus') }}" method="POST"
                class="mt-10 w-full text-left border border-black p-5 rounded-md" id="menu-form">
                @csrf
                <input type="hidden" id="user_id" name="user_id">
                <div id="nestable" class="dd">
                    <ol class="dd-list">
                        @foreach ($menus as $menu)
                            @if ($menu->parent_id == null)
                                <li class="dd-item" data-id="{{ $menu->id }}">
                                    <div class="flex justify-between">
                                        <div class="dd-handle" style="text-transform: capitalize">{{ $menu->title }}</div>
                                        <div class="switch_box box_1 ml-3">
                                            <input type="checkbox" checked name="menus[]" value="{{ $menu->id }}"
                                                class="switch_1">
                                            <button id="edit_menu"
                                                class="ml-3 text-white bg-green-400 rounded-full px-2">Edit</button>
                                            <button id="delete_menu"
                                                class="ml-3 text-white bg-red-400 rounded-full px-2">Delete</button>
                                        </div>
                                    </div>
                                    @if (count($menu->children) > 0)
                                        <ol class="dd-list ml-5">
                                            @foreach ($menu->children as $child)
                                                <li class="dd-item" data-id="{{ $child->id }}">
                                                    <div class="flex justify-between">
                                                        <div class="dd-handle" style="text-transform: capitalize">
                                                            {{ $child->title }}</div>
                                                        <div class="switch_box box_1 ml-3">
                                                            <input type="checkbox" checked name="menus[]"
                                                                value="{{ $child->id }}" class="switch_1">
                                                            <button id="edit_menu"
                                                                class="ml-3 text-white bg-green-400 rounded-full px-2">Edit</button>
                                                            <button id="delete_menu"
                                                                class="ml-3 text-white bg-red-400 rounded-full px-2">Delete</button>
                                                        </div>
                                                    </div>
                                                    @if (count($child->children) > 0)
                                                        <ol class="dd-list ml-5">
                                                            @foreach ($child->children as $subchild)
                                                                <li class="dd-item" data-id="{{ $subchild->id }}">
                                                                    <div class="flex justify-between">
                                                                        <div class="dd-handle"
                                                                            style="text-transform: capitalize">
                                                                            {{ $subchild->title }}</div>
                                                                        <div class="switch_box box_1 ml-3">
                                                                            <input type="checkbox" checked name="menus[]"
                                                                                value="{{ $subchild->id }}" class="switch_1">
                                                                            <button id="edit_menu"
                                                                                class="ml-3 text-white bg-green-400 rounded-full px-2">Edit</button>
                                                                            <button id="delete_menu"
                                                                                class="ml-3 text-white bg-red-400 rounded-full px-2">Delete</button>
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
    </section> --}}
    
    <script>
        // $(document).ready(function(){

        
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'bg-green-500 px-5 py-2 rounded-md text-white',
                cancelButton: 'mr-4 bg-red-500 px-5 py-2 rounded-md text-white'
            },
            buttonsStyling: false
        })
//         $('#openCreateModal').click(function() {


//             Swal.fire({
//                 title: 'Create a New Menu',
//                 text: 'Do you want to continue',
//                 confirmButtonText: 'Create',
//                 html: `
// <div class="mb-6 text-left mt-5">
// <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
// <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
// </div>
// <div class="mb-6 text-left">
// <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
// <input type="text" id="slug" name="slug" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
// </div>
// <div class="mb-6 text-left">
// <label for="icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Icon</label>
// <input type="text" id="icon" name="icon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
// </div>
// <div class="mb-6 text-left">
// <label for="path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Path</label>
// <input type="text" id="path" name="path" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
// </div>
// `,
//                 showCancelButton: true,
//                 preConfirm: () => {
//                     const title = $('#title').val();
//                     const slug = $('#slug').val();
//                     const icon = $('#icon').val();
//                     const path = $('#path').val();
//                     const level = $('#level').val();
//                     const user_id = $('#user_id').val();
//                     const formData = {
//                         title: title,
//                         slug: slug,
//                         icon: icon,
//                         path: path,
//                         level: level,
//                         user_id: user_id,
//                         _token: '{{ csrf_token() }}'
//                     };

//                     $.ajaxSetup({
//                         headers: {
//                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                         }
//                     });

//                     $.ajax({
//                         type: 'POST',
//                         url: "{{ route('store.menu') }}",
//                         data: JSON.stringify(formData),
//                         contentType: 'application/json',
//                         success: function(response) {
//                             $('#nestable').empty();
//                             $('#nestable').html(response);
//                             swalWithBootstrapButtons.fire(
//                                 'Created',
//                                 'Menu has been created',
//                                 'success'
//                             )
//                         },
//                         error: function(error) {
//                             console.error('Error submitting the form');
//                         }
//                     });
//                 }
//             });

//         })
        $(document).ready(function() {
            // $('input[type="checkbox"]').on('change', function() {
            //     var formData = $('#menu-form').serialize();
            //     $.ajax({
            //         type: 'POST',
            //         url: $('#menu-form').attr('action'),
            //         data: formData,
            //         success: function(response) {
            //             console.log('Form submitted successfully');
            //         },
            //         error: function(error) {
            //             console.error('Error submitting the form');
            //         }
            //     });
            // });
            // $('#nestable').nestable({
            //     group: 1,
            //     maxDepth: 3
            // });

            // $('#userSelect').change(function() {
            //     var userId = $(this).val();
            //     $('.topBg').show();
            //     $('input[type="checkbox"]').prop('checked', false);
            //     if (userId !== '') {
            //         $.ajax({
            //             url: '/admin/get-user-menus/' + userId,
            //             type: 'GET',
            //             success: function(data) {
            //                 console.log(data)
            //                 $('#user_id').val(userId);
            //                 $('#userMenus').empty();
            //                 data.forEach(function(menu) {
            //                     $('input[value="' + menu.id + '"]').prop('checked',
            //                         true);
            //                 });
            //                 $('.topBg').hide();
            //             },
            //             error: function(error) {
            //                 console.log(error);
            //             }
            //         });
            //     } else {
            //         $('#userMenus').html('');
            //     }
            // });

            // $('#nestable').on('change', function() {
            //     var menuOrder = $('#nestable').nestable('serialize');
            //     var serializedMenu = JSON.stringify(menuOrder);
            //     console.log(serializedMenu);

            //     $.ajax({
            //         type: 'POST',
            //         url: "{{ route('update.menu.order') }}",
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //             menuOrder: serializedMenu
            //         },
            //         success: function(response) {
            //             console.log(response);
            //         },
            //         error: function(error) {
            //             console.log(error);
            //         }
            //     });
            // });

//             function editMenu(id) {
//                 $.ajax({
//                     type: 'GET',
//                     url: "{{ route('getMenu', '') }}" + "/" + id,
//                     success: function(response) {
//                         const {
//                             title,
//                             slug,
//                             icon,
//                             path,
//                             level
//                         } = response;
//                         Swal.fire({
//                             title: 'Edit Menu',
//                             html: `
//                 <div class="mb-6 text-left">
//     <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
//     <input type="text" id="title" name="title" value="${title}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" required>
// </div>
// <div class="mb-6 text-left">
//     <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
//     <input type="text" id="slug" name="slug" value="${slug}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" required>
// </div>
// <div class="mb-6 text-left">
//     <label for="icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Icon</label>
//     <input type="text" id="icon" name="icon" value="${icon}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" required>
// </div>
// <div class="mb-6 text-left">
//     <label for="path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Path</label>
//     <input type="text" id="path" name="path" value="${path}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" required>
// </div>
// <div class="mb-6 text-left hidden">
//     <label for="level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Level</label>
//     <input type="text" id="level" name="level" value="${level}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" required>
// </div>
//                 `,
//                             showCancelButton: true,
//                             preConfirm: () => {
//                                 const updatedData = {
//                                     title: $('#title').val(),
//                                     slug: $('#slug').val(),
//                                     icon: $('#icon').val(),
//                                     path: $('#path').val(),
//                                     level: $('#level').val()
//                                 };
//                                 $.ajaxSetup({
//                                     headers: {
//                                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
//                                             .attr('content')
//                                     }
//                                 });
//                                 $.ajax({
//                                     type: 'POST',
//                                     url: "{{ route('singleMenuUpdate', '') }}" +
//                                         "/" + id,
//                                     data: updatedData,
//                                     success: function(response) {
//                                         console.log(response)
//                                         $('#nestable').empty();
//                                         $('#nestable').html(response);
//                                         swalWithBootstrapButtons.fire(
//                                             'Updated',
//                                             'Menu has been updated',
//                                             'success'
//                                         )
//                                     },
//                                     error: function(error) {
//                                         console.error(
//                                             'Error updating the menu');
//                                     }
//                                 });
//                             }
//                         });
//                     },
//                     error: function(error) {
//                         console.error('Error fetching menu data');
//                     }
//                 });
//             }


//             function deleteMenu(id) {
//                 $.ajax({
//                     type: 'get',
//                     url: "{{ route('deleteMenu', '') }}" + "/" + id,
//                     success: function(response) {
//                         $('#nestable').empty();
//                         $('#nestable').html(response);
//                         swalWithBootstrapButtons.fire(
//                             'Deleted',
//                             'Menu is deleted',
//                             'success'
//                         )
//                     }
//                 });
//             }

//             $('#menu-form').on('click', '#edit_menu', function(event) {
//                 event.preventDefault();
//                 const menuId = $(this).closest('.dd-item').data('id');
//                 editMenu(menuId);
//             });
//             $('#menu-form').on('click', '#delete_menu', function(event) {

//                 event.preventDefault();

//                 swalWithBootstrapButtons.fire({
//                     title: 'Are you sure?',
//                     text: "You won't be able to revert this!",
//                     icon: 'warning',
//                     showCancelButton: true,
//                     confirmButtonText: 'Yes, delete it!',
//                     cancelButtonText: 'No, cancel!',
//                     reverseButtons: true
//                 }).then((result) => {
//                     if (result.isConfirmed) {
//                         const menuId = $(this).closest('.dd-item').data('id');
//                         deleteMenu(menuId);
//                         swalWithBootstrapButtons.fire(
//                             'Deleted!',
//                             'Your file has been deleted.',
//                             'success'
//                         )
//                     } else if (
//                         result.dismiss === Swal.DismissReason.cancel
//                     ) {
//                         swalWithBootstrapButtons.fire(
//                             'Cancelled',
//                             'Your imaginary file is safe :)',
//                             'error'
//                         )
//                     }
//                 })

//             });
//         });


    })
    </script>
@endsection
